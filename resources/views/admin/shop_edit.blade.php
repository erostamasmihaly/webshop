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
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Név *
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="name" value="{{ old('name', $shop->name) }}"/>
                        @if ($errors->has('name'))
                            <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
                        @endif
                    </div>  
                </div>   
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Rövid leírás *
                    </div>
                    <div class="col-sm-8">
                        <textarea type="text" class="form-control" name="summary" rows="2">{{ old('summary', $shop->summary) }}</textarea>
                        @if ($errors->has('summary'))
                            <div class="invalid-feedback d-block">{{ $errors->first('summary') }}</div>
                        @endif
                    </div> 
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Bővebb leírás
                    </div>
                    <div class="col-sm-8">
                        <textarea type="text" class="form-control" name="body" rows="5">{{ old('body', $shop->body) }}</textarea>
                        @if ($errors->has('body'))
                            <div class="invalid-feedback d-block">{{ $errors->first('body') }}</div>
                        @endif
                    </div> 
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Cím
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="address" value="{{ old('address', $shop->address) }}"/>
                        @if ($errors->has('adress'))
                            <div class="invalid-feedback d-block">{{ $errors->first('address') }}</div>
                        @endif
                    </div>  
                </div>   
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        URL cím
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="url" value="{{ old('url', $shop->url) }}"/>
                        @if ($errors->has('url'))
                            <div class="invalid-feedback d-block">{{ $errors->first('url') }}</div>
                        @endif
                    </div>  
                </div>   
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        E-mail cím
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="email" value="{{ old('email', $shop->email) }}"/>
                        @if ($errors->has('email'))
                            <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
                        @endif
                    </div>  
                </div>   
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Telefon
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="telephone" value="{{ old('telephone', $shop->telephone) }}"/>
                        @if ($errors->has('telephone'))
                            <div class="invalid-feedback d-block">{{ $errors->first('telephone') }}</div>
                        @endif
                    </div>  
                </div>   
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        GPS szélesség
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="latitude" value="{{ old('latitude', $shop->latitude) }}"/>
                        @if ($errors->has('latitude'))
                            <div class="invalid-feedback d-block">{{ $errors->first('latitude') }}</div>
                        @endif
                    </div>  
                </div>  
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        GPS hosszúság
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="longitude" value="{{ old('longitude', $shop->longitude) }}"/>
                        @if ($errors->has('longitude'))
                            <div class="invalid-feedback d-block">{{ $errors->first('longitude') }}</div>
                        @endif
                    </div>  
                </div>  
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">
                        Térkép
                    </div>
                    <div class="col-sm-8">
                        <div id="map"></div>
                    </div>  
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