@extends('seller.layouts.app')

@section('content')
<div class="container-fluid">
    <form action="{{ route('seller_product') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{ $product->id }}"/>    
        <h4 class="card-title">
            @if($product->id==0) Termék hozzáadása @else Termék szerkesztése @endif
        </h4>
        @method('PUT')
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Üzlet *
                    </div>
                    <div class="col-sm-8">
                        <select class="form-control select2" name="shop_id">
                            @foreach($shops AS $shop)
                                <option value="{{ $shop->id }}" @selected(old('shop_id',$product->shop_id)==$shop->id)>{{ $shop->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('shop_id'))
                            <div class="invalid-feedback d-block">{{ $errors->first('shop_id') }}</div>
                        @endif
                    </div> 
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Név *
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}"/>
                        @if ($errors->has('name'))
                            <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Kategória *
                    </div>
                    <div class="col-sm-8">
                        <select class="form-control select2" name="category_id">
                            @foreach($categories AS $category)
                                <option value="{{ $category->id }}" @selected(old('category_id',$product->category_id)==$category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('category_id'))
                            <div class="invalid-feedback d-block">{{ $errors->first('category_id') }}</div>
                        @endif
                    </div> 
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Nettó ár *
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="number" class="form-control" name="price" value="{{ old('price', $product->price) }}"/>
                            <span class="input-group-text">Ft</span>
                        </div>
                        @if ($errors->has('price'))
                            <div class="invalid-feedback d-block">{{ $errors->first('price') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        ÁFA *
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="number" class="form-control" name="vat" value="{{ old('vat', $product->vat) }}"/>
                            <span class="input-group-text">%</span>
                        </div>
                        @if ($errors->has('vat'))
                            <div class="invalid-feedback d-block">{{ $errors->first('vat') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Kedvezmény *
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="number" class="form-control" name="discount" value="{{ old('discount', $product->discount) }}"/>
                            <span class="input-group-text">%</span>
                        </div>
                        @if ($errors->has('discount'))
                            <div class="invalid-feedback d-block">{{ $errors->first('discount') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Mennyiség *
                    </div>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="quantity" value="{{ old('quantity', $product->quantity) }}"/>
                        @if ($errors->has('quantity'))
                            <div class="invalid-feedback d-block">{{ $errors->first('quantity') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Mértékegység *
                    </div>
                    <div class="col-sm-8">
                        <select class="form-control select2" name="unit_id">
                            @foreach($units AS $unit)
                                <option value="{{ $unit->id }}" @selected(old('unit_id',$product->unit_id)==$unit->id)>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('category_id'))
                            <div class="invalid-feedback d-block">{{ $errors->first('category_id') }}</div>
                        @endif
                    </div> 
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Rövid leírás *
                    </div>
                    <div class="col-sm-8">
                        <textarea type="text" class="form-control" name="summary" rows="2">{{ old('summary', $product->summary) }}</textarea>
                        @if ($errors->has('summary'))
                            <div class="invalid-feedback d-block">{{ $errors->first('summary') }}</div>
                        @endif
                    </div> 
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Bővebb leírás *
                    </div>
                    <div class="col-sm-8">
                        <textarea type="text" class="form-control" name="body" rows="5">{{ old('body', $product->body) }}</textarea>
                        @if ($errors->has('body'))
                            <div class="invalid-feedback d-block">{{ $errors->first('body') }}</div>
                        @endif
                    </div> 
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold mb-3">
                        Aktív *
                    </div>
                    <div class="col-sm-8">
                        <select name="active" class="form-control">
                            <option value="0" @selected(old('active',$product->active)==0)>Nem</option>
                            <option value="1" @selected(old('active',$product->active)==1)>Igen</option>
                        </select>
                    </div>
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