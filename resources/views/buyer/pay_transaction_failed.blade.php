@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="alert alert-danger" role="alert">
            <p>Hiba történt a tranzakció során!</p>
            <p>Tranzakciós hiba azosítója: {{ $error }}</p>
        </div>       
    </div>
</div>
@endsection