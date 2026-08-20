<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ url('public/build/images/favicon.ico') }}">

    <!-- include head css -->
    @include('layouts.student.head-css')
</head>

@yield('body')
@include('layouts.student.sidebar')
    @yield('content')
@include('layouts.student.footer')


<!-- vendor-scripts -->
@yield('scripts')

@include('layouts.student.vendor-scripts')

</body>

</html>
