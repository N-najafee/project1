<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductVaration;
use App\Models\ProductVariation;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $products=Product::latest()->paginate(5);
        return view('admin.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        $tags = Tag::all();
        $categories=Category::Where('parent_id',"!=", 0)->get();
        return view("admin.product.create", compact('brands', 'tags','categories'));

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
           "name"=>'required',
           "brand_id"=>'required',
           "is_active"=>'required',
           "tag_ids"=>'required',
           "tag_ids.*"=>'exists:tags,id',
           "primary_image"=>'required|mimes:jpg,jpeg,png,svg',
           "images"=>'required',
           "images.*"=>'mimes:jpg,jpeg,png,svg',
            "category_id"=>'required',
            "attribute_ids"=>'required',
            "attribute_ids.*"=>'required',
            'variation_values'=>'required',
            'variation_values.*.*'=>'required',
            'variation_values.price.*'=>'integer',
            'variation_values.quantity.*'=>'integer',
            'delivery_amount'=>'required|integer',
            'delivery_amount_per_product'=>'nullable|integer',

        ]);
        try {
            DB::beginTransaction();
        $ProductImageController=new ProductImageController();
        $fileimagesname = $ProductImageController->uploadimage($request->primary_image,$request->images);

        $product=Product::create([
            'name'=>$request->name,
            'slug'=>$request->slug,
            'brand_id'=>$request->brand_id,
            'category_id'=>$request->category_id,
            'primary_image'=>$fileimagesname['primaryimage'],
            'is_active'=>$request->is_active,
            'description'=>$request->description,
            'delivery_amount_products'=>$request->delivery_amount,
            'delivery_amount_per_products'=>$request->delivery_amount_per_product,
        ]);
        foreach ($fileimagesname['otherimagename'] as $image) {
            ProductImage::create([
                'image' => $image,
                'product_id' => $product->id,
            ]);
        }

       $ProductAttributeController=new ProductAttributeController();
       $ProductAttributeController->storattribute($request->attribute_ids,$product);

        $category=Category::find($request->category_id);
        $ProductvariationController=new ProductvariationController();
        $ProductvariationController->store($product,$category->attributemethode()->wherepivot("is_variation",1)->first()->id,$request->variation_values,);

        $product->tagmethode()->attach($request->tag_ids);

        DB::commit();
    }catch (Exception $e){
            DB::rollBack();
        alert()->error($e->getMessage(),"خطا در ایجاد محصول جدید ")->persistent("ok");
        return redirect()->back();
        }

        alert()->success("با تشکر","محصول با موفقیت ایجاد گردید ");
       return redirect()->route("admin.products.index");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $productvariations=$product->productvariationmethode()->with('variationattribute')->get();
        $productattributes=$product->productattributesmethode()->with('attributes')->get();
        return view('admin.product.show',compact('product','productattributes','productvariations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $brands=Brand::all();
        $tags=Tag::all();
        $productattributes=$product->productattributesmethode()->with('attributes')->get();
        $productvariations=$product->productvariationmethode()->with('variationattribute')->get();
        return view('admin.product.edit',compact('product','brands','tags', 'productattributes','productvariations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {


        $request->validate([
           'name'=> 'required',
            'is_active'=>'required',
            'slug'=> 'unique,'.$product->id,
            'brand_id'=> 'required|exists:brands,id',
            'tag_ids'=>'required',
            "tag_ids.*"=>'exists:tags,id',
            'description'=>'required',
            'attribute_values'=>'required',
            'variation_values'=>'required',
            'variation_values.*.price' => 'required|integer',
            'variation_values.*.quantity' => 'required|integer',
            'variation_values.*.sale_price' => 'nullable|integer',
            'variation_values.*.date_on_sale_from' => 'nullable|date',
            'variation_values.*.date_on_sale_to'=>'nullable|date',
            'delivery_amount' => 'required|integer',
            'delivery_amount_per_product'=>'nullable|integer',
        ]);
        try {
            DB::beginTransaction();
        $product->Update([
            'name'=>$request->name,
           "brand_id"=>$request->brand_id,
            'is_active'=>$request->is_active,
            'description'=>$request->description,
            'delivery_amount_products'=>$request->delivery_amount,
            'delivery_amount_per_products'=>$request->delivery_amount_per_product,
        ]);

        $product->tagmethode()->detach();
        $product->tagmethode()->attach($request->tag_ids);

        $ProductAttributeController = new ProductAttributeController();
        $ProductAttributeController->update($request->attribute_values);

        $ProductvariationController= new ProductvariationController();
        $ProductvariationController->update($request->variation_values);
        DB::commit();
    }catch (\Exception $e){
            DB::rollBack();
             alert()->error("خطا در ویرایش محصول","خطا")->persistent("ok");
             return  redirect()->back();
        }
        alert()->success("ویرایش محصول با موفقیت انجام گردید","با تشکر")->persistent("ok");
        return redirect()->route("admin.products.index");
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

    function edit_category(Product $product){

        $categories=Category::where("parent_id","!=",0)->get();
        return view("admin.product.edit_category",compact('product','categories'));

    }

    function update_category(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required',
            "attribute_ids" => 'required',
            "attribute_ids.*" => 'required',
            "variation_values" => 'required',
            "variation_values.*" => 'required',
            "variation_values.*.*" => 'required',
            'variation_values.price.*' => 'integer',
            'variation_values.quantity.*' => 'integer',

        ]);
        try {
            DB::beginTransaction();

            $product->update([
                'category_id' => $request->category_id,
            ]);
            $ProductAttributeController = new ProductAttributeController();
            $ProductAttributeController->change($request->attribute_ids, $product);

            $category = Category::find($request->category_id);
            $attributeid = $category->attributemethode()->wherepivot("is_variation", 1)->first()->id;
            $ProductvariationController = new ProductvariationController();
            $ProductvariationController->change($product, $attributeid, $request->variation_values);
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            alert()->error("خطا", "خطا در ویرایش دسته بندی ");
            return redirect()->back();
        }

        alert()->success("با تشکر", ",ویرایش دسته بندی با موفقیت انجام شد");
        return redirect()->route("admin.products.index");
    }
}
