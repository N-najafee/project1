@extends('admin.layouts.admin')
@section("title")
    create_tag
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد تگ </h5>
            </div>
            <hr>
            @include('admin.sections.alerterror')
            <form action="{{ route('admin.tags.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control @error('name') {{'is-invalid'}} @enderror" id="name" name="name" type="text">
                      @error('name')  <p class="invalid-feedback"> {{$message}}</p>@enderror
                    </div>
                </div>
                <button class="btn btn-outline-primary mt-5" type="submit">ایجاد</button>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection

