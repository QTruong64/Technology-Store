<?php
namespace App\Helpers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderCustomer;
use App\Models\OrderDetail;
use App\Models\Phone;
use App\Models\Product;
use App\Models\Wishlist;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DataHelper
{
    private $product, $order, $orderDetail, $orderCustomer, $discount, $phone, $wishlist, $categories;
    public function __construct(Product $product, Order $order, OrderDetail $orderDetail, OrderCustomer $orderCustomer, Discount $discount, Phone $phone, Wishlist $wishlist, Category $categories)
    {
        $this->product = $product;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
        $this->orderCustomer = $orderCustomer;
        $this->discount = $discount;
        $this->phone = $phone;
        $this->wishlist = $wishlist;
        $this->categories = $categories;
    }

    public function showCate($result, $query)
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

        $categories = $this->categories->withCount('CateToPro')
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

        $products = $this->showDataProducts($query, $boLoc, $tuKhoa, $sapXep, $mucGia, $manHinh, $ram, $rom, $result->id);

        return view('User.all', compact('products', 'random', 'randomOther', 'categories', 'screens', 'wishlists'));
    }

    public function showPro($result, $query)
    {
        $product = $result;
        $productlike = $this->product->select('products.*', DB::raw('COUNT(*) as count'), $query)
            ->where([['cateId', $product->cateId], ['status', 0], ['id', '<>', $product->id]])
            ->get();
        if ($productlike[0]['count'] == 0) {
            $productlike = $this->product->select('products.*', $query)
                ->where('status', 0)
                ->inRandomOrder()
                ->get();
        }

        return view('User.detail', compact('product', 'productlike'));
    }

    public function showDataProducts($query, $boLoc = null, $tuKhoa = null, $sapXep = null, $mucGia = [], $manHinh = [], $ram = [], $rom = [], $pageTheLoai = null)
    {
        $products = $this->product->select('products.*', $query)->with('ProToCate')->where('status', 0);
        if (!empty($pageTheLoai)) {
            $products = $products->where('cateId', $pageTheLoai);
        }
        if (!empty($boLoc)) {
            if ($boLoc != 0) {
                $products = $products->whereIn('cateId', [$boLoc]);
            }
        }
        if (!empty($mucGia)) {
            $products = $products->where(function ($query1) use ($mucGia) {
                for ($i = 0; $i < count($mucGia); $i++) {
                    $query1->orwhere(function ($query2) use ($mucGia, $i) {
                        $query2->whereBetween('price', [$mucGia[$i][0], $mucGia[$i][1]]);
                    });
                }
            });
        }
        if (!empty($manHinh)) {
            $products = $products->where(function ($query1) use ($manHinh) {
                for ($i = 0; $i < count($manHinh); $i++) {
                    $query1->orwhere(function ($query2) use ($manHinh, $i) {
                        $query2->whereRelation('ProToPhone', 'screen', 'like', '%' . $manHinh[$i] . '%');
                    });
                }
            });
        }
        if (!empty($ram)) {
            $products = $products->where(function ($query1) use ($ram) {
                for ($i = 0; $i < count($ram); $i++) {
                    $query1->orwhere(function ($query2) use ($ram, $i) {
                        $query2->whereRelation('ProToPhone', 'ram', $ram[$i]);
                    });
                }
            });
        }
        if (!empty($rom)) {
            $products = $products->where(function ($query1) use ($rom) {
                for ($i = 0; $i < count($rom); $i++) {
                    $query1->orwhere(function ($query2) use ($rom, $i) {
                        $query2->whereRelation('ProToPhone', 'rom', $rom[$i]);
                    });
                }
            });
        }
        if (!empty($tuKhoa)) {
            $products = $products->where(function ($query) use ($tuKhoa) {
                $query->orWhere('name', 'like', '%' . $tuKhoa . '%');
                $query->orWhere('description', 'like', '%' . $tuKhoa . '%');
                $query->orWhere('price', 'like', '%' . $tuKhoa . '%');
            });
        }
        if (!empty($sapXep)) {
            if ($sapXep == 'moinhat') {
                $products = $products->orderBy('created_at', 'DESC');
            } else if ($sapXep == 'banchaynhat') {
                $products = $products->leftJoin('order_details', 'order_details.proId', '=', 'products.id')
                    ->orderBy(DB::raw('SUM(order_details.qtyBuy)'), 'DESC');
            } else if ($sapXep == 'giatangdan') {
                $products = $products->orderBy('price', 'ASC');
            } else if ($sapXep == 'giagiamdan') {
                $products = $products->orderBy('price', 'DESC');
            }
        } else {
            $products = $products->orderBy('created_at', 'DESC');
        }

        return $products->get();
    }

    public function AddOrder($name, $phone, $address, $note, $payment)
    {
        try {
            DB::beginTransaction();
            $subTotal = 0;
            foreach (Cart::content() as $item) {
                $subTotal += $item->price * $item->qty;
            }
            $total = $subTotal;
            if (session()->has('coupon')) {
                $total = $subTotal - session()->get('coupon')[0]['price'];
            }

            // $data = $result->transactions[0]->item_list;
            $customer = $this->orderCustomer->create([
                'userId' => Auth::id(),
                'name' => $name,
                'phone' => $phone,
                'address' => $address,
                'note' => $note,
            ]);
            $order = $this->order->create([
                'cusId' => $customer->id,
                'discountId' => session()->has('coupon') ? session()->get('coupon')[0]['id'] : null,
                'status' => $payment == 0 ? 1 : 2,
                'totalPrice' => $total,
                'debt' => $payment == 0 ? $total : 0,
                'payment' => $payment,
            ]);
            foreach (Cart::content() as $item) {
                $this->orderDetail->create([
                    'orderId' => $order->id,
                    'proId' => $item->id,
                    'qtyBuy' => $item->qty,
                    'price' => $item->price,
                ]);
                $product = $this->product->find($item->id);
                $qty = $product->qty - $item->qty;
                $product->update(['qty' => $qty > 0 ? $qty : 0]);
            }
            if (Session::has('coupon')) {
                foreach (Session::get('coupon') as $coun) {
                    $coupon = $this->discount->where('code', $coun['code'])->first();
                    $coupon->used = ',' . Auth::id();
                    $coupon->save();
                }
            }
            Session::forget('cart');
            Session::forget('coupon');

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('message:' . $e->getMessage() . '---- line:' . $e->getLine());
            return redirect()->route('cart.create')->with('error', 'Payment failed');
        }
    }
}
