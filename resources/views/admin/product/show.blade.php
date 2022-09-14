@extends('admin.layouts.admin')
@section("title")
   show-product
@endsection

@section('script')
    <script>
$('#tag').selectpicker();
    </script>
@endsection

@section('content')


    <!-- Content Row -->
    <div class="row ">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">نمایش محصول : {{$product->id}}</h5>
            </div>
            <hr>
                <div class="row mt-5 ">
                    <div class="form-group  col-3 ">
                        <label >نام</label>
                        <input type="text" value="{{$product->name}}" disabled class="form-control" >
                    </div>
                    <div class="form-group   ">
                        <label >نام برند</label>
                        <input type="text" value="{{$product->showbrand->name}}" disabled   class="form-control" >
                    </div>
                    <div class="form-group  col-3 ">
                        <label >دسته بندی</label>
                        <input type="text" value="{{$product->showcategory->name}}" disabled   class="form-control" >

                    </div>

                    <div class="form-group col-3">
                        <label >نام تگ</label>
                        <div class="form-control " style="background-color: #eaecf4">
                            @foreach($product->tagmethode as $tag)
                           {{$tag->name}}{{$loop->last ? "" : ","}}
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group  col-3">
                        <label >تاریخ ایجاد</label>
                        <input type="text"  value="{{verta($product->created_at)}}" disabled  class="form-control" >
                    </div>
                    <div class="form-group  col-3">
                        <label >آیکون</label>
                        <input type="text"  value="{{$product->icon}}" disabled  class="form-control" >
                    </div>
                    <div class="form-group  col-3">
                        <label >وضعیت</label>
                        <input type="text"  value="{{($product->is_active)}}" disabled  class="form-control" >
                    </div>
                    <div class="col-12">
                    <div class="form-group">
                        <label >توضیحات</label>
                        <textarea class="col-12 form-control"  readonly  rows="5">  {{$product->description}}</textarea>
                    </div>
                    </div>
            <div  class="col-12">
                <hr>
                <p> هزینه ارسال : </p>
            </div>
            <div class="col-12 d-flex">
            <div class="form-group col-md-3">
                <label>هزینه ارسال </label>
                <input class="form-control "  type="text" value="{{$product->delivery_amount_products}}" disabled>
            </div>
            <div class="form-group col-md-3">
                <label >هزینه ارسال محصول اضافی </label>
                <input class="form-control "  type="text" value="{{$product->delivery_amount_pre_products}}" disabled>
            </div>
            </div>

            <div  class="col-12">
                <hr>
                <p> ویژگی ها : </p>
            </div>
            <div class="col-12 d-flex">
                @foreach($productattributes as $attributevalue)
                <div class="form-group col-md-3">
{{--                    <label>{{($attributevalue->attributes->name)}}</label>--}}
                    <label>{{$attributevalue->attributes->name}}</label>
                    <input class="form-control "  type="text" value="{{($attributevalue->value)}}" disabled>
                </div>
                @endforeach
            </div>

                @foreach($productvariations as $variation )
                        <div class="col-12 mt-5 ">
                            <hr>
                        <div class="row">
                        <div  class="d-flex justify-content-start">

                        <p> قیمت و موجودی برای متغییر {{ $variation->variationattribute->name }} : <h5>({{$variation->value}})</h5>  </p>
                        <p>
                            <button class="btn btn-sm btn-primary mr-3" type="button" data-toggle="collapse" data-target="#collaps-{{$variation->id}}">
                                نمایش
                            </button>
                        </p>
                    </div>
                    </div>
                        <div class="col-12 d-flex">
                        <div class="collapse" id="collaps-{{$variation->id}}">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>قیمت </label>
                                        <input class="form-control "  type="text" value="{{$variation->price}}" disabled>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>تعداد </label>
                                        <input class="form-control "  type="text" value="{{$variation->quantity}}" disabled>
                                    </div>
                                    <div class="form-group col-4">
                                        <label> انبار</label>
                                        <input class="form-control "  type="text" value="{{$variation->sku}}" disabled>
                                    </div>

                                    <div class="form-group col-4">
                                        <label>قیمت حراجی </label>
                                        <input class="form-control "  type="text" value="{{$variation->sale_price}}" disabled>
                                    </div>
                                    <div class="form-group col-4">
                                        <label> تاریخ شروع حراجی </label>
                                        <input class="form-control "  type="text" value="{{$variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from)}}" disabled>
                                    </div>
                                    <div class="form-group col-4">
                                        <label> تاریخ پایان حراجی</label>
                                        <input class="form-control "  type="text" value="{{$variation->date_on_sale_to == null ? null : verta($variation->date_on_sale_to)}}" disabled>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
            <div class="col-12 mt-5 ">
                <hr>
                        <h5> تصاویر محصول :   </h5>
            </div>
                   <div class="col-3 ">
                    <h5>تصویر اصلی محصول</h5>
                    <div class="card-img">
                   <img class="card-img-top" src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH')."/".$product->primary_image)}}" >
                   </div>
                </div>


                <div class="col-12 mt-4">
                    <hr>
                    <h5>   سایر تصاویر محصول : </h5>
                </div>

            <div class="row d-flex">
                        @foreach($product->productimages as $productimage)
                <div class="col-3 mt-3">
                        <div class="card-img">
                            <img  class="card-img-top" src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH')."/".$productimage->image)}}" >
                        </div>
                </div>

                        @endforeach
            </div>


                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </div>

    </div>



@endsection

