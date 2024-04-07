<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderCustomer;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    private $order, $orderDetail, $orderCustomer, $user;
    public function __construct(Order $orders, User $users, OrderDetail $orderDetail, OrderCustomer $orderCustomer)
    {
        $this->order = $orders;
        $this->orderDetail = $orderDetail;
        $this->orderCustomer = $orderCustomer;
        $this->user = $users;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $status = 404;
            if (Hash::check(request()->key, auth()->user()->password)) {
                $status = 200;
            }

            return response()->json([
                'status' => $status,
            ]);
        }
        $orders = $this->order->select('a.id as cusid', 'a.userId', 'orders.*')
            ->join('order_customers as a', 'cusid', 'orders.cusId')
            ->where('a.userId', auth()->id())
            ->groupBy('orders.id')
            ->get();

        return view('User.my_account', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->user->find(auth()->id());
        $user->phone = $request->phone;
        $user->address = $request->address;
        if ($request->passwordCurrent != null) {
            $user->password = Hash::make($request->newPassword);
        }
        $user->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(request()->ajax()){
            $detail = $this->orderDetail->select('order_details.*', 'a.id as pro_id', 'a.name')
                ->join('products as a', 'a.id', 'order_details.proId')
                ->where('orderId', $id)
                ->get();
            $customer = $this->orderCustomer->select(['a.cusId', 'a.id as orderid', 'a.created_at as order_date', 'a.status', 'order_customers.*'])
                ->join('orders as a', 'a.cusId', 'order_customers.id')
                ->where('a.id', $id)
                ->first();
            $order = $this->order->find($id);

            return response()->json([
                'detail' => $detail,
                'customer' => $customer,
                'totalPrice' => number_format($order->totalPrice),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
