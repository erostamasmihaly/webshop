@extends('buyer.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Kosár</h4>
    @include('message')
    <div class="card">
        <div class="card-body">
            @if ($carts->count() !== 0)
                @include('waiting')
                <table class="datatable table table-bordered table-striped table-condensed d-none">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Név</th>
                            <th scope="col" class="all">Mennyiség</th>
                            <th scope="col" class="all">Egységár</th>
                            <th scope="col" class="all">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($carts as $cart)
                        <tr id="p{{ $cart->id }}">
                            <td>{{ $cart->name }}</td>
                            <td class="quantity">{{ $cart->quantity }} {{ $cart->unit }}</td>
                            <td>{{ numformat_with_unit($cart->discount_price,'Ft') }} / {{ $cart->unit }}</td>
                            <td>
                                <button class="btn btn-primary plus m-1" product_id="{{ $cart->id }}">+1</button>  
                                <button class="btn btn-primary minus m-1" product_id="{{ $cart->id }}">-1</button>  
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
            <span class="float-end"><a href="" class="btn btn-primary">Fizetés</a></span>
        </div>
    </div>
</div>
@endsection