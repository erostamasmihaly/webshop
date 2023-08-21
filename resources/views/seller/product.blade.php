@extends('seller.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Termékek kezelése
        <a href="{{ route('seller_product_create') }}" class="btn btn-primary">Új termék</a>
    </h4>
    @include('layouts.message')
    <div class="card">
        <div class="card-body">
            @if ($products->count() !== 0)
                @include('layouts.waiting')
                <table class="datatable table table-bordered table-striped table-condensed d-none">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Név</th>
                            <th scope="col" class="all">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>
                                <a class="btn btn-primary mb-3" href="{{ route('seller_product_edit',$product->id) }}">Szerkesztés</a>
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            @else
                @include('layouts.empty')
            @endif
        </div>
    </div>
</div>
@endsection