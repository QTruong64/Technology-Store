<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderCustomer;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrdersController extends Controller
{
    private $page;
    private $product, $order, $orderDetail, $orderCustomer, $user;
    public function __construct(Order $orders, OrderDetail $orderDetails, OrderCustomer $orderCustomers, Product $products, User $users)
    {
        $this->page = 6;
        $this->order = $orders;
        $this->orderDetail = $orderDetails;
        $this->orderCustomer = $orderCustomers;
        $this->product = $products;
        $this->user = $users;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = $this->order->orderBy('id')->paginate($this->page);
        $Count = $this->order->all()->count();
        return view('BackEnd.Orders.orders', compact('order', 'Count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sanpham = $this->product->where('status', 0)->get();
        $users = $this->user->all();
        return view('BackEnd.Orders.action', compact('sanpham', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $infoUser = explode('|', $request->thongTinNguoiDung);
        $idUser = trim($infoUser[0], 'ND');
        $debt = floatval(preg_replace('/[^\d.]/', '', $request->congNo));

        if (isset($request->thongTinNguoiNhanKhac)) {
            $data = [
                'userId' => $idUser,
                'name' => $request->otherName,
                'phone' => $request->otherPhone,
                'address' => $request->otherAddress,
                'note' => $request->ghiChu,
            ];
        } else {
            $user = $this->user->find($idUser);
            $data = [
                'userId' => $idUser,
                'name' => $user->name,
                'phone' => $user->phone,
                'address' => $user->address,
                'note' => $request->ghiChu,
            ];
        }
        $customer = $this->orderCustomer->create($data);

        $order = $this->order->create([
            'cusId' => $customer->id,
            'discountId' => null,
            'totalPrice' => $request->tongTien,
            'debt' => $debt,
            'status' => $request->tinhTrangGiaoHang,
            'payment' => $request->hinhThucThanhToan,
        ]);

        foreach ($request->name as $key => $item) {
            $infoPro = explode('|', $request->name[$key]);
            $idPro = trim($infoPro[0], 'SP');
            $price = floatval(preg_replace('/[^\d.]/', '', $request->price[$key]));

            $this->orderDetail->create([
                'orderId' => $order->id,
                'proId' => $idPro,
                'qtyBuy' => $request->qty[$key],
                'price' => $price,
            ]);
        }

        return redirect()->back()->with('message', ['success' => 'Thành công (^-^)']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $qrcode = QrCode::size(120)->generate('Welcome to PhongVan !');
        $order = $this->order->find($id);
        $pdf = Pdf::loadView('BackEnd.Pdf.order_pdf', compact('order', 'qrcode'));
        return $pdf->stream('DH' . $order->id . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = $this->order->find($id);
        $users = $this->user->all();
        $sanpham = $this->product->where('status', 0)->get();

        return view('BackEnd.Orders.action', compact('order', 'users', 'sanpham'));
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
        $infoUser = explode('|', $request->thongTinNguoiDung);
        $idUser = trim($infoUser[0], 'ND');
        $debt = floatval(preg_replace('/[^\d.]/', '', $request->congNo));

        if (isset($request->thongTinNguoiNhanKhac)) {
            $data = [
                'userId' => $idUser,
                'name' => $request->otherName,
                'phone' => $request->otherPhone,
                'address' => $request->otherAddress,
                'note' => $request->ghiChu,
            ];
        } else {
            $user = $this->user->find($idUser);
            $data = [
                'userId' => $idUser,
                'name' => $user->name,
                'phone' => $user->phone,
                'address' => $user->address,
                'note' => $request->ghiChu,
            ];
        }
        $this->orderCustomer->find($request->hiddenIdCus)->update($data);
        $debt_status = $request->tinhTrangGiaoHang == 4 ? 0 : $debt;

        $this->order->find($id)->update([
            // 'totalPrice' => $request->tongTien,
            'debt' => $debt_status,
            'status' => $request->tinhTrangGiaoHang,
            'payment' => $request->hinhThucThanhToan,
        ]);
        $arr1 = [];
        $arr2 = [];
        $detail = $this->orderDetail->where('orderId', $id)->get();
        foreach ($detail as $key => $item) {
            $arr1[$key] = intval($item->proId);
        }
        foreach ($request->name as $key => $item) {
            $infoPro = explode('|', $request->name[$key]);
            $idPro = trim($infoPro[0], 'SP');
            $arr2[$key] = intval($idPro);
        }

        foreach ($arr2 as $key => $item) {
            $price = floatval(preg_replace('/[^\d.]/', '', $request->price[$key]));
            $this->orderDetail->whereIn('proId', $arr2)->updateOrCreate(
                [
                    'proId' => $item,
                ],
                [
                    'orderId' => $id,
                    'proId' => $item,
                    'qtyBuy' => $request->qty[$key],
                    'price' => $price,
                ]
            );
            if ($arr1 != $arr2) {
                $this->orderDetail->whereNotIn('proId', $arr2)->delete();
            }
        }

        return redirect()->back()->with('message', ['success' => 'Thành công (^-^)']);
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
