<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table='categories';
    protected $guarded=[];

    function getIsActiveAttribute($value){
        return $value ? "فعال" : 'غیرفعال';
    }

    function attributemethode(){
        return $this->belongsToMany(Attribute::class ,'attribute_category',"category_id","attribute_id","id","id");

    }

    function parentmethode(){

        return $this->belongsTo(Category::class,'parent_id');
    }

    function childmethode(){

        return $this->hasMany(Category::class,'parent_id');
    }


}
