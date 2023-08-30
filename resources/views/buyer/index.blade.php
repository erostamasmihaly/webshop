@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('message')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Termékek</div>
                <div class="card-body row">
                    @foreach($products AS $product)
                        <div class="col-sm-4">
                            <div class="card p-1">
                                <p class="text-center fw-bold">{{ $product->name }}</p>
                                <p>
                                    <img src="{{ asset('images/products/'.$product->id.'/main_image.jpg') }}" class="img-thumbnail"/>
                                </p>
                                @if($product->discount)
                                    <span class="badge bg-secondary p-2 mb-2">
                                        <span class="text-decoration-line-through">{{ numformat_with_unit($product->brutto_price,'Ft') }} / {{ $product->unit }}</span>
                                        <span class="badge rounded-pill bg-danger">
                                            {{ numformat_with_unit($product->discount,'%') }}
                                            <span class="visually-hidden">leárazás</span>
                                        </span>
                                    </span>
                                @endif
                                <span class="badge bg-success p-2 mb-2">{{ numformat_with_unit($product->discount_price,'Ft') }} / {{ $product->unit }}</span>
                                <a href="{{ route('product',$product->id) }}" class="btn btn-primary">Megtekintés</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
