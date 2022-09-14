<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table='tags';
    protected $guarded=[];

    function productmethode(){
        return $this->belongsToMany(Product::class , 'product_tag','tag_id','product_id','id','id');
    }
}
