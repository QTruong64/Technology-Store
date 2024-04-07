<?php

namespace App\Http\Controllers\BackEnd;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\Accessory;
use App\Models\Gallery;
use App\Models\Phone;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    private $page, $product, $phone, $gallery, $accessory;
    private $adminHelper;
    public function __construct(Product $products, Phone $phone, Accessory $accessory, Gallery $galleries, AdminHelper $adminHelper)
    {
        $this->page = 6;
        $this->product = $products;
        $this->phone = $phone;
        $this->accessory = $accessory;
        $this->gallery = $galleries;
        $this->adminHelper = $adminHelper;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->orderBy('id')->paginate($this->page);
        $productCount = $this->product->all()->count();
        return view('BackEnd.Products.products', compact('products', 'productCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $html = $this->adminHelper->dataTree('');
        $view = 'BackEnd.Products.action_phone';
        if (request()->segment(3) == 'phukien') {
            $view = 'BackEnd.Products.action_accessory';
        }
        return view($view, compact('html'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $imgDefault = $this->adminHelper->ImageResize($request->imagedefault, 'sanpham');
            $img = $request->gallery ? $this->adminHelper->ImageResize($request->gallery, 'sanpham') : null;
            $galleries = new $this->gallery();
            $galleries->imageDefault = $imgDefault;
            $galleries->image = $img;
            $galleries->save();

            if ($request->hidden_act == 'dienthoai') {
                $phone = new $this->phone();
                $phone->screen = $request->screen;
                $phone->system = $request->system;
                $phone->rear_camera = $request->rear_camera;
                $phone->front_camera = $request->front_camera;
                $phone->chip = $request->chip;
                $phone->ram = $request->ram;
                $phone->rom = $request->rom;
                $phone->sim = $request->sim;
                $phone->pin = $request->pin;
                $phone->save();
            } else {
                $accessory = new $this->accessory();
                $accessory->type = $request->type;
                $accessory->save();
            }

            $this->product->create([
                'name' => ucwords($request->name),
                'slug' => Str::slug($request->name),
                'cateId' => $request->cateid,
                'phone_id' => isset($phone) ? $phone->id : null,
                'accessories_id' => isset($accessory) ? $accessory->id : null,
                'galleryId' => $galleries->id,
                'price' => $this->adminHelper->FormatPrice($request->price),
                'description' => $request->desc,
                'qty' => 0,
                'status' => $request->status,
            ]);
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('message:' . $e->getMessage() . '---- line:' . $e->getLine());
        }

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
        $html = $this->adminHelper->dataTree($product->cateId);
        $view = 'BackEnd.Products.action_phone';
        if ($product->accessories_id != null) {
            $view = 'BackEnd.Products.action_accessory';
        }
        return view($view, compact('html', 'product'));
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
        try {
            DB::beginTransaction();

            $price = $this->adminHelper->FormatPrice($request->price);
            $products = $this->product->find($id);
            $products->name = $request->name;
            // $products->slug = Str::slug($request->name);
            $products->cateId = $request->cateid;
            if ($price >= $products->price) {
                $products->priceOld = 0;
            } else {
                $products->priceOld = $products->price;
            }
            $products->price = $price;
            $products->description = $request->desc;
            // $products->qty = $request->qty;
            $products->status = $request->status;
            $products->save();

            if ($request->hidden_act == 'dienthoai') {
                $phone = $this->phone->find($products->phone_id);
                $phone->screen = $request->screen;
                $phone->system = $request->system;
                $phone->rear_camera = $request->rear_camera;
                $phone->front_camera = $request->front_camera;
                $phone->chip = $request->chip;
                $phone->ram = $request->ram;
                $phone->rom = $request->rom;
                $phone->sim = $request->sim;
                $phone->pin = $request->pin;
                $phone->save();
            } else {
                $accessory = $this->accessory->find($products->accessories_id);
                $accessory->type = $request->type;
                $accessory->save();
            }

            $galleries = $this->gallery->find($products->galleryId);
            $img = isset($request->gallery) ? $this->adminHelper->ImageResize($request->gallery, 'sanpham') : null;
            if ($img != null) {
                $imgs = explode("|", $galleries->image);
                if (count($imgs) > 1) {
                    for ($i = 0; $i < count($imgs); $i++) {
                        if (File::exists(public_path('uploads/sanpham/') . $imgs[$i])) {
                            unlink(public_path('uploads/sanpham/') . $imgs[$i]);
                        }
                    }
                }
                $galleries->image = $img;
            }
            if (isset($request->imagedefault)) {
                if (File::exists(public_path('uploads/sanpham/') . $galleries->imageDefault)) {
                    unlink(public_path('uploads/sanpham/') . $galleries->imageDefault);
                }
                $imgDefault = $this->adminHelper->ImageResize($request->imagedefault, 'sanpham');
                $galleries->imageDefault = $imgDefault;
            }
            $galleries->save();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('message:' . $e->getMessage() . '---- line:' . $e->getLine());
        }
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
        $this->product->find($id)->delete();
        return back();
    }
}
