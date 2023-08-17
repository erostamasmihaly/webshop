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
                    Felhasználói név
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}"/>
                    @if ($errors->has('name'))
                        <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="col-sm-5 fw-bold mb-3">
                    Vezetéknév
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="surname" value="{{ old('surname', $user->surname) }}"/>
                    @if ($errors->has('surname'))
                        <div class="invalid-feedback d-block">{{ $errors->first('surname') }}</div>
                    @endif
                </div>
                <div class="col-sm-5 fw-bold mb-3">
                    Keresztnév
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="forename" value="{{ old('forename', $user->forename) }}"/>
                    @if ($errors->has('forename'))
                        <div class="invalid-feedback d-block">{{ $errors->first('forename') }}</div>
                    @endif
                </div>
                <div class="col-sm-5 fw-bold mb-3">
                    E-mail cím
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}"/>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="col-sm-5 fw-bold mb-3">
                    Jelszó
                </div>
                <div class="col-sm-7">
                    <input type="password" class="form-control" name="password">
                    @if ($errors->has('password'))
                        <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="col-sm-5 fw-bold mb-3">
                    Szerepkör
                </div>
                <div class="col-sm-7">
                    <select name="roles[]" class="select2 form-control" multiple>
                    @foreach ($roles AS $role)
			            <option value="{{ $role->id }}"
				            @if($user->roles!=null)				
					            @selected(in_array(old('roles',$role->id),$user->roles))				
				            @endif
				        >{{ $role->name}}</option>
			        @endforeach
                    </select>
                    @if ($errors->has('roles'))
                        <div class="invalid-feedback d-block">{{ $errors->first('roles') }}</div>
                    @endif
                </div>
                <div class="col-sm-5 fw-bold mb-3">
                    Aktív
                </div>
                <div class="col-sm-7">
                    <select name="active" class="form-control">
                        <option value="0" @selected(old('active',$user->active)==0)>Nem</option>
                        <option value="1" @selected(old('active',$user->active)==1)>Igen</option>
                    </select>
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