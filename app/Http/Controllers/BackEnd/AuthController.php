<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('BackEnd.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->action == 'login') {
            $check = array('email' => $request->email, 'password' => $request->password);

            if (Auth::attempt($check)) {

                $status = false;
                $roles = auth()->user()->roles;
                foreach ($roles as $role) {
                    if ($role->permissions->count() > 0) {
                        $status = true;
                    }
                }
                if ($status == true && !isset($request->level)) {
                    return redirect()->route('tongquan.index')->with('message', ' Hi, ' . Auth::user()->name . ' ');
                }
                return redirect()->route('home.index')->with('message', ' Hi, ' . Auth::user()->name . ' ');
            } else {

                return redirect()->back()->withInput()->with('message_err', 'Tên đăng nhập hoặc mật khẩu không đúng!');
            }

        }

        if ($request->action == 'register') {
            try {
                DB::beginTransaction();
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                ]);
                $user->roles()->attach(2);
                DB::commit();
                Auth::login($user);

                $orders = Order::select('a.id as cusid', 'a.userId', 'orders.*')
                    ->join('order_customers as a', 'cusid', 'orders.cusId')
                    ->where('a.userId', auth()->id())
                    ->groupBy('orders.id')
                    ->get();

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('message:' . $e->getMessage() . '---- line:' . $e->getLine());
            }
            return view('User.my_account', compact('orders'));
        }

        if ($request->action == 'logout') {
            Auth::logout();
            if (isset($request->route)) {
                return redirect()->route('auth.index');
            }
            return redirect()->route('home.index');
        }
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