@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('buyer.pay_confirm_left')
        @include('buyer.pay_confirm_right')        
        <div class="bg-dark text-light fw-bold p-2">
            <a href="" class="btn btn-primary float-end">Fizetés megerősítése</a>
        </div>
    </div>
</div>
@endsection