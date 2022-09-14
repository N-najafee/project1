@extends('admin.layouts.admin')
@section("title")
   edit image -product
@endsection

@section('script')

    <script>

        $('#primary_image').change(function (){
            let filenameprimary =$('#primary_image').val();
            $('#primary_image').next($('.custom-file-label')).html(filenameprimary)

        })

        $('#images').change(function (){
            let filenameimage = $('#images').val();
            $('#images').next($(".custom-file-label")).html(filenameimage)
        })


    </script>
@endsection

@section('content')

@include("admin.sections.alerterror")
    <!-- Content Row -->
    <div class="row ">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش تصویر محصول : {{$product->name}}</h5>
                <hr>
            </div>

            <div class="row">
               <div class="col-3">
                <h5>تصویر اصلی محصول</h5>
                <div class="card-img">
                    <img class="card-img-top" src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH')."/".$product->primary_image)}}">
                </div>
               </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <hr>
                    <h5>سایر تصاویر محصول</h5>
                </div>
                @foreach( $product->productimages as $images)
                    <div class="col-3 mt-3">
                        <div class="card-img">
                            <img class="card-img-top" src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH')."/".$images->image)}}">
                            <div class="card-body text-center">
                                <form action="{{route('admin.product.images.destroy',['id'=>$images->id])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="image_id" value="{{$images->id}}">
                                    <button  type="submit" class="btn btn-danger align-items-center " > حذف </button>
                                </form>

                                <form action="{{route('admin.product.images.set_primary',['product'=>$product->id,'id'=>$images->id])}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="image_id" value="{{$images->id}}">
                                    <button  type="submit" class="btn btn-primary mt-2 " >انتخاب بعنوان تصویر اصلی  </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <hr>

                <form action="{{route('admin.product.images.add',['product'=>$product->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="primary_image">  تصویر اصلی</label>
                            <div class="custom-file">
                                <input type="file" class="form-control custom-file-input" name="primary_image" id="primary_image">
                                <label class="custom-file-label"></label>
                            </div>
                        </div>

                        <div class="form-group col-4">
                            <label for="images" >انتخاب تصاویر</label>
                            <div class="custom-file">
                                <input type="file" class="form-control custom-file-input" name="images[]" multiple id="images" >
                                <label class="custom-file-label" for="images">انتخاب فایل</label>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
                </form>

        </div>

    </div>



@endsection

