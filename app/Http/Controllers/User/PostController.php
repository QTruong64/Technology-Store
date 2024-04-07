<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    private $post, $categoryPost;
    public function __construct(Post $post, CategoryPost $categoryPost)
    {
        $this->post = $post;
        $this->categoryPost = $categoryPost;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->post->where('status', 0)->orderBy('id', 'desc')->get();
        $post_view = $this->post->where('status', 0)->orderBy('view', 'desc')->take(5)->get();
        $post_archive = $this->post->select('posts.*', DB::raw('COUNT(created_at) as count'))
            ->where([[DB::raw('YEAR(created_at)'), now()->format('Y')], ['status', 0]])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->distinct()
            ->get();
        $types = $this->categoryPost->where('status', 0)->take(5)->get();

        return view('User.Post.post', compact('posts', 'post_view', 'post_archive', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd(str()->random());
        $post_view = $this->post->where('status', 0)->orderBy('view', 'desc')->take(5)->get();
        $post_archive = $this->post->select('posts.*', DB::raw('COUNT(created_at) as count'))
            ->where([[DB::raw('YEAR(created_at)'), now()->format('Y')], ['status', 0]])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->distinct()
            ->get();
        $types = $this->categoryPost->where('status', 0)->take(5)->get();

        $view = 'User.Post.detail';
        $show = 'post';

        $post = $this->post->resolveRouteBinding($id);
        if ($post) {
            $post->update(['view' => $post->view + 1]);
        } else {
            return view('errors.404');
        }

        $posts = $this->post->where('type_id', $id)->get();
        if (count($posts) > 0 || isset($_GET['slug'])) {
            $view = 'User.Post.post';
            $show = 'posts';
        }

        return view($view, compact($show, 'post_view', 'post_archive', 'types'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts = $this->post->where([[DB::raw('MONTH(created_at)'), $id], ['status', 0]])->get();
        $post_view = $this->post->where('status', 0)->orderBy('view', 'desc')->take(5)->get();
        $post_archive = $this->post->select('posts.*', DB::raw('COUNT(created_at) as count'))
            ->where([[DB::raw('YEAR(created_at)'), now()->format('Y')], ['status', 0]])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->distinct()
            ->get();
        $types = $this->categoryPost->where('status', 0)->take(5)->get();

        return view('User.Post.post', compact('posts', 'post_view', 'post_archive', 'types'));
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
