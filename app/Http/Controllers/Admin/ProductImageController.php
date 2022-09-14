<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductImageController extends Controller
{

    function uploadimage($primaryimage,$otherimages){


        $primaryimagename=generatefilename($primaryimage->getclientoriginalname());
        $primaryimage->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')),$primaryimagename);

        $otherimagesname=[];

        foreach ($otherimages as $image){
            $imagename=generatefilename($image->getclientoriginalname());
            $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')),$imagename);
            array_push($otherimagesname ,$imagename);
        }

        return ['primaryimage'=>$primaryimagename,'otherimagename'=> $otherimagesname];
    }

    function edit(Product $product){
        return view('admin.product.edit_images',compact('product'));
    }

    function add(Request $request, Product $product){

        $request->validate([
            'primary_image'=>'nullable|mimes:jpeg,gif,jpg,svg,png',
            'images.*'=>'nullable|mimes:jpeg,gif,jpg,svg,png',
        ]);

        if($request->primary_image == null && $request->images == null){

            return redirect()->back()->withErrors(["msg"=>"یکی از فیلدهای تصویر یا تصاویر محصول الزامی است"]);
        }

        try {
            DB::beginTransaction();
            if($request->has('primary_image')) {
                $primaryimagename = generatefilename($request->primary_image->getclientoriginalname());
                $request->primary_image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $primaryimagename);

                $product->update([
                    'primary_image' => $primaryimagename,
                ]);
            }
            if($request->has('images')) {
                foreach ($request->images as $image) {
                    $imagename = generatefilename($image->getclientoriginalname());
                    $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $imagename);
                    $product->productimages()->create([
                        "product_id" => $product->id,
                        "image" => $imagename,
                    ]);
                }
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            alert()->success("خطا در ویرایش تصویرمحصول","خطا")->persistent("ok");
            return  redirect()->back();
        }
        alert()->success("ویرایش تصویر محصول با موفقیت انجام گردید","با تشکر")->persistent("ok");
        return redirect()->back();
    }

    function destroy(Request $request ,$id){
        $request->validate([
            'image_id'=>'required|exists:product_images,id',
        ]);
        ProductImage::destroy($request->image_id);
        alert()->success("با تشکر", "تصویر محصول مورد نظر با موفقیت حذف گردید");
        return redirect()->back();

    }

    function set_primary(Request $request, Product  $product){
        $request->validate([
            'image_id'=>'required|exists:product_images,id',
        ]);


        $productimage=ProductImage::findorfail($request->image_id);
        $product->update([
            'primary_image'=>$productimage->image
        ]);
        alert()->success("با تشکر", "ویرایش تصویر اصلی محصول با موفقیت انجام شد ");
        return redirect()->back();
    }
}
