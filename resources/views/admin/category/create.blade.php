@extends('admin.layouts.admin')
@section("title")
    create_category
@endsection

@section('script')
    <script>
        $('#attributselect').selectpicker({
            'title': "انتخاب ویژگی ها ",
        });

        $('#attributselect').on('changed.bs.select',function (){
            let attributeselected=$('#attributselect').val();
            let attributes= @json($attributes);
            let filterforattribute=[];

            attributes.forEach(function ($attribute){
                $.each(attributeselected,function (i,element){
                    if($attribute.id == element){
                        filterforattribute.push($attribute)
                    };
                });
            });

            $('#attributefilterselect' ).find("option").remove();
            $('#variationselect' ).find('option').remove();
            filterforattribute.forEach(function ($item) {
                let attributeforoptions = $("<option/>", {
                    value: $item.id,
                    text: $item.name,
                });

                $('#attributefilterselect').append(attributeforoptions);
                $('#attributefilterselect').selectpicker('refresh');

                let variationforoptions = $("<option/>",{
                    value : $item.id,
                    text : $item.name,
                });
                // console.log(variationforoptions)


                $('#variationselect' ).append(variationforoptions);
                $('#variationselect' ).selectpicker('refresh');
            });

        });

        $('#attributefilterselect' ).selectpicker({
            'title' : "انتخاب ویژگی قابل فیلتر "
        });
        $('#variationselect' ).selectpicker({
            'title' : "انتخاب ویژگی متغییر "
        });


    </script>
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class=" col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد دسته بندی  </h5>
            </div>
            <hr>
            @include('admin.sections.alerterror')
            <form action="{{ route('admin.categories.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control @error('name') {{'is-invalid'}}  @enderror" id="name" name="name" type="text" value="{{old('name')}}">
                      @error('name')  <p class="invalid-feedback"> {{$message}}</p>@enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="slug">نام انگلیسی</label>
                        <input class="form-control @error('slug') {{'is-invalid'}} @enderror" id="slug" name="slug" type="text" value="{{old('slug')}}">
                        @error('slug')  <p class="invalid-feedback"> {{$message}}</p>@enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="parent_id">والد</label>
                        <select class="form-control" id="parent_id" name="parent_id" value="{{old('parent_id')}}">
                            <option value="0">بدون والد</option>
                            @foreach($parentcategories as $parentcategory)
                            <option value="{{$parentcategory->id}}" >{{$parentcategory->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" >فعال</option>
                            <option value="0"  >غیرفعال</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                <div class="form-group col-md-3">
                    <label>ویژگی ها </label>
                    <select id="attributselect" class="border "   name="attributes_id[]" multiple  data-live-search="true" >
                        @foreach($attributes as $attribute)
                        <option style="text-align: right" value="{{$attribute->id}}">{{{$attribute->name}}}</option>
                        @endforeach

                    </select>
                </div>

                    <div class="form-group col-md-3">
                        <label>ویژگی های قابل فیلتر</label>
                        <select id="attributefilterselect" class="form-control border "   name="attributefilterselect_id[]" multiple  data-live-search="true" >
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label>ویژگی متغییر </label>
                        <select id="variationselect" class="form-control border "   name="variationselect_id"   data-live-search="true">
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="icon">آیکون</label>
                        <input class="form-control" id="icon" name="icon" type="text">
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="description">توضیحات</label>
                    <textarea class="form-control" id="description" name="description" rows="4" >{{old('description')}}</textarea>
                </div>
                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection

