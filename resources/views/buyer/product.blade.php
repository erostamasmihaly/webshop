@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('message')
        @include('buyer.product_left')
        @include('buyer.product_right')
    </div>
</div>
@endsection