@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="alert alert-success" role="alert">
            <input type="hidden" id="url" value="{{ $url }}"/>
            <p>Hamarosan átirányítjuk az OTP Simple oldalára! Ha esetleg valamiért ez mégse következne be, akkor kérjük nyomja meg az Átirányítás gombot!</p>
            <a href="{{ $url }}" class="btn btn-primary">Átirányítás</a>
        </div>       
    </div>
</div>
@endsection