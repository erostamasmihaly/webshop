<div class="col-sm-4">
    <div class="card p-2">
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">
            Kedvelt termékek
        </div>
        @if ($favs->count() !== 0)
            <div class="favs row">
                @foreach($favs AS $fav)
                    <div class="col-sm-6 fav" product_id="{{ $fav->id }}">
                        <div class="card p-1">
                            <p class="fw-bold">{{ $fav->name }}</p>
                            <img src="{{ asset('images/products/'.$fav->id.'/main_image.jpg') }}" class="img-thumbnail mb-2"/>
                            <div class="badge bg-primary">{{ $fav->discount }}</div>
                            <div class="undo btn btn-danger mt-2">Visszavonás</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="empty alert alert-danger @if ($favs->count() !== 0) d-none @endif">
            Nincsenek kedvelt termékei!
        </div>
    </div>
</div>