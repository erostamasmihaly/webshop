@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="alert alert-danger" role="alert">
            <p>Hiba történt a tranzakció során!</p>
            <ul>
                @foreach($errors AS $error)
                    <li>{{ $error->message }}</li>
                @endforeach
            </ul>
        </div>       
    </div>
</div>
@endsection