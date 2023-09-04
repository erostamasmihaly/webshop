<div class="col-sm-8 mb-2">
    <div class="card p-2">
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Felhasználó adatai</div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Név</div>
            <div class="col-sm-9">{{ $user->surname }} {{ $user->forename }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">E-mail cím</div>
            <div class="col-sm-9">{{ $user->email }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Ország</div>
            <div class="col-sm-9">{{ $user->country }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Területi egység</div>
            <div class="col-sm-9">{{ $user->state }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Irányítószám</div>
            <div class="col-sm-9">{{ $user->zip }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Település</div>
            <div class="col-sm-9">{{ $user->city }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Utca, házszám...</div>
            <div class="col-sm-9">{{ $user->address }}</div>
        </div>
        <div class="alert alert-warning" role="alert">
            Felhasználói adatok módosítására csak a <a href="{{ route('buyer_user') }}"><i class="fa-solid fa-arrow-up-right-from-square"></i> Profil oldalon</a> van lehetőség!
        </div>
    </div>
</div>