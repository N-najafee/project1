<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class Attribute extends Model
{
    use HasFactory ;
    protected $table="attributes";
    protected $guarded=[];

    function categorymethode(){
        return $this->belongsToMany(Category::class,'attribute_category',"attribute_id","category_id","id","id");
    }
}
