<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //
        $categories= Category::latest()->paginate(4);
        return view("admin.category.index",compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $parentcategories=Category::where("parent_id",'0')->get();
        $attributes=Attribute::all();
        return view('admin.category.create',compact('attributes','parentcategories'));
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
        $request->validate([
            'name'=> 'required',
            "slug"=>"required|unique:categories,slug",
            "parent_id"=>'required',
            'attributes_id'=>'required',
            'attributefilterselect_id'=>'required',
            'variationselect_id'=>'required',
        ]);

        try {
            DB::beginTransaction();
            $category=Category::create([
               'name'=>$request->name ,
                'slug'=>$request->slug,
                'parent_id'=>$request->parent_id,
                'description'=>$request->description,
                'icon'=>$request->icon,
            ]);
            foreach ($request->attributes_id as $attributid){
                $attributes=Attribute::findOrfail($attributid);
                $attributes->categorymethode()->attach($category->id,[
                    "is_filter"=> in_array($attributid , $request->attributefilterselect_id) ? 1 : 0,
                    "is_variation" => $attributid == $request->variationselect_id ? 1 : 0,
                ]);
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            alert()->error($e->getMessage(),"errro in cach")->persistent("okkkkkkkkk");
            return redirect()->back();
        }

        alert()->success("با تشکر","دسته بندی جدید ایجاد گردید")->persistent("okkkkkkkkk");
        return redirect()->route('admin.categories.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('admin.category.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {

        $parentcategories=Category::where("parent_id",0)->get();
        $attributes=Attribute::all();
        return view("admin.category.edit",compact('category','parentcategories','attributes'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
         $request->validate([
            "name" => 'required',
            'slug' => 'required|unique:categories,slug,'. $category->id,
            'parent_id' => 'required',
            'is_active' => 'required',
            'attributes_id' => 'required',
            'attributefilterselect_id' => 'required',
            'variationselect_id' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $category->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->parent_id,
                'is_active' => $request->is_active,
                'icon' => $request->icon,
                'description' => $request->description,
            ]);

            $category->attributemethode()->detach();
            foreach ($request->attributes_id as $attributeid){
             $attributeselected=Attribute::findOrfail($attributeid);
             $attributeselected->categorymethode()->attach($category->id,[
                 'is_filter'=> in_array($attributeid,$request->attributefilterselect_id) ? 1 : 0,
                 'is_variation'=> ($request->variationselect_id == $attributeid) ? 1 : 0,
             ]);
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            alert()->error($e->getMessage(),"خطا در ویرایش")->persistent("okkkkkkk");
            return redirect()->back();
        }
        alert()->success("با تشکر","دسته بندی ویرایش گردید")->persistent("okkkkkkkkk");
        return redirect()->route('admin.categories.index');
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

  function getcategoryattributes(Category $category){
        $ttributesall=$category->attributemethode()->wherepivot('is_variation',0)->get();
        $attribut_variation=$category->attributemethode()->wherepivot("is_variation",1)->first();
//        dd($ttributesall);
        return ['attributescategory'=>$ttributesall,'attributevariation'=>$attribut_variation];
  }
}
