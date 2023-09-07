@extends('seller.layouts.app')

@section('content')
<div class="container-fluid">
    <form action="{{ route('seller_product') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" id="product_id" value="{{ $product->id }}"/>  
        <input type="hidden" id="temporary_id" name="temporary_id" value="{{ old('temporary_id',mt_rand(10000000,99999999)) }}"/>  
        <h4 class="card-title">
            @if($product->id==0) Termék hozzáadása @else Termék szerkesztése @endif
        </h4>
        @method('PUT')
        @csrf
        <div class="card">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab1">Adatok</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab2">Fényképek</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab3">Értékelések</a></li>
            </ul>
            <div class="card-body">
                <div class="tab-content">    
                    @include('seller.product_edit_tab1')
                    @include('seller.product_edit_tab2')
                    @include('seller.product_edit_tab3')
                </div>
            </div>
            <div class="bg-dark p-3">
                <div class="submit">
                    <button type="submit" class="btn btn-primary">Mentés</button>            
                </div>
            </div>
        </div>
    </form>
</div>
@endsection