<!DOCTYPE html>
<html lang="fa" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{env('SITE_NAME')}} - @yield('title')</title>

    <!-- Custom styles for this template-->
    <link href="{{ asset('/css/home/home.css') }}" rel="stylesheet">
    <script src="{{asset('/fontasom/all.min.js')}}"></script>
    <style>

    </style>
</head>

<body>

<div class="wrapper">

    @include('home.sections.header')
    @include('home.sections.mobile-off-canvas')

    @yield('content')

@include('home.sections.footer')

</div>


<!-- JavaScript-->
<script src="{{ asset('/js/home/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('/js/home/plugins.js') }}"></script>
<script src="{{ asset('/js/home.js') }}"></script>
@include('sweet::alert')
@yield('script')
</body>

</html>
