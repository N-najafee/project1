<?php

use App\Http\Controllers\admin\AttributeController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\TagController;
use App\Http\Controllers\home\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('admin.dashbord');
})->name('admin.panel.dashbord');

Route::prefix("admin-panel/management")->name("admin.")->group(function (){

    Route::resource('brands',BrandController::class);
    Route::resource('attributes',AttributeController::class);
    Route::resource('categories',CategoryController::class);
    Route::resource('tags',TagController::class);
    Route::resource('products',ProductController::class);
    Route::resource('banners',BannerController::class);
    Route::get('/category_attributes/{category}',[CategoryController::class,'getcategoryattributes']);
    Route::get('/products/{product}/image-edit',[ProductImageController::class,'edit'])->name("product.images.edit");
    Route::post('/products/{product}/add_image',[ProductImageController::class,'add'])->name("product.images.add");
    Route::delete('/products/{id}/image-destroy',[ProductImageController::class,'destroy'])->name("product.images.destroy");
    Route::put('/products/{product}/image-update',[ProductImageController::class,'set_primary'])->name("product.images.set_primary");
    Route::get('/products/{product}/edit_category',[ProductController::class,'edit_category'])->name("product.categories.edit_category");
    Route::put('/products/{product}/update_category',[ProductController::class,'update_category'])->name("product.categories.update_category");
});
Route::get('/get',[HomeController::class,'index']);

