<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private $page, $discount;
    public function __construct(Discount $discounts)
    {
        $this->page = 6;
        $this->discount = $discounts;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupon = $this->discount->orderBy('id')->paginate($this->page);
        $Count = $this->discount->all()->count();
        return view('BackEnd.Coupon.coupon', compact('coupon', 'Count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('BackEnd.Coupon.action');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coupon = new $this->discount();
        $coupon->code = $request->code;
        $coupon->price = floatval(preg_replace('/[^\d.]/', '', $request->price));
        $coupon->start = $request->start;
        $coupon->end = $request->end;
        $coupon->status = $request->status;
        $coupon->save();

        return redirect()->back();
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
        $coupon = $this->discount->find($id);
        return view('BackEnd.Coupon.action', compact('coupon'));
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
        $coupon = $this->discount->find($id);
        $coupon->code = $request->code;
        $coupon->price = floatval(preg_replace('/[^\d.]/', '', $request->price));
        $coupon->start = $request->start;
        $coupon->end = $request->end;
        $coupon->status = $request->status;
        $coupon->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->discount->find($id)->delete();
        return back();
    }
}
