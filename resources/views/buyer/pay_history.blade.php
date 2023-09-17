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
            @if ($elements->count() !== 0)
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
                       @foreach ($elements as $element)
                        <tr class="product" product_id="{{ $element->product_id }}">
                            <td>
                                <a href="{{ route('product',$element->product_id) }}">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> {{ $element->product_name }}
                                </a> 
                            </td>
                            <td><span class="quantity">{{ $element->quantity }}</span> {{ $element->unit }}</td>
                            <td>{{ $element->price_ft }}</td>
                            <td>{{ $element->transaction_id }}</td>
                            <td>{{ $element->updated_at }}</td>
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