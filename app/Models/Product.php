<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{



    use HasFactory , sluggable;

    protected $table='products';
    protected $guarded=[];
    function tagmethode(){
        return $this->belongsToMany(Tag::class , 'product_tag','product_id','tag_id','id','id');
    }

    function showbrand(){
        return $this->belongsTo(Brand::class,'brand_id',"id");
    }

    function showcategory(){
        return $this->belongsTo(Category::class , "category_id","id");
    }

    function getISActiveAttribute($value){
        return $value ? 'فعال': 'غیرفعال';
    }

    function productattributesmethode(){
        return $this->hasMany(ProductAttribute::class,"product_id","id");
    }

    function productvariationmethode(){
        return $this->hasmany(ProductVariation::class,"product_id","id");
    }

    function productimages(){
        return $this->hasMany(ProductImage::class,"product_id","id");
    }

        public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

}
