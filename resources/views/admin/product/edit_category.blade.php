@extends('admin.layouts.admin')
@section("title")
    create_product
@endsection

@section('script')
<script>
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
                <h5 class="font-weight-bold">ویرایش دسته بندی محصول :  {{ $product->name  }}  </h5>
            </div>
            <hr>
            @include('admin.sections.alerterror')
            <form action="{{ route('admin.product.categories.update_category',['product'=>$product->id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                    <div class="col-12 ">
                        <div class="row justify-content-around">

                        <div class="form-group col-4">
                            <label>دسته بندی</label>
                            <select class="form-control border bg-white" id="categoryselect" name="category_id">
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{$category->id == $product->category_id ? "selected" : ""}}>{{$category->name}}-{{$category->parentmethode->name}}</option>
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
                    <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>

            </form>
        </div>
    </div>
@endsection

