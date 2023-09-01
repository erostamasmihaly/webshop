<div class="col-sm-4">
    <div class="card p-2">
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">
            Kedvelt termékek
        </div>
        @if ($favs->count() !== 0)
            <div class="favs row">
                @foreach($favs AS $fav)
                    <div class="col-sm-6">
                        <div class="card p-1">
                            <p class="fw-bold">{{ $fav->name }}</p>
                            <img src="{{ asset('images/products/'.$fav->id.'/main_image.jpg') }}" class="img-thumbnail mb-2"/>
                            <div class="badge bg-primary">{{ $fav->discount }}</div>
                            <div class="undo btn btn-danger mt-2" product_id="{{ $fav->id }}">Visszavonás</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty alert alert-danger">
                Nincsenek kedvelt termékei!
            </div>
        @endif
    </div>
</div>