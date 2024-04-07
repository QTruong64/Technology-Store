<?php

namespace App\Http\Controllers\User;

use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class CartController extends Controller
{
    private $_api_context;
    private $itemList;
    private $paymentCurrency;
    private $totalAmount;
    private $showResult;

    public function __construct(DataHelper $dataHelper)
    {
        /** setup PayPal api context **/
        $paypal_conf = config('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
        // Set mặc định đơn vị tiền để thanh toán
        $this->paymentCurrency = "USD";

        // Khởi tạo total amount
        $this->totalAmount = 0;

        $this->showResult = $dataHelper;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('User.Cart.cart');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('User.Cart.checkout');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->payment == 1) {
            $vndToUsd = 0.0000429748;
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            foreach (Cart::content() as $cart) {
                $this->totalAmount += $cart->qty * $cart->price;
                $price = $cart->price * $vndToUsd;
                $item_1 = new Item();
                $item_1->setName($cart->name) /** item name **/
                    ->setCurrency($this->paymentCurrency)
                    ->setSku($cart->id)
                    ->setQuantity($cart->qty)
                    ->setPrice($price); /** unit price **/

                $this->itemList[] = $item_1;
            }
            $total = round($this->totalAmount * $vndToUsd, 2);
            /** change arrdess **/
            $shipping = new ShippingAddress();
            $shipping->setRecipientName($request->name)
                ->setLine1($request->address)
                ->setLine2($request->note)
                ->setCity('San Jose')
                ->setState('CA')
                ->setPostalCode("95123")
                ->setCountryCode("US")
                ->setPhone($request->phone);

            $item_list = new ItemList();
            $item_list->setItems($this->itemList)
                ->setShippingAddress($shipping);

            $amount = new Amount();
            $amount->setCurrency($this->paymentCurrency)
                ->setTotal($total);

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Your transaction description');

            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(URL::route('status')) /** Specify return URL **/
                ->setCancelUrl(URL::route('status'));

            $payment = new Payment();
            $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
            try {
                $payment->create($this->_api_context);
            } catch (\Exception $ex) {
                if (config('app.debug')) {
                    Session::put('error', 'Connection timeout');
                    return Redirect::route('cart.create');
                    /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
                    /** $err_data = json_decode($ex->getData(), true); **/
                    /** exit; **/
                } else {
                    Session::put('error', 'Some error occur, sorry for inconvenient');
                    return Redirect::route('cart.create');
                    /** die('Some error occur, sorry for inconvenient'); **/
                }
            }

            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }

            /** add payment ID to session **/
            Session::put('paypal_payment_id', $payment->getId());

            if (isset($redirect_url)) {
                /** redirect to paypal **/
                return Redirect::away($redirect_url);
            }

            Session::put('error', 'Unknown error occurred');
            return Redirect::route('cart.create');
        } else {
            $this->showResult->AddOrder($request->name, $request->phone, $request->address, $request->note, 0);
            return redirect()->route('home.index')->with('success', 'Thanh toán thành công');
        }

    }

    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty($_GET['PayerID']) || empty($_GET['token'])) {
            Session::put('error', 'Payment failed');
            return Redirect::route('cart.create');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary **/
        /** to execute a PayPal account payment. **/
        /** The payer_id is added to the request query parameters **/
        /** when the user is redirected from paypal back to your site **/
        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            $data = $result->transactions[0]->item_list;
            $name = $data->shipping_address->recipient_name;
            $phone = $data->shipping_phone_number;
            $address = $data->shipping_address->line1;
            $note = $data->shipping_address->line2;

            $this->showResult->AddOrder($name, $phone, $address, $note, 1);
            return redirect()->route('home.index')->with('success', 'Thanh toán thành công');

        }
        Session::put('error', 'Payment failed');

        return Redirect::route('cart.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Cart::update($id, 0);

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Cart::update($id, request()->qty);

        return response()->json([
            'status' => 200,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}