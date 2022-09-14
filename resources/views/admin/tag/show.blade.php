@extends('admin.layouts.admin')
@section("title")
    create_tag
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">نمایش تگ : {{$tag->name}}</h5>
            </div>
            <hr>
                <div class="row mt-5  ">
                    <div class="form-group  col-4 ">
                        <label >نام</label>
                        <input type="text" value="{{$tag->name}}" disabled >
                    </div>
                    <div class="form-group ms-5 col-4">
                        <label >تاریخ ایجاد</label>
                        <input type="text"  value="{{verta($tag->created_at)}}" disabled>
                    </div>
                </div>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </div>

    </div>

@endsection

