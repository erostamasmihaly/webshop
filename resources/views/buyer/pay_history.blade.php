@extends('buyer.layouts.app')

@section('content')
<div class="container">
    @include('message')
    <div class="card">
        <div class="card-body">
            <div class="bg-info bg-gradient text-dark text-center mb-2">
                <h1>Vásárlási előzmények</h1>
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
                            <th scope="col" class="desktop">Tranzakció ID</th>
                            <th scope="col" class="desktop">Fizetés</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($carts as $cart)
                        <tr class="product" product_id="{{ $cart->id }}">
                            <td>
                                <a href="{{ route('product',$cart->id) }}">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> {{ $cart->name }}
                                </a> 
                            </td>
                            <td><span class="quantity">{{ $cart->quantity }}</span> {{ $cart->unit }}</td>
                            <td>{{ $cart->price_ft }}</td>
                            <td>{{ $cart->transaction_id }}</td>
                            <td>{{ $cart->updated_at }}</td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            @else
                @include('empty')
            @endif
            </div>
        </div>
    </div>
</div>
@endsection