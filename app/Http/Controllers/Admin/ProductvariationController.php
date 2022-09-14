<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use Carbon\Carbon;

class ProductvariationController extends Controller
{
    function store($product,$attributeid,$variations){

        $counter=count($variations['value']);
        for($i=0;$i<$counter;$i++){
            ProductVariation::create([
                'attribute_id'=>$attributeid,
                'product_id'=> $product->id,
                'value'=>$variations['value'][$i],
                'price'=>$variations['price'][$i],
                'quantity'=>$variations['quantity'][$i],
                'sku'=>$variations['sku'][$i],
            ]);
        }
    }
    function update($variations){

        foreach ($variations as $key=>$variation){
            $productvariation= ProductVariation::findOrfail($key);
            $productvariation->update([
                'price'=>$variation['price'],
                'quantity'=>$variation['quantity'],
                'sku'=>$variation['sku'],
                'sale_price'=> $variation['sale_price'],
                'date_on_sale_from'=>convertdate($variation['date_on_sale_from']),
                'date_on_sale_to'=>convertdate($variation['date_on_sale_to']),
            ]);
        }
    }

    function change($product,$attributeid,$variations){
        $counter=count($variations['value']);
        $productvariations=ProductVariation::where("product_id",$product->id)->delete();
        for ($i=0;$i<$counter;$i++){
            ProductVariation::create([
                'product_id'=>$product->id,
                'attribute_id'=>$attributeid,
                'value'=>$variations['value'][$i],
                'price'=>$variations['price'][$i],
                'sku'=>$variations['sku'][$i],
                'quantity'=>$variations['quantity'][$i],
            ]);
        }

    }


}
