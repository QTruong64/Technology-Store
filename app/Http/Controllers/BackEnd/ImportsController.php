<?php

namespace App\Http\Controllers\BackEnd;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\Import;
use App\Models\ImportDetail;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ImportsController extends Controller
{
    private $page, $adminHelper;
    private $imports, $importDetail, $user, $product;
    public function __construct(Import $imports, User $user, ImportDetail $importDetail, Product $product, AdminHelper $adminHelper)
    {
        $this->page = 6;
        $this->imports = $imports;
        $this->importDetail = $importDetail;
        $this->user = $user;
        $this->product = $product;
        $this->adminHelper = $adminHelper;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Count = $this->imports->count();
        $imports = $this->imports->paginate($this->page);
        return view('BackEnd.Imports.imports', compact('imports', 'Count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = $this->user->all();
        $products = $this->product->all();

        return view('BackEnd.Imports.action', compact('users', 'products'));
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
        $total = $this->adminHelper->FormatPrice($request->tongTienHien);
        $debt = $this->adminHelper->FormatPrice($request->congNo);

        $imports = new $this->imports();
        $imports->user_id = $idUser;
        $imports->total_price = $total;
        $imports->debt = $debt;
        $imports->note = $request->note;
        $imports->save();

        foreach ($request->name as $key => $item) {
            $infoPro = explode('|', $request->name[$key]);
            $idPro = trim($infoPro[0], 'SP');
            $price = $this->adminHelper->FormatPrice($request->price[$key]);
            $qty = $request->qty[$key];

            $this->importDetail->create([
                'import_id' => $imports->id,
                'product_id' => $idPro,
                'qty' => $qty,
                'price' => $price,
            ]);

            $product = $this->product->find($idPro);
            $product->price_import = $price > 0 ? $price : $product->price_import;
            $product->qty = $qty + $product->qty;
            $product->status = 0;
            $product->save();
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
        $import = $this->imports->find($id);
        $pdf = Pdf::loadView('BackEnd.Pdf.import_pdf', compact('import'));
        return $pdf->stream('PN' . $import->id . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = $this->user->all();
        $products = $this->product->all();
        $import = $this->imports->find($id);

        return view('BackEnd.Imports.action', compact('users', 'products', 'import'));
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
        $total = $this->adminHelper->FormatPrice($request->tongTienHien);
        $debt = $this->adminHelper->FormatPrice($request->congNo);

        $imports = $this->imports->find($id);
        $imports->user_id = $idUser;
        $imports->total_price = $total;
        $imports->debt = $debt;
        $imports->note = $request->note;
        $imports->save();

        $arr1 = [];
        $arr2 = [];
        $detail = $this->importDetail->where('import_id', $id)->get();
        foreach ($detail as $key => $item) {
            $arr1[$key] = $item->product_id;
            $products = $this->product->find($item->product_id);
            $qtys = $products->qty - $item->qty;
            $products->qty = $qtys > 0 ? $qtys : 0;
            $products->save();
        }
        foreach ($request->name as $key => $item) {
            $infoPro = explode('|', $request->name[$key]);
            $idPro = trim($infoPro[0], 'SP');
            $arr2[$key] = intval($idPro);
        }

        foreach ($arr2 as $key => $item) {
            $price = $this->adminHelper->FormatPrice($request->price[$key]);
            $qty = $request->qty[$key];

            $this->importDetail->where('import_id', $id)->whereIn('product_id', $arr2)->updateOrCreate(
                [
                    'product_id' => $item,
                ],
                [
                    'import_id' => $imports->id,
                    'product_id' => $item,
                    'qty' => $request->qty[$key],
                    'price' => $price,
                ]
            );
            $product = $this->product->find($item);
            $product->price_import = $price > 0 ? $price : $product->price_import;
            $product->qty = $qty + $product->qty;
            $product->save();

            if ($arr1 != $arr2) {
                $this->importDetail->whereNotIn('product_id', $arr2)->delete();
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
        $import = $this->imports->find($id);
        foreach ($import->ImportToDetail as $row) {
            $qty = $row->ImportDetailToProduct->qty - $row->qty;
            $row->ImportDetailToProduct->qty = $qty > 0 ? $qty : 0;
            $row->ImportDetailToProduct->price_import = 0;
            $row->ImportDetailToProduct->status = 1;
            $row->ImportDetailToProduct->save();

            $row->delete();
        }
        $import->delete();

        return redirect()->back()->with('message', ['success' => 'Thành công (^-^)']);
    }
}
