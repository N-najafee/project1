@extends('admin.layouts.admin')
@section("title")
    create_banner
@endsection

@section('script')
    <script>
        $('#banner_image').change(function (){
            let imagename=$('#banner_image').val();
            $('#banner_image').next(".custom-file-label").html(imagename);
        })
    </script>
@endsection
@section('content')

    <!-- Content Row -->
   <div class="row">
       <div class="container-fluid col-12">
           <div class="col">
               <h5>ایجاد بنر </h5>
               <hr>
           </div>
           @include('admin.sections.alerterror')
           <form action="{{route('admin.banners.store')}}" method="post" enctype="multipart/form-data">
               @csrf
               <div class="row">
                   <div class="form-group col-3">
                       <label>انتخاب تصویر</label>
                       <div class="custom-file">
                           <input type="file" class="form-control custom-file-input"  name="image"  id="banner_image">
                           <label class="custom-file-label" for="banner_image"> انتخاب فایل</label>
                       </div>
                   </div>

                   <div class="form-group col-3">
                       <label for="title">عنوان </label>
                           <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}">
                   </div>

                   <div class="form-group col-3">
                       <label for="text">متن </label>
                       <input type="text" name="text" id="text" class="form-control" value="{{old('text')}}">
                   </div>

                   <div class="form-group col-3">
                       <label for="priority">اولویت </label>
                       <input type="number" name="priority" id="priority" class="form-control" value="{{old('priority')}}">
                   </div>

                   <div class="form-group col-3">
                       <label for="is_active">وضعیت</label>
                       <select name="is_active" id="is_active" class="form-control">
                           <option value="1">فعال</option>
                           <option value="0">غیر فعال</option>
                       </select>
                   </div>

                   <div class="form-group col-3">
                       <label for="type">نوع بنر </label>
                       <input type="text" name="type" id="type" class="form-control" value="{{old('type')}}">
                   </div>

                   <div class="form-group col-3">
                       <label for="button_text">متن دکمه </label>
                       <input type="text" name="button_text" id="button_text" class="form-control" value="{{old('button_text')}}">
                   </div>

                   <div class="form-group col-3">
                       <label for="button_link">لینک دکمه  </label>
                       <input type="text" name="button_link" id="button_link" class="form-control" value="{{old('button_link')}}">
                   </div>

                   <div class="form-group col-3">
                       <label for="button_icon">آیکون دکمه </label>
                       <input type="text" name="button_icon" id="button_icon" class="form-control" value="{{old('button_icon')}}">
                   </div>
               </div>
               <button class="btn btn-outline-primary mt-5" type="submit">ایجاد</button>
               <a href="{{route('admin.banners.index')}}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
           </form>

       </div>
   </div>

@endsection

