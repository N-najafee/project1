@extends('admin.layouts.admin')
@section("title")
    tag-index
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4 d-flex justify-content-between">
                <h5 class="font-weight-bold">لیست تگ ها : ({{$tags->total()}}) </h5>
                <a href="{{route('admin.tags.create')}}" class="btn btn-outline-primary">
                    ایجاد تگ
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <table class="table table-bordered  table-striped table-striped text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tags as $key=>$tag)
                    <tr>
{{--                    {{ دقت کنم }}--}}
                    <th>  {{$tags->firstitem()+$key}} </th>
                    <th> {{$tag->name}}  </th>
                    <th >
                        <a class="btn btn-outline-success mr-3 " href="{{route('admin.tags.show',['tag'=>$tag->id])}}" > نمایش</a>
                    <a class="btn btn-outline-info mr-3 " href="{{route('admin.tags.edit',['tag'=>$tag->id])}}" >ویرایش</a>
                    </th>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
