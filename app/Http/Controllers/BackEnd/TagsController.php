<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    private $page;
    private $tag;
    public function __construct(Tag $tag)
    {
        $this->page = 6;
        $this->tag = $tag;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Count = $this->tag->all()->count();
        $tags = $this->tag->paginate($this->page);

        return view('BackEnd.Tags.tags', compact('Count', 'tags'));
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
        $rabdom = str()->random();
        $tag = $this->tag->where('public_id', $rabdom)->get();
        $checkRand = $tag->count() > 0 ? $rabdom . $tag->count : $rabdom;
        $this->tag->create([
            'public_id' => $checkRand,
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 200,
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
        if (request()->ajax()) {
            $tag = $this->tag->find($id);

            return response()->json([
                'tag' => $tag,
            ]);
        }
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
        $this->tag->find($id)->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 200,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = $this->tag->find($id);
        $tag->TagToPostTag->delete();
        $tag->delete();

        return back();
    }
}
