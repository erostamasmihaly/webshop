@extends('buyer.layouts.app')

@section('content')
<div class="container">
    @include('message')
    <div class="card">
        <div class="card-body">
            <div class="bg-info bg-gradient text-dark text-center mb-2">
                <h1>Kosár</h1>
            </div>
            @if ($carts->count() !== 0)
                @include('waiting')
                <table class="datatable table table-bordered table-striped table-condensed d-none">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Termék neve</th>
                            <th scope="col" class="desktop">Mennyiség</th>
                            <th scope="col" class="desktop">Egységár</th>
                            <th scope="col" class="all">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($carts as $cart)
                        <tr class="product" product_id="{{ $cart->id }}">
                            <td>
                                {{ $cart->name }}
                            </td>
                            <td><span class="quantity">{{ $cart->quantity }}</span> {{ $cart->unit }}</td>
                            <td>{{ $cart->discount_ft }}</td>
                            <td>
                                <button class="btn btn-success plus m-1" title="+1 {{ $cart->unit }} vásárlása"><i class="fa-solid fa-circle-plus"></i></button>  
                                <button class="btn btn-danger minus m-1" title="-1 {{ $cart->unit }} vásárlása"><i class="fa-solid fa-circle-minus"></i></button> 
                                <button class="btn btn-secondary delete m-1" title="Termék törlése"><i class="fa-solid fa-trash"></i></button> 
                                <a href="{{ route('product',$cart->id) }}" class="btn btn-primary" title="Termék megtekintése">
                                    <i class="fa-solid fa-square-arrow-up-right"></i>
                                </a> 
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            @else
                @include('layouts.empty')
            @endif
        </div>
        <div class="bg-dark text-light fw-bold p-2">
            Fizetendő: <span id="total">{{ numformat_with_unit($total,'Ft') }}</span>
            <span class="float-end">
                @if(can_pay())
                    <a href="" class="btn btn-primary">Fizetés</a>
                @else
                    <span class="text-warning">Kérem töltse ki a Profil oldalon az összes személyes adatát! Addig a Fizetés nem érhető el!</span>
                @endif
            </span>
        </div>
    </div>
</div>
@endsection