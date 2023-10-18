@extends('seller.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Megvett termékek</h4>
    @include('message')
    <div class="card">
        <div class="card-body">
            @if ($carts->count() !== 0)
                @include('waiting')
                <table id="datatable" class=" table table-bordered table-striped table-condensed d-none">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Termék</th>
                            <th scope="col" class="all">Összár</th>
                            <th scope="col" class="all">Dátum</th>
                            <th scope="col" class="none">Felhasználó</th>
                            <th scope="col" class="none">Mennyiség</th>
                            <th scope="col" class="none">Egyedi azonosító</th>
                            <th scope="col" class="none">Tranzakció azonosító</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($carts as $cart)
                        <tr>
                            <td>{{ $cart->product->name }}</td>
                            <td>{{ $cart->full_price_ft }}</td>
                            <td>{{ $cart->updated_at }}</td>
                            <td>{{ $cart->user->name }}</td>
                            <td>{{ $cart->quantity }} {{ $cart->product->unit->category->name }}</td>
                            <td>{{ $cart->payment->order_ref }}</td>
                            <td>{{ $cart->payment->transaction_id }}</td>
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
@endsection