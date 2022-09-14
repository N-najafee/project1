@extends('admin.layouts.admin')
@section("title")
   attributes-index
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4 d-flex justify-content-between">
                <h5 class="font-weight-bold">لیست ویژگی ها  ( {{$attributes->total()}})</h5>
                <a href="{{route('admin.attributes.create')}}" class="btn btn-outline-primary">
                    ایجاد ویژگی
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
                @foreach($attributes as $key=>$attribute)
                <tr>
{{--                    {{ دقت کنم }}--}}
                    <th>  {{$attributes->Firstitem() + $key}} </th>
                    <th>  {{$attribute->name}} </th>
                    <th >
                        <a class="btn btn-outline-success mr-3 " href="{{route('admin.attributes.show',['attribute'=>$attribute->id])}}" > نمایش</a>
                    <a class="btn btn-outline-info mr-3 " href="{{route('admin.attributes.edit',['attribute'=>$attribute->id])}}" >ویرایش</a>
                    </th>
                </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
