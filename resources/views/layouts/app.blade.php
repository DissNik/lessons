<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', env('APP_NAME'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
@include('shared.header')

@include('shared.navbar')

@include('shared.flash')

@if (session()->has('message'))
    {{ session('message') }}
@endif

@yield('content')

@include('shared.footer')

@include('shared.copyright')

</body>
</html>
