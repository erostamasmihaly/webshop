@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <form action="{{ route('admin_user') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{ $user->id }}"/>    
        <h4 class="card-title">
            @if($user->id==0) Felhasználó hozzáadása @else Felhasználó szerkesztése @endif
        </h4>
        @method('PUT')
        @csrf
        <div class="card">
            <div class="card-body row">
                <div class="col-sm-5 fw-bold mb-3">
                    Felhasználó neve
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}"/>
                    @if ($errors->has('name'))
                        <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="col-sm-5 fw-bold mb-3">
                    E-mail címe
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}"/>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="col-sm-5 fw-bold mb-3">
                    Jelszava
                </div>
                <div class="col-sm-7">
                    <input type="password" class="form-control" name="password">
                    @if ($errors->has('password'))
                        <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>
                    @endif
                </div>
            </div>
            <div class="bg-dark p-3">
                <div class="submit">
                    <button type="submit" class="btn btn-primary">Mentés</button>
                    <a href="{{ route('admin_user') }}" class="btn btn-primary">Kilépés mentés nélkül</a>              
                </div>
            </div>
        </div>
    </form>
</div>
@endsection