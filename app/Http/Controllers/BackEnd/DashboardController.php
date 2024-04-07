<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $order, $orderDetail, $product, $user, $post;
    public function __construct(Order $order, OrderDetail $orderDetail, Product $product, User $user, Post $post)
    {
        $this->order = $order;
        $this->orderDetail = $orderDetail;
        $this->product = $product;
        $this->user = $user;
        $this->post = $post;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Carbon::setLocale('vi');
        $monthStart = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $monthEnd = Carbon::now('Asia/Ho_Chi_Minh')->endOfMonth()->toDateString();
        $weekStart = Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek()->toDateString();
        $weekEnd = Carbon::now('Asia/Ho_Chi_Minh')->endOfWeek()->toDateString();

        $orderCount = Order::whereBetween('created_at', [$monthStart, $monthEnd])->count();
        $productCount = $this->product->all()->sum('qty');
        $userCount = $this->user->all()->count();
        $postCount = $this->post->all()->count();

        $users = $this->user->orderBy('id', 'desc')->limit(5)->get();
        $productTop = $this->product->with('ProToCate')->select('products.*', DB::raw('COUNT(a.proId) as countPro'))
            ->join('order_details as a', 'a.proId', 'products.id')
            ->groupBy('products.id')
            ->orderBy('countPro', 'desc')
            ->get();

        $orders = $this->order
            ->select(DB::raw('DATE(created_at) as created_at'), DB::raw('SUM(totalPrice) as totalPrice'))
        // ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->whereDate('created_at', '>=', $weekStart)
            ->whereDate('created_at', '<=', $weekEnd)
            ->orderBy('created_at', 'ASC')
            ->distinct()
            ->get();

        if (count($orders) > 0) {
            $profit = 0;
            foreach ($orders as $order) {
                $detail = $this->orderDetail->whereDate('created_at', $order->created_at)->get();
                foreach ($detail as $item) {
                    $profit += $item->OrderDetailToProduct->price_import * $item->qtyBuy;
                }
                $total = $order->totalPrice;
                $chartData[] = [
                    'dayNumber' => Carbon::parse($order->created_at)->dayOfWeek,
                    'day' => Carbon::parse($order->created_at)->isoFormat('dddd'),
                    'total' => $total,
                    'profit' => $total - $profit,

                ];
                $arr[] = Carbon::parse($order->created_at)->toDateString();
            }
            $t2 = Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek();
            $t3 = Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek()->addDays(1);
            $t4 = Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek()->addDays(2);
            $t5 = Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek()->addDays(3);
            $t6 = Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek()->addDays(4);
            $t7 = Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek()->addDays(5);
            $cn = Carbon::now('Asia/Ho_Chi_Minh')->endOfWeek();

            $days = [$t2, $t3, $t4, $t5, $t6, $t7, $cn];

            for ($i = 0; $i < count($days); $i++) {
                if (!in_array($days[$i]->toDateString(), $arr)) {
                    array_push($chartData, [
                        'dayNumber' => $days[$i]->dayOfWeek,
                        'day' => $days[$i]->isoFormat('dddd'),
                        'total' => 0,
                        'profit' => 0,
                    ]);
                }
            }
            foreach ($chartData as $key => $row) {
                $count[$key] = $row['dayNumber'];
            }
            array_multisort($count, SORT_ASC, $chartData);
        } else {
            for ($i = 0; $i < 7; $i++) {
                $chartData[] = array(
                    'day' => Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek()->addDays($i)->isoFormat('dddd'),
                    'total' => 0,
                    'profit' => 0,
                );
            }
        }

        return view('BackEnd.dashboard', compact('users', 'orderCount', 'productCount', 'userCount', 'postCount', 'chartData', 'productTop'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('BackEnd.permission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $name = explode('|', $request->name);
        $permission = Permission::create([
            'name' => $name[0],
            'display_name' => $name[1],
        ]);
        foreach ($request->action as $item) {
            Permission::create([
                'name' => $item,
                'display_name' => $item,
                'parent_id' => $permission->id,
                'key_code' => $item . '_' . $name[0],
            ]);
        }

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
        //
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
