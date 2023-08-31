@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <form action="{{ route('buyer_user') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{ $user->id }}"/>    
        <div class="row justify-content-center">
            @include('buyer.user_left')
            @include('buyer.user_right')
        </div>
    </form>
</div>
@endsection