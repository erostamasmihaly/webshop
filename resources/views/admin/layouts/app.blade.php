<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'ETM Webshop') }}</title>
        @vite(['resources/sass/app.scss'])
        @section('css')
        @include('admin/layouts/css')
        @show
    </head>
    <body>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-danger">
            <a class="navbar-brand ps-3" href="{{ route('home') }}">{{ config('app.name', 'ETM Webshop') }}</a>
            @if(isset(Auth::user()->name))
                <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            @endif
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
            @section('menu_masodlagos')
            @include('admin.layouts.menu_masodlagos')
            @show
        </nav>
        <div id="layoutSidenav">
            @if(isset(Auth::user()->name))
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            @section('menu')
                            @include('admin.layouts.menu')
                            @show
                        </div>
                    </div>
                </nav>
            </div>
            @endif
            <div id="layoutSidenav_content">
                <div class="card">
                    <div class="card-body">
                        <main>
                            @yield('content')
                        </main>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            @section('postload')
            @vite(['resources/js/app.js'])
            @include('admin/layouts/js')
            @show
        </footer>
    </body>
</html>
