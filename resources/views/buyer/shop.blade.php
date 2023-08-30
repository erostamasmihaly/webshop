@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('buyer.shop_left')
        @include('buyer.shop_right')
    </div>
</div>
@endsection