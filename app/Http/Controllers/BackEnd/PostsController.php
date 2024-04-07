<?php

namespace App\Http\Controllers\BackEnd;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    private $post, $page, $tag, $postTag;
    private $adminHelper;
    public function __construct(Post $post, AdminHelper $adminHelper, Tag $tag, PostTag $postTag)
    {
        $this->adminHelper = $adminHelper;
        $this->post = $post;
        $this->tag = $tag;
        $this->postTag = $postTag;
        $this->page = 6;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->post->paginate($this->page);
        return view('BackEnd.Posts.posts', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = $this->tag->all();
        return view('BackEnd.Posts.action', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $random = Str::random();
        $ran = $this->post->where('public_id', $random)->get();
        if ($ran) {
            $random = Str::random() . count($ran) + 1;
        }
        $post = $this->post->create([
            'public_id' => $random,
            'user_id' => auth()->id(),
            'name' => $request->name,
            'short_desc' => $request->short_desc,
            'desc' => $request->desc,
            'image' => $this->adminHelper->ImageResize($request->imagedefault, 'baiviet', 1170, 700),
        ]);
        foreach ($request->tags as $row) {
            $this->postTag->create([
                'post_id' => $post->id,
                'tag_id' => $row,
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
        $post = $this->post->find($id);
        $tags = $this->tag->all();
        return view('BackEnd.Posts.action', compact('post', 'tags'));
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
        $post = $this->post->find($id);
        if (isset($request->imagedefault)) {
            if (File::exists(public_path('uploads/baiviet/') . $post->image)) {
                unlink(public_path('uploads/baiviet/') . $post->image);
            }
            $image = $this->adminHelper->ImageResize($request->imagedefault, 'baiviet', 1170, 700);
        }
        $post->update([
            // 'public_id' => Str::random(),
            'user_id' => auth()->id(),
            'name' => $request->name,
            'short_desc' => $request->short_desc,
            'desc' => $request->desc,
            'image' => isset($image) ? $image : $post->image,
        ]);

        $tags = $request->tags;
        foreach ($tags as $row) {
            $this->postTag->where('post_id', $id)->updateOrCreate(
                [
                    'tag_id' => $row,
                ],
                [
                    'post_id' => $id,
                    'tag_id' => $row,
                ]
            );
        }
        $this->postTag->where('post_id', $id)->whereNotIn('tag_id', $tags)->delete();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->post->find($id);
        if (File::exists(public_path('uploads/baiviet/') . $post->image)) {
            unlink(public_path('uploads/baiviet/') . $post->image);
        }
        $post->delete();

        return back();
    }
}
