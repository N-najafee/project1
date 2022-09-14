@extends('admin.layouts.admin')
@section("title")
   banner-index
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4 d-flex justify-content-between">
                <h5 class="font-weight-bold"> لیست بنر ها </h5>
                <a href="{{route('admin.banners.create')}}" class="btn btn-outline-primary">
                    ایجاد بنر
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <table class="table table-bordered table-striped text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>تصویر</th>
                    <th>عنوان</th>
                    <th>متن</th>
                    <th>اولویت</th>
                    <th>وضعیت</th>
                    <th>نوع</th>
                    <th>متن دکمه</th>
                    <th>لینک دکمه</th>
                    <th>آیکون دکمه</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($banners as $key=>$banner)
                <tr>
                    <th>{{$banners->firstitem()+$key}}</th>
                    <th><a target="_blank" href="{{url(env('BANNER_IMAGES_UPLOAD_PATH'),$banner->image)}}">{{$banner->image}}</a></th>
                    <th>{{$banner->title}}</th>
                    <th>{{$banner->text}}</th>
                    <th>{{$banner->priority}}</th>
                    <th><span class="{{$banner->getraworiginal('is_active') ? "text-success" : "text-danger"}}">{{$banner->is_active}}</span></th>
                    <th>{{$banner->type}}</th>
                    <th>{{$banner->button_text}}</th>
                    <th>{{$banner->button_link}}</th>
                    <th>{{$banner->button_icon}}</th>
                    <th>
                        <form action="{{route('admin.banners.destroy',['banner'=>$banner->id])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger"> حذف </button>
                        </form>
                        <a class="btn btn-outline-info mt-2" href="{{route('admin.banners.edit',['banner'=>$banner->id])}}">ویرایش</a>
                    </th>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
