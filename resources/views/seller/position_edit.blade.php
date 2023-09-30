@extends('seller.layouts.app')

@section('content')
<div class="container-fluid">
    <form action="{{ route('seller_position_update') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{ $position->id }}"/>     
        <input type="hidden" name="position_group_id" value="{{ $position->position_group_id }}"/>
        <h4 class="card-title">
            @if($position->id==0) Munkakör hozzáadása @else Munkakör szerkesztése @endif
        </h4>
        @method('PUT')
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-3 fw-bold">
                        Üzlet *
                    </div>
                    <div class="col-sm-9">
                        <select class="form-control select2" name="shop_id">
                            @foreach($shops AS $shop)
                                <option value="{{ $shop->id }}" @selected(old('shop_id',$position->shop_id)==$shop->id)>{{ $shop->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('shop_id'))
                            <div class="invalid-feedback d-block">{{ $errors->first('shop_id') }}</div>
                        @endif
                    </div> 
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 fw-bold mb-3">
                        Név *
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" value="{{ old('name', $position->name) }}"/>
                        @if ($errors->has('name'))
                            <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
                        @endif
                    </div>     
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 fw-bold">
                        Rövid leírás *
                    </div>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" name="summary" rows="2">{{ old('summary', $position->summary) }}</textarea>
                        @if ($errors->has('summary'))
                            <div class="invalid-feedback d-block">{{ $errors->first('summary') }}</div>
                        @endif
                    </div> 
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 fw-bold">
                        Bővebb leírás
                    </div>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control tinyeditor" name="body">{{ old('body', $position->body) }}</textarea>
                        @if ($errors->has('body'))
                            <div class="invalid-feedback d-block">{{ $errors->first('body') }}</div>
                        @endif
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