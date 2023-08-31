@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <form action="{{ route('buyer_user_update') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{ $user->id }}"/>    
        <div class="row justify-content-center">
            @method('PUT')
            @csrf
            @include('buyer.user_left')
            @include('buyer.user_right')
        </div>
    </form>
</div>
@endsection