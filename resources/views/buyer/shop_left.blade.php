<div class="col-sm-8 mb-2">
    <div class="card p-2">
        <div class="bg-info bg-gradient text-dark text-center mb-2">
            <h1>{{ $shop->name }}</h1>
        </div>
        <div class="fw-bold">{!! nl2br($shop->summary) !!}</div>
        @if($shop->body)
            <div>{!! nl2br($shop->body) !!}</div>
        @endif
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Termékek</div>
    </div>
</div>