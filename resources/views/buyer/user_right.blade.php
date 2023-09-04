<div class="col-sm-4">
    <div class="card p-2">
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">
            Kedvelt termékek
        </div>
        @if ($favs->count() !== 0)
            <div class="favs row p-1">
                @foreach($favs AS $fav)
                    <div class="col-sm-6 fav" product_id="{{ $fav->id }}">
                        <div class="card p-1 fw-bold">
                            <p><a href="{{ route('product',$fav->id) }}"><i class="fa-solid fa-arrow-up-right-from-square"></i> {{ $fav->name }}</a></p>
                            <div class="badge bg-success">{{ $fav->discount }}</div>
                            </a>
                            <div class="undo btn btn-secondary mt-2">Visszavonás</div>
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