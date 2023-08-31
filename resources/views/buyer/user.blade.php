@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('buyer.user_left')
        @include('buyer.user_right')
    </div>
</div>
@endsection