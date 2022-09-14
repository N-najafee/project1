@extends('admin.layouts.admin')
@section("title")
   products-index
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4 d-flex justify-content-between">
                <h5 class="font-weight-bold">لیست محصولات  ( {{$products->total()}})</h5>
                <a href="{{route('admin.products.create')}}" class="btn btn-outline-primary">
                    ایجاد محصول
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <table class="table table-bordered  table-striped table-striped text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام محصول</th>
                    <th> نام برند</th>
                    <th>دسته بندی</th>
                    <th>وضعبت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $key=>$product)
                <tr>
                    <th>{{$products->FirstItem() + $key}}  </th>
                    <th><a href="{{route('admin.products.show',['product'=>$product->id])}}"> {{$product->name}} </a></th>
                    <th> <a href="{{route('admin.brands.show',['brand'=>$product->showbrand->id])}}">{{$product->showbrand->name}}</a></th>
                    <th> <a href="{{route('admin.categories.show',['category'=>$product->showcategory->id])}}"> {{$product->showcategory->name}} </a></th>
                    <th><span class="{{$product->getraworiginal('is_active') ? "text-success " : "text-danger"}}"> {{$product->is_active}}</span></th>
                    <th >
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" >عملیات</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.product.categories.edit_category',['product'=>$product->id]) }}">ویرایش دسته بندی و ویژگی ها </a>
                                <a class="dropdown-item" href="{{route('admin.products.edit',['product'=>$product->id])}}">ویرایش محصول</a>
                                <a class="dropdown-item" href="{{route('admin.product.images.edit',['product'=>$product->id])}}">ویرایش تصاویر </a>
                            </div>
                        </div>
                    </th>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-5 justify-content-center d-flex">
            {{$products->render()}}
            </div>
        </div>
    </div>


@endsection
