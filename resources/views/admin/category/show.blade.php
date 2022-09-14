@extends('admin.layouts.admin')
@section("title")
   show-category
@endsection



@section('content')

    <!-- Content Row -->
    <div class="row ">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">نمایش دسته بندی : {{$category->id}}</h5>
            </div>
            <hr>
                <div class="row mt-5 ">
                    <div class="form-group  col-3 ">
                        <label >نام</label>
                        <input type="text" value="{{$category->name}}" disabled class="form-control" >
                    </div>
                    <div class="form-group   ">
                        <label >نام انگلیسی</label>
                        <input type="text" value="{{$category->slug}}" disabled   class="form-control" >
                    </div>
                    <div class="form-group  col-3 ">
                        <label >نام والد</label>
                        @if($category->parent_id == 0)
                        <input type="text" value="بدون والد" disabled   class="form-control" >
                        @else
                            <input type="text" value="{{$category->parentmethode->name}}" disabled  class="form-control"  >
                        @endif
                    </div>

                    <div class="form-group  col-3">
                        <label >تاریخ ایجاد</label>
                        <input type="text"  value="{{verta($category->created_at)}}" disabled  class="form-control" >
                    </div>
                    <div class="form-group  col-3">
                        <label >آیکون</label>
                        <input type="text"  value="{{$category->icon}}" disabled  class="form-control" >
                    </div>
                    <div class="form-group  col-3">
                        <label >وضعیت</label>
                        <input type="text"  value="{{($category->is_active)}}" disabled  class="form-control" >
                    </div>
                </div>
                    <div class="form-group">
                        <label >توضیحات</label>
                        <textarea class="col-12 form-control"  readonly  rows="5">  {{$category->description}}</textarea>
                    </div>
            <hr>
            <div class="row ">
                <div class="form-group  col-3">
                    <label >ویژگی ها </label>

                    <div class="form-control " style="background-color: #eaecf4">
                                       @foreach($category->attributemethode as $item)
                             {{( $item->name)}} {{$loop->last ? '':','}}
                        @endforeach
                    </div>
                    </select>
                </div>
                <div class="form-group  col-3">
                    <label >ویژگی های قابل فیلتر </label>
                    <div class="form-control " style="background-color: #eaecf4">
                        @foreach($category->attributemethode()->wherepivot("is_filter",1)->get() as $attribute)
                            {{$attribute->name}} {{$loop->last ? "":","}}
                        @endforeach
                    </div>
                </div>

                <div class="form-group  col-3">
                    <label >ویژگی متغییر </label>
                    <div class="form-control " style="background-color: #eaecf4">
                        @foreach($category->attributemethode()->wherepivot("is_variation",1)->get() as $attribute)
                            {{$attribute->name}} {{$loop->last ? "":","}}
                        @endforeach
                    </div>
                </div>

            </div>

                <a href="{{ route('admin.categories.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </div>

    </div>

@endsection

