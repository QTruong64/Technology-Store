<?php

namespace App\Http\Controllers\User;

use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Phone;
use App\Models\Post;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Wishlist;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private $showResult, $query, $category, $product, $slider, $post, $phone, $wishlist;
    public function __construct(Product $products, Category $category, Slider $slider, Post $post, Phone $phone, DataHelper $dataHelper, Wishlist $wishlist)
    {
        $this->showResult = $dataHelper;
        $this->query = DB::raw('IF(products.created_at >= "' . Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek()->toDateString() . '" AND products.created_at <= "' . Carbon::now('Asia/Ho_Chi_Minh')->endOfWeek()->toDateString() . '", 0, 1) as newPro');
        $this->category = $category;
        $this->product = $products;
        $this->phone = $phone;
        $this->slider = $slider;
        $this->post = $post;
        $this->wishlist = $wishlist;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $query = $this->query;

        $sliders = $this->slider->where('status', 0)->get();
        $newProduct = $this->product->select('products.*', $query)
            ->orderBy('products.id', 'desc')
            ->get();
        $saleProduct = $this->product->select('products.*', $query)
            ->where('priceOld', '<>', 0)
            ->get();

        $topProduct = $this->product->with('ProToCate')->select('products.*', DB::raw('COUNT(a.proId) as countPro'), $query)
            ->join('order_details as a', 'a.proId', 'products.id')
            ->groupBy('products.id')
            ->orderBy('countPro', 'desc')
            ->get();
        $cateTop3 = $this->category->select('id', 'name')->whereNull('parent_id')
            ->withCount('CateToPro')
            ->having('cate_to_pro_count', '>', 0)
            ->inRandomOrder()
            ->take(3)
            ->get();

        $posts = $this->post->orderBy('id', 'desc')->take(10)->get();

        return view('User.index', compact('sliders', 'newProduct', 'saleProduct', 'topProduct', 'cateTop3', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mucGia = [];
        $manHinh = [];
        $ram = [];
        $rom = [];
        $tuKhoa = null;
        $sapXep = null;
        $boLoc = null;
        $screens = $this->phone->select('screen')->distinct()->get();
        $wishlists = $this->wishlist->where('user_id', auth()->id())->get();

        $categories = $this->category->withCount('CateToPro')
            ->having('cate_to_pro_count', '>', 0)
            ->get();
        $random = $this->product->where('status', 0)
            ->inRandomOrder()
            ->get();
        $randomOther = $this->product->where([['status', 0], ['id', '<>', $random[0]['id']]])
            ->inRandomOrder()
            ->limit(2)
            ->get();
        $priceArray = ['duoi-2-trieu', 'tu-2-4-trieu', 'tu-4-7-trieu', 'tu-7-13-trieu', 'tu-13-20-trieu', 'tren-20-trieu'];
        if (!empty(request()->mucgia)) {
            $mucgia = explode(',', request()->mucgia);
            if (in_array($priceArray[0], $mucgia)) {
                $mucGia[] = [0, 2000000];
            }
            if (in_array($priceArray[1], $mucgia)) {
                $mucGia[] = [2000000, 4000000];
            }
            if (in_array($priceArray[2], $mucgia)) {
                $mucGia[] = [4000000, 7000000];
            }
            if (in_array($priceArray[3], $mucgia)) {
                $mucGia[] = [7000000, 13000000];
            }
            if (in_array($priceArray[4], $mucgia)) {
                $mucGia[] = [13000000, 20000000];
            }
            if (in_array($priceArray[5], $mucgia)) {
                $mucGia[] = [20000000, 999999999];
            }
        }
        if (!empty(request()->manhinh)) {
            $manHinh = explode(',', request()->manhinh);
        }
        if (!empty(request()->ram)) {
            $ram = explode(',', request()->ram);
        }
        if (!empty(request()->rom)) {
            $rom = explode(',', request()->rom);
        }
        if (!empty(request()->sapxep)) {
            $sapXep = request()->sapxep;
        }
        if (!empty(request()->txtSearch)) {
            $tuKhoa = request()->txtSearch;
        }
        if (!empty(request()->txtCate)) {
            $boLoc = request()->txtCate;
        }

        $products = $this->showResult->showDataProducts($this->query, $boLoc, $tuKhoa, $sapXep, $mucGia, $manHinh, $ram, $rom);

        return view('User.all', compact('products', 'random', 'randomOther', 'categories', 'screens', 'wishlists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // if (isset($request->addToCart)) {
        $product = $this->product->find($request->id);
        $data['id'] = $product->id;
        $data['qty'] = $request->qty;
        $data['name'] = $product->name;
        $data['price'] = $product->price;
        $data['weight'] = $product->qty;
        $data['options']['image'] = $product->ProToGall->imageDefault;
        $data['options']['slug'] = $product->slug;

        Cart::add($data);

        return response()->json([
            'status' => 200,
        ]);
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->category->where('slug', $id)->orwhere('id', $id)->first();
        if ($result) {
            return $this->showResult->showCate($result, $this->query);
        }

        $result = $this->product->where('slug', $id)->orwhere('id', $id)->first();
        if ($result) {
            return $this->showResult->showPro($result, $this->query);
        }

        abort('404');
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
