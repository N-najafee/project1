<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners=Banner::latest()->paginate(5);
        return view("admin.banner.index",compact('banners'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.banner.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'image'=>'required|mimes:svg,jpg,png,jpeg',
           'priority'=> 'required|integer',
           'type'=>'required',
        ]);
        $imagename=generatefilename($request->image->getclientoriginalname());
        $request->image->move(public_path(env('BANNER_IMAGES_UPLOAD_PATH')),$imagename);
        Banner::create([
            'image'=>$imagename,
            'title'=>$request->title,
            'text'=>$request->text,
            'type'=>$request->type,
            'priority'=>$request->priority,
            'is_active'=>$request->is_active,
            'button_text'=>$request->button_text,
            'button_link'=>$request->button_link,
            'button_icon'=>$request->button_icon,
        ]);

        alert()->success("با تشکر","بنر با موفقیت ایجاد گردید");
        return redirect()->route("admin.banners.index");
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
    public function edit(Banner  $banner)
    {
        return view('admin.banner.edit',compact('banner'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image'=>'nullable|mimes:svg,jpg,png,jpeg',
            'priority'=> 'required|integer',
            'type'=>'required',
        ]);
        if($request->has('image')) {
            $imagename = generatefilename($request->image->getclientoriginalname());
            $request->image->move(public_path(env('BANNER_IMAGES_UPLOAD_PATH')), $imagename);
        }

        $banner->update([
            'image'=>$request->has('image') ? $imagename : $banner->image,
            'title'=>$request->title,
            'text'=>$request->text,
            'type'=>$request->type,
            'priority'=>$request->priority,
            'is_active'=>$request->is_active,
            'button_text'=>$request->button_text,
            'button_link'=>$request->button_link,
            'button_icon'=>$request->button_icon,
        ]);

        alert()->success("با تشکر","بنر مورد نظر ویرایش گردید");
        return redirect()->route("admin.banners.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        alert()->success("با تشکر","بنر مورد نظر حذف گردید");
        return redirect()->route("admin.banners.index");
    }
}
