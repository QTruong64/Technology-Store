<?php

namespace App\Http\Controllers\BackEnd;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    private $page, $slider;
    private $adminHelper;
    public function __construct(Slider $sliders, AdminHelper $adminHelper)
    {
        $this->page = 6;
        $this->slider = $sliders;
        $this->adminHelper = $adminHelper;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = $this->slider->paginate($this->page);
        return view('BackEnd.Sliders.sliders', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('BackEnd.Sliders.action');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->slider->create([
            'name' => ucwords($request->name),
            'desc' => $request->desc,
            'link' => $request->link,
            'image' => $this->adminHelper->ImageResize($request->imagedefault, 'slider', 1452, 599),
            'status' => $request->status,
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
        $slider = $this->slider->find($id);
        return view('BackEnd.Sliders.action', compact('slider'));
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
        $slider = $this->slider->find($id);
        if (isset($request->imagedefault)) {
            if (File::exists(public_path('uploads/slider/') . $slider->image)) {
                unlink(public_path('uploads/slider/') . $slider->image);
            }
            $image = $this->adminHelper->ImageResize($request->imagedefault, 'slider', 1452, 599);
        }
        $slider->update([
            'name' => ucwords($request->name),
            'desc' => $request->desc,
            'link' => $request->link,
            'image' => isset($image) ? $image : $slider->image,
            'status' => $request->status,
        ]);

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
        $this->slider->find($id)->delete();
        return redirect()->back();
    }
}
