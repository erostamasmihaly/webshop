@extends('buyer.layouts.app')

@section('content')
<div class="container">
    @include('message')
    <div class="card">
        <div class="card-body">
            <div class="bg-info bg-gradient text-dark text-center mb-2">
                <h1>Kosár</h1>
            </div>
            <div class="mb-2">
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
                        <tr class="product" product_id="{{ $cart->product_id }}" size_id="{{ $cart->size_id }}">
                            <td>
                                <a href="{{ route('product',$cart->product_id) }}">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> {{ $cart->product_name }}
                                </a> 
                            </td>
                            <td><span class="quantity">{{ $cart->quantity }}</span> {{ $cart->unit_name }} @if($cart->size_name) ({{ $cart->size_name }}) @endif</td>
                            <td>{{ $cart->discount_ft }}</td>
                            <td>
                                <button type="button" class="btn btn-success plus m-1" title="+1 {{ $cart->unit }} vásárlása"><i class="fa-solid fa-circle-plus"></i></button>  
                                <button type="button" class="btn btn-danger minus m-1" title="-1 {{ $cart->unit }} vásárlása"><i class="fa-solid fa-circle-minus"></i></button> 
                                <button type="button" class="btn btn-secondary delete m-1" title="Termék törlése"><i class="fa-solid fa-trash"></i></button> 
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            @else
                @include('empty')
            @endif
            </div>
        </div>
        <div class="bg-dark text-light fw-bold p-2">
            @if ($carts->count() !== 0)
                Fizetendő: <span id="total">{{ $total_ft }}</span>
                @if(can_pay())
                    <a href="{{ route('pay_confirm') }}" class="btn btn-primary float-end">Fizetés</a>
                @else
                    <span class="text-warning float-end">Kérem töltse ki a Profil oldalon az összes személyes adatát! Addig a Fizetés nem érhető el!</span>
                @endif
            @else
                <span class="text-warning float-end">Jelenleg üres a kosár!</span>
            @endif
        </div>
    </div>
</div>
@endsection