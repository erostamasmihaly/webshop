<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'ETM Webshop') }}</title>
        @vite(['resources/sass/app.scss'])
        @section('css')
        @include('buyer/layouts/css')
        @show
    </head>
    <body>
        <nav class="sb-topnav navbar navbar-expand bg-info">
            <div class="container">
                <a class="navbar-brand ps-3 fw-bold" href="{{ route('home') }}">{{ config('app.name', 'ETM Webshop') }}</a>
                @section('menu_masodlagos')
                @include('buyer.layouts.menu_masodlagos')
                @show
            </div>
        </nav>
        <main class="py-4 bg-secondary">
            @yield('content')
        </main>
        <footer>
            @section('postload')
            @vite(['resources/js/app.js'])
            @include('buyer/layouts/js')
            @show
        </footer>
    </body>
</html>
