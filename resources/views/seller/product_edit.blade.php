@extends('seller.layouts.app')

@section('content')
<div class="container-fluid">
    @include('has_message')
    @if ($errors->has('prices'))
        <div class="alert alert-danger" role="alert">{{ $errors->first('prices') }}</div>
    @endif
    <form action="{{ route('seller_product') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" id="product_id" value="{{ $product->id }}"/>  
        <h4 class="card-title">
            @if($product->id==0) Termék hozzáadása @else Termék szerkesztése @endif
        </h4>
        @method('PUT')
        @csrf
        <div class="card">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab1">Adatok</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab2">Leírások</a></li>
                @if($product->id!=0)
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab3">Árazás</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab4">Fényképek</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab5">Értékelések</a></li>
                @endif
            </ul>
            <div class="card-body">
                <div class="tab-content">    
                    @include('seller.product_edit_tab1')
                    @include('seller.product_edit_tab2')
                    @if($product->id!=0)
                        @include('seller.product_edit_tab3')
                        @include('seller.product_edit_tab4')
                        @include('seller.product_edit_tab5')
                    @endif
                </div>
            </div>
            <div class="bg-dark p-3">
                <div class="submit">
                    <button type="submit" class="btn btn-primary">Mentés</button>  
                    @if($product->id!=0) 
                        <a class="btn btn-primary" href="{{ route('seller_product_active',$product->id) }}">
                            @if($product->active==0) Publikál @else Elrejt @endif
                        </a>
                    @endif          
                </div>
            </div>
        </div>
    </form>
</div>
@endsection