<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryPostController extends Controller
{
    private $page;
    private $categoryPost, $post;
    public function __construct(CategoryPost $categoryPost, Post $post)
    {
        $this->page = 6;
        $this->categoryPost = $categoryPost;
        $this->post = $post;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Count = $this->categoryPost->count();
        $types = $this->categoryPost->paginate($this->page);
        return view('BackEnd.CategoriesPost.category_post', compact('Count', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('BackEnd.CategoriesPost.action');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->categoryPost->create([
            'name' => ucwords($request->name),
            'status' => $request->status,
        ]);

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
        $type = $this->categoryPost->find($id);
        return view('BackEnd.CategoriesPost.action', compact('type'));
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
        $type = $this->categoryPost->find($id);
        if (count($type->TypeToPost) > 0) {
            $post_status = 0;
            if ($request->status == 1) {
                $post_status = 1;
            }
            $this->post->where('type_id', $id)->update(['status' => $post_status]);
        }
        $type->update([
            'name' => ucwords($request->name),
            'status' => $request->status,
        ]);
        return redirect()->route('loaibaiviet.index')->with('message', ['success' => 'Thành công (^-^)']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->categoryPost->find($id)->delete();

        return redirect()->back()->with('message', ['success' => 'Thành công (^-^)']);
    }
}
