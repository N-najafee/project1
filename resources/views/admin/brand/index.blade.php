@extends('admin.layouts.admin')
@section("title")
    brand-index
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4 d-flex justify-content-between">
                <h5 class="font-weight-bold"> لیست برندها </h5>
                <a href="{{route('admin.brands.create')}}" class="btn btn-outline-primary">
                    ایجاد برند
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <table class="table table-bordered  table-striped table-striped text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($brands as $key=>$brand)
                <tr>
{{--                    {{ دقت کنم }}--}}
                    <th>  {{$brands->firstitem() + $key}} </th>
                    <th>  {{$brand->name}} </th>
                    <th >
                        <span class="{{$brand->getraworiginal('is_active') ? 'text-success' : 'text-danger'}}"> {{$brand->is_active}}</span>
                    </th>
                    <th >
                        <a class="btn btn-outline-success mr-3 " href="{{route('admin.brands.show',['brand'=>$brand->id])}}" > نمایش</a>
                    <a class="btn btn-outline-info mr-3 " href="{{route('admin.brands.edit',['brand'=>$brand->id])}}" >ویرایش</a>
                    </th>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
