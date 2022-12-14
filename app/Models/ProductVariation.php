<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{
    use HasFactory , SoftDeletes;
    protected $table='product_variations';
    protected $guarded=[];

    function variationattribute(){
        return $this->belongsTo(Attribute::class,"attribute_id","id");

    }
}
