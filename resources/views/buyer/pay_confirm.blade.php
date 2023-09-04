@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('buyer.pay_confirm_left')
        @include('buyer.pay_confirm_right')        
    </div>
</div>
@endsection