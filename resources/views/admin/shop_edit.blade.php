@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <form action="{{ route('admin_shop') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{ $shop->id }}"/>    
        <h4 class="card-title">
            @if($shop->id==0) Üzlet hozzáadása @else Üzlet szerkesztése @endif
        </h4>
        @method('PUT')
        @csrf
        <div class="card">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab1">Adatok</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab2">Elérhetőség</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab3">Alkalmazottak</a></li>
            </ul>
            <div class="card-body">
                <div class="tab-content">    
                    @include('admin.shop_edit_tab1')
                    @include('admin.shop_edit_tab2')
                    @include('admin.shop_edit_tab3')
                </div>
            </div>
            <div class="bg-dark p-3">
                <div class="submit">
                    <button type="submit" class="btn btn-primary mr-2">Mentés</button>  
                    <button type="button" class="btn btn-primary" id="google">Koordináta cím alapján</button>          
                </div>
            </div>
        </div>
    </form>
</div>
@endsection