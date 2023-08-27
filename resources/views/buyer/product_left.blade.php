<div class="col-sm-8">
    <div class="card p-2">
        <div class="row">
            <div class="col-sm-3 fw-bold">Bolt neve</div>
            <div class="col-sm-9">{{ $product->shop_name }}</div>
            <div class="col-sm-3 fw-bold"></div>
            <div class="col-sm-9"><a href="" class="btn btn-primary">Bolt megtekintése</a></div>
            <div class="col-sm-3 fw-bold">Rövid leírás</div>
            <div class="col-sm-9">{!! nl2br($product->summary) !!}</div>
            <div class="col-sm-12 fw-bold">Részletes leírás</div>
            <div class="col-sm-12">{!! nl2br($product->body) !!}</div>
        </div>
    </div>
</div>