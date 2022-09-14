<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Banner;
use App\Models\Category;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index(){
        $categories=Category::where("parent_id",0)->with('childmethode')->get();
        $sliders=Banner::where('type','slider')->orderby('priority')->get();
        $indextop=Banner::where('type','top')->orderby('priority')->get();
        $indexbottom=Banner::where('type','bottom')->orderby('priority')->get();
        return view('home.index',compact('categories','sliders','indextop','indexbottom'));

    }
}
