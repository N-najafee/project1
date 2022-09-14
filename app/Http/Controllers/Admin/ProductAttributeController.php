<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttribute;

class ProductAttributeController extends Controller
{
     function storattribute($attributes,$product){
         foreach ($attributes as $key=>$value) {
             ProductAttribute::create([
                 "product_id" =>$product->id ,
                 'attribute_id'=>$key,
                 "value"=>$value,
         ]);
         }
     }


     function update($attributvalus){

         foreach ($attributvalus as $key=>$attribute){
             $productattribute=ProductAttribute::findOrfail($key);
             $productattribute->update([
                 'value'=>$attribute,
             ]);

         }
     }

     function change($attributvalus, $product){

         $productattribute=ProductAttribute::where("product_id",$product->id)->delete();
         foreach ($attributvalus as $key=>$attriute ) {
             ProductAttribute::create([
                 'product_id'=>$product->id,
                 'attribute_id'=>$key,
                 'value'=>$attriute,
             ]);
         }

     }
}
