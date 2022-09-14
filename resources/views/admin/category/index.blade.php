@extends('admin.layouts.admin')
@section("title")
   category-index
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4 d-flex justify-content-between">
                <h5 class="font-weight-bold">لیست دسته بندی ها  ( {{$categories->total()}})</h5>
                <a href="{{route('admin.categories.create')}}" class="btn btn-outline-primary">
                    ایجاد دسته بندی
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <table class="table table-bordered  table-striped table-striped text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th> نام انگلیسی</th>
                    <th>والد</th>
                    <th>وضعبت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $key=>$category)
                <tr>
                    <th>{{$categories->FirstItem() + $key}}  </th>
                    <th> {{$category->name}}</th>
                    <th> {{$category->slug}}</th>
                    @if($category->parent_id == 0)
                    <th> بدون والد</th>
                    @else
                    <th> {{$category->parentmethode->name}}</th>
                    @endif
                    <th> <p class="{{$category->getRaworiginal('is_active')? 'text-success' : 'text-danger'}}">{{$category->is_active}}</p></th>
                    <th >
                        <a class="btn btn-outline-success mr-3 " href="{{route('admin.categories.show',['category'=>$category->id])}}" > نمایش</a>
                        <a class="btn btn-outline-info mr-3 " href="{{route('admin.categories.edit',['category'=>$category->id])}}" >ویرایش</a>
                    </th>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-5 justify-content-center d-flex">
                {{$categories->render()}}
            </div>
            </div>
    </div>
@endsection
