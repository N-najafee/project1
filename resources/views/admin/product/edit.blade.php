@extends('admin.layouts.admin')
@section("title")
    create_category
@endsection

@section('script')
    <script>
$('#brand_id').selectpicker();
$('#tag_ids').selectpicker();

let productvariationdate= @json($productvariations);
productvariationdate.forEach(function(element){

    $(`#saledatefrom-${element.id}`).MdPersianDateTimePicker({
        targetTextSelector: `#inputsaledatefrom-${element.id}`,
        englishNumber: true,
        enableTimePicker: true,
        textFormat: 'yyyy-MM-dd HH:mm:ss',
    });

    $(`#saledateto-${element.id}`).MdPersianDateTimePicker({
        targetTextSelector: `#inputsaledateto-${element.id}`,
        englishNumber: true,
        enableTimePicker: true,
        textFormat: 'yyyy-MM-dd HH:mm:ss',
    })
})

    </script>

@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش محصول  </h5>
            </div>
            <hr>
            @include('admin.sections.alerterror')
            <form action="{{ route('admin.products.update',['product'=>$product->id]) }}" method="POST">
                @method('put')
                @csrf
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control @error('name') {{'is-invalid'}} @enderror" id="name" name="name" type="text" value="{{$product->name}}">
                      @error('name')  <p class="invalid-feedback"> {{$message}}</p>@enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active" type="text">
                        <option value="1" {{$product->getraworiginal('is_active') ? "selected" : ''}}>فعال</option>
                        <option value="0" {{$product->getraworiginal('is_active') ? '' : "selected" }}>غیرفعال</option>
                        </select>
                    </div>
                <div class="form-group col-md-3">
                    <label for="brand_id">برند</label>
                    <select  id="brand_id" name="brand_id" class="form-control" >
                        @foreach($brands as $brand)
                            <option  value="{{$brand->id}}" {{$brand->id == $product->brand_id ? "selected" : ''}}  >{{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>

                    <div class="form-group col-md-3">
                        <label for="tag_ids">تگ</label>
                        <select  id="tag_ids" name="tag_ids[]" multiple class="form-control" >
                            @foreach($tags as $tag)
                                <option  value="{{$tag->id}}" {{in_array($tag->id,$product->tagmethode()->pluck('id')->toarray())? "selected" : ''}}  >{{$tag->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control " rows="3" id="description" name="description" > {{$product->description}}</textarea>
                    </div>
                <div  class="col-12">
                    <hr>
                    <p> هزینه ارسال : </p>
                </div>
                <div class="form-group col-md-3">
                    <label for="delivery_amount">هزینه ارسال </label>
                    <input class="form-control " id="delivery_amount" name="delivery_amount" type="text" value="{{$product->delivery_amount_products}}">
                </div>
                <div class="form-group col-md-3">
                    <label for="delivery_amount_per_product">هزینه ارسال محصول اضافی </label>
                    <input class="form-control " id="delivery_amount_per_product" name="delivery_amount_per_product" type="text" value="{{$product->delivery_amount_pre_products}}">
                </div>
                    <div class="col-12">
                        <hr>
                        <h5> ویژگی ها و دسته بندی :  </h5>
                    </div>
                    <div class="col-12 " id="showattribute">
                        <div class="row" id="attributes">
                            @foreach($productattributes as $productattribute )
                            <div class="form-group col-3">
                                <label>{{$productattribute->attributes->name}}</label>
                                <input class="form-control" name="attribute_values[{{$productattribute->id}}]" value="{{$productattribute->value}}">
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="col-12 mt-5 ">
                    <hr>
                    @foreach($productvariations as $productvariation)
                    <div class="row mt-3">
                        <div  class="d-flex justify-content-start">
                            <p> قیمت و موجودی برای متغییر  : <h5>{{$productvariation->value}}</h5>  </p>
                            <p>
                                <button class="btn btn-sm btn-primary  mr-3" type="button" data-toggle="collapse" data-target="#collaps-{{$productvariation->id}}">
                                    نمایش
                                </button>
                            </p>
                        </div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="collapse" id="collaps-{{$productvariation->id}}">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>قیمت </label>
                                        <input class="form-control " name="variation_values[{{$productvariation->id}}][price]" type="text" value="{{$productvariation->price}}" >
                                    </div>
                                    <div class="form-group col-4">
                                        <label>تعداد </label>
                                        <input class="form-control " name="variation_values[{{$productvariation->id}}][quantity]" type="text" value="{{$productvariation->quantity}}" >
                                    </div>
                                    <div class="form-group col-4">
                                        <label> انبار</label>
                                        <input class="form-control " name="variation_values[{{$productvariation->id}}][sku]" type="text" value="{{$productvariation->sku}}" >
                                    </div>

                                    <div class="form-group col-4">
                                        <label>قیمت حراجی </label>
                                        <input class="form-control " name="variation_values[{{$productvariation->id}}][sale_price]" type="text" value="{{$productvariation->sale_price}}" >
                                    </div>
                                    <div class="form-group col-4">
                                        <label> تاریخ شروع حراجی </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend order-5"  >
                                                <span class="input-group-text"  id="saledatefrom-{{$productvariation->id}}"><i class="fas  fa-clock"></i></span>
                                            </div>
                                            <input class="form-control" id="inputsaledatefrom-{{$productvariation->id}}"  type="text" name="variation_values[{{$productvariation->id}}][date_on_sale_from]" value="{{$productvariation->date_on_sale_from == null ? null : $productvariation->date_on_sale_from}}" >
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label> تاریخ پایان حراجی</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend order-5"  >
                                                <span class="input-group-text"  id="saledateto-{{$productvariation->id}}" ><i class="fas  fa-clock"></i></span>
                                            </div>
                                            <input class="form-control " id="inputsaledateto-{{$productvariation->id}}"  type="text" name="variation_values[{{$productvariation->id}}][date_on_sale_to]"  value="{{$productvariation->date_on_sale_to ==null ? null :  $productvariation->date_on_sale_to}}" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

        <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
            </form>
        </div>
    </div>
@endsection

