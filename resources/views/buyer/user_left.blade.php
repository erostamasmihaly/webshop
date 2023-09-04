<div class="col-sm-8 mb-2">
    <div class="card p-2">
        <div class="bg-info bg-gradient text-dark text-center mb-2">
            <h1>{{ $user->surname }} {{ $user->forename }}</h1>
        </div>
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">
            Fiók adatok
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Felhasználói név</div>
            <div class="col-sm-9 fw-bold">
                <input type="text" class="form-control" name="name" value="{{ old('name',$user->name) }}"/>
                @if ($errors->has('name'))
				    <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
			    @endif
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Vezetéknév</div>
            <div class="col-sm-9 fw-bold">
                <input type="text" class="form-control" name="surname" value="{{ old('surname',$user->surname) }}"/>
                @if ($errors->has('surname'))
				    <div class="invalid-feedback d-block">{{ $errors->first('surname') }}</div>
			    @endif
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Keresztnév</div>
            <div class="col-sm-9 fw-bold">
                <input type="text" class="form-control" name="forename" value="{{ old('forename',$user->forename) }}"/>
                @if ($errors->has('forename'))
				    <div class="invalid-feedback d-block">{{ $errors->first('forename') }}</div>
			    @endif
            </div>
        </div>
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">
            Személyes adatok
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Ország</div>
            <div class="col-sm-9 fw-bold">
                <input type="text" class="form-control" name="country" value="{{ old('country',$user->country) }}"/>
                @if ($errors->has('country'))
				    <div class="invalid-feedback d-block">{{ $errors->first('country') }}</div>
			    @endif
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Területi egység</div>
            <div class="col-sm-9 fw-bold">
                <input type="text" class="form-control" name="state" value="{{ old('state',$user->state) }}"/>
                @if ($errors->has('state'))
				    <div class="invalid-feedback d-block">{{ $errors->first('state') }}</div>
			    @endif
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Irányítószám</div>
            <div class="col-sm-9 fw-bold">
                <input type="text" class="form-control" name="zip" value="{{ old('zip',$user->zip) }}"/>
                @if ($errors->has('zip'))
				    <div class="invalid-feedback d-block">{{ $errors->first('zip') }}</div>
			    @endif
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Település</div>
            <div class="col-sm-9 fw-bold">
                <input type="text" class="form-control" name="city" value="{{ old('city',$user->city) }}"/>
                @if ($errors->has('city'))
				    <div class="invalid-feedback d-block">{{ $errors->first('city') }}</div>
			    @endif
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Utca, házszám...</div>
            <div class="col-sm-9 fw-bold">
                <input type="text" class="form-control" name="address" value="{{ old('address',$user->address) }}"/>
                @if ($errors->has('address'))
				    <div class="invalid-feedback d-block">{{ $errors->first('address') }}</div>
			    @endif
            </div>
        </div>
        @if(!can_pay())
            <div class="alert alert-warning" role="alert">
                Amennyiben itt nincs minden személyes adat megadva és elmentve, addig nem lehet fizetést kezdeményezni az oldalon keresztül! Az itt megadott adatok lesznek elküldve az OTP rendszerébe a fizetés során! Így kérjük ezen adatokat haladéktalanul töltse ki, még mielőtt a kosárba tett termékeket megvásárolná!
            </div>
        @endif
        <div class="bg-dark p-3">
            <div class="submit float-end">
                <button type="submit" class="btn btn-primary">Mentés</button>            
            </div>
        </div>
    </div>
</div>