@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('message')
        <input type="hidden" id="product_id" value="{{ $product->id }}"/>
        @include('buyer.product_left')
        @include('buyer.product_right')
    </div>
</div>
@endsection