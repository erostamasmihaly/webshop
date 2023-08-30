<div class="col-sm-8 mb-2">
    <div class="card p-2">
        <div class="bg-info bg-gradient text-dark text-center mb-2">
            <h1>{{ $product->name }}</h1>
        </div>
        <div class="row">
            <div class="col-sm-3 fw-bold">Bolt neve</div>
            <div class="col-sm-9">
                <a href="{{ route('shop',$product->shop_id) }}" class="btn btn-primary">{{ $product->shop_name }}</a>
            </div>
            <div class="col-sm-3 fw-bold">Kategória</div>
            <div class="col-sm-9">{{ $product->category_name }}</div>
            <div class="col-sm-3 fw-bold">Mennyiség</div>
            <div class="col-sm-9">{{ $product->quantity }} {{ $product->unit }}</div>
            <div class="col-sm-3 fw-bold">Rövid leírás</div>
            <div class="col-sm-9">{!! nl2br($product->summary) !!}</div>
            <div class="col-sm-3 fw-bold">Részletes leírás</div>
            <div class="col-sm-9">{!! nl2br($product->body) !!}</div>
            <div class="col-sm-3 fw-bold">Képek</div>
            <div class="col-sm-9 row">
                @foreach($images AS $image)
                    <div class="col-sm-3">
                        <a href="{{ $image->url }}" class="colorbox" rel="gallery">
                            <img src="{{ $image->thumb }}" alt="{{ $product->name }}" title="{{ $product->name }}" class="img-thumbnail"/>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>