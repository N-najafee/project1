@extends('admin.layouts.admin')
@section("title")
    create_product
@endsection

@section('script')
<script>
    $("#brandselect").selectpicker({
        title : "انتخاب برند"
    })
    $("#tagselect").selectpicker({
        title : "انتخاب تـــگ"
    })
    $('#primary_image').change(function (){
        let filenameprimary =$('#primary_image').val();
        $('#primary_image').next($('.custom-file-label')).html(filenameprimary)

    })

    $('#images').change(function (){
        let filenameimage = $('#images').val();
        $('#images').next($(".custom-file-label")).html(filenameimage)
    })
    $('#categoryselect').selectpicker({
        title : "انتخاب ویژگی"
    })
// change for javascript Or on(changed.bs.select) for bootstrapselect , dont defrence

    $('#show').hide();
    $('#categoryselect').change(function (){
        let categoryselected=$('#categoryselect').val();

        $.get(`{{url('/admin-panel/management/category_attributes/${categoryselected}')}}`,function (response , status){
          if(status === "success") {
              // console.log(response.attributescategory)
              let attributestatic=(response.attributescategory)
              let variation=response.attributevariation
              $('#show').fadeIn();
              $(`#addinputattribute`).find('div').remove();
              attributestatic.forEach(function($item){
                  let divgroup=$(`<div/>`,{
                      class : "form-group col-3"
                  });

                  let label=$(`<label/>`,{
                      for : $item.name,
                      text : $item.name,
                  });

                  let inputtag=$(`<input/>`,{
                      id : $item.name,
                      type : "text",
                      class : 'form-control',
                      name : `attribute_ids[${$item.id}]`,
                  });

                  divgroup.append(label);
                  divgroup.append(inputtag);
                  $(`#addinputattribute`).append(divgroup);
              })



              $(`#addvariation`).text(variation.name);
          }
        }).fail(function (){
            alert("خطای آدرس");
        })
    })

    $("#czContainer").czMore();


</script>

   @endsection
@section('content')


    <!-- Content Row -->
    <div class="row">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد محصول جدید  </h5>
            </div>
            <hr>
            @include('admin.sections.alerterror')
            <form action="{{ route('admin.products.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control @error('name') {{'is-invalid'}} @enderror" id="name" name="name" type="text" value="{{old('name')}}">
                      @error('name')  <p class="invalid-feedback"> {{$message}}</p>@enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="brand_id">برند</label>
                        <select class="form-control border bg-white @error('brand') {{'is-invalid'}} @enderror" id="brandselect" name="brand_id" data-live-search="true">
                        @error('brand')  <p class="invalid-feedback"> {{$message}}</p>@enderror
                            @foreach($brands as $brand)
                            <option value="{{$brand->id}}"> {{$brand->name}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" >فعال</option>
                            <option value="0"  >غیرفعال</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="tag_ids">تگ </label>
                        <select class="form-control border bg-white @error('tag') {{'is-invalid'}} @enderror" id="tagselect" name="tag_ids[]" multiple title="انتخاب تگ" data-live-search="true" >
                            @error('tag')  <p class="invalid-feedback"> {{$message}}</p>@enderror
                            @foreach($tags as $tag)
                                <option value="{{$tag->id}}"> {{$tag->name}} </option>
                            @endforeach
                        </select>
                    </div>
                <div class="form-group col-12">
                    <label for="description">توضیحات</label>
                    <textarea class="form-control" id="description" name="description" rows="2" >{{old('description')}}</textarea>
                </div>
                <div  class="col-12">
                    <hr>
                    <p> تصاویر محصول : </p>
                </div>
                    <div class="row justify-content-around">
                <div class="form-group col-3">
                    <label for="primary_image"> تصویر اصلی </label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="primary_image" id="primary_image" >
                    <label class="custom-file-label" for="primary_image" >انتخاب فایل</label>
                </div>
                </div>

                <div class="form-group col-3">
                    <label for="images"> انتخاب تصاویر </label>
                    <div class="custom-file">
                        <input type="file" class="form-control custom-file-input" name="images[]" multiple id="images">
                        <label class="custom-file-label" for="images">انتخاب فایل</label>
                    </div>
                </div>
                    </div>

                    <div  class="col-12">
                        <hr>
                        <p> دسته بندی و ویژگی ها : </p>
                    </div>

                    <div class="col-12 ">
                        <div class="row justify-content-around">
                    <div class="form-group col-md-3">
                        <label for="categoryselect">دسته بندی </label>
                        <select class="form-control border bg-white @error('categoryselect') {{'is-invalid'}} @enderror" id="categoryselect" name="category_id"  data-live-search="true" >
                            @error('categoryselect')  <p class="invalid-feedback"> {{$message}}</p>@enderror
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"> {{$category->name}} - {{$category->parentmethode->name}} </option>
                            @endforeach
                        </select>
                    </div>
                        </div>
                    </div>
                    <div class="col-12" id="show">
                        <div class="row"  id="addinputattribute">  </div>

                        <div  class="col-12">
                            <hr>
                            <p>  افزودن موجودی و قیمت برای متغییر <span  class="font-weight-bold" id="addvariation" ></span> : </p>

                                <div id="czContainer">
                                    <div id="first">
                                        <div class="recordset">
                                            <div class="row">
                                            <div class="form-group col-md-3">
                                                <label >نام</label>
                                                <input class="form-control "  name="variation_values[value][]" type="text" >
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label >قیمت</label>
                                                <input class="form-control "  name="variation_values[price][]" type="text" >
                                            </div>
                                                <div class="form-group col-md-3">
                                                    <label >تعداد</label>
                                                    <input class="form-control "  name="variation_values[quantity][]" type="text" >
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label >انبار</label>
                                                    <input class="form-control "  name="variation_values[sku][]" type="text" >
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>

                    <div  class="col-12">
                        <hr>
                        <p> هزینه ارسال : </p>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="delivery_amount">هزینه ارسال </label>
                        <input class="form-control " id="delivery_amount" name="delivery_amount" type="text" value="{{old('delivery_amount')}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="delivery_amount_per_product">هزینه ارسال محصول اضافی </label>
                        <input class="form-control " id="delivery_amount_per_product" name="delivery_amount_per_product" type="text" value="{{old('delivery_amount_per_product')}}">
                    </div>
                </div>
                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>

            </form>
        </div>
    </div>
@endsection

