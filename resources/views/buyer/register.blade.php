@extends('buyer.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Regisztráció</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register_save') }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Felhasználói név</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autofocus>
                                @error('name')
				                    <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
			                    @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Vezetéknév</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" autofocus>
                                @error('surname')
				                    <div class="invalid-feedback d-block">{{ $errors->first('surname') }}</div>
			                    @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Keresztnév</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('forename') is-invalid @enderror" name="forename" value="{{ old('forename') }}" autofocus>
                                @error('forename')
				                    <div class="invalid-feedback d-block">{{ $errors->first('forename') }}</div>
			                    @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">E-mail cím</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                @error('email')
				                    <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
			                    @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Jelszó</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                @error('password')
				                    <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>
			                    @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Jelszó megerősítése</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                        <div class="alert alert-primary" role="alert">
                            A jelszónak minimum 8 karaktert kell tartalmaznia, abból minimum 1 kis betűt, minimum 1 nagy betűt és minimum 1 számot!
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Regisztráció
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
