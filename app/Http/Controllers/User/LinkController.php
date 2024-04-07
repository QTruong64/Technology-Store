<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    private $wishlist, $product;
    public function __construct(Wishlist $wishlist, Product $product)
    {
        $this->wishlist = $wishlist;
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wishlist = $this->wishlist->with('WhishToPro')->where('user_id', auth()->id())->get();
        return view('User.wishlist', compact('wishlist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // session()->forget('compare');
        $products = $this->product->all();
        $products_sales = $this->product->where([['phone_id', '<>', null], ['priceOld', '<>', 0]])->get();
        return view('User.conpare', compact('products', 'products_sales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $key = $request->key;
        $productSearch = $this->product->with('ProToGall')
            ->where(function ($query) use ($key) {
                $query->orWhere('name', 'like', '%' . $key . '%');
                $query->orWhere('price', 'like', '%' . $key . '%');
            })->take(4)->get();

        return response()->json([
            'status' => 200,
            'data' => $productSearch,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->check()) {
            return back()->with('error', 'Vui lòng click <a href="' . route('authuser.signin.index') . '">ở đây</a> để đăng nhập!');
        }
        $wishlist = $this->wishlist->where([['user_id', auth()->id()], ['pro_id', $id]])->first();
        if (!isset($wishlist)) {
            $mess = 'Đã thêm yêu thích';
            $this->wishlist->create(['pro_id' => $id, 'user_id' => auth()->id()]);
        } else {
            $mess = 'Xóa yêu thích';
            $wishlist->delete();
        }

        return back()->with('success', $mess);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->product->find($id);

        if (session()->has('compare')) {
            $arr = session()->get('compare');
            if (array_key_exists($id, $arr)) {
                unset($arr[$id]);
                $mess = 'Đã xóa so sánh';
            } else {
                $mess = 'Đã thêm vào so sánh';
                $arr[$id] = [
                    'id' => $id,
                    'name' => $product->name,
                    'desc' => $product->ProToPhone,
                    'image' => $product->ProToGall->imageDefault,
                    'price' => $product->price,
                    'qty' => $product->qty,
                    'slug' => $product->slug,
                ];
            }
        } else {
            $mess = 'Đã thêm vào so sánh';
            $arr[$id] = [
                'id' => $id,
                'name' => $product->name,
                'desc' => $product->ProToPhone,
                'image' => $product->ProToGall->imageDefault,
                'price' => $product->price,
                'qty' => $product->qty,
                'slug' => $product->slug,
            ];
        }
        session()->put('compare', $arr);

        return back()->with('success', $mess);

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
