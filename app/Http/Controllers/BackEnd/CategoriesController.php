<?php

namespace App\Http\Controllers\BackEnd;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    private $page, $category;
    private $adminHelper;
    public function __construct(Category $categories, AdminHelper $adminHelper)
    {
        $this->page = 6;
        $this->category = $categories;
        $this->adminHelper = $adminHelper;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = $this->category->orderBy('id')->paginate($this->page);
        $categoryCount = $this->category->all()->count();
        return view('BackEnd.Categories.categories', compact('category', 'categoryCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $html = $this->adminHelper->dataTree('');
        return view('BackEnd.Categories.action', compact('html'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->category->create([
            'name' => ucwords($request->name),
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id == 0 ? null : $request->parent_id,
        ]);

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
        $category = $this->category->find($id);
        $html = $this->adminHelper->dataTree($category->parent_id);
        return view('BackEnd.Categories.action', compact('html', 'category'));
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
        $category = $this->category->find($id);
        $category->name = ucwords($request->name);
        $category->parent_id = $request->parent_id == 0 ? null : $request->parent_id;
        $category->save();

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
        $this->category->find($id)->delete();
        return back();
    }
}
