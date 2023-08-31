<div class="col-sm-4">
    @if($product->discount)
        <div class="card p-2 bg-danger text-white text-center mb-2">
            <div class="text-decoration-line-through">{{ numformat_with_unit($product->brutto_price,'Ft') }} / {{ $product->unit }}</div>
            <div class="fw-bold">{{ numformat_with_unit($product->discount,'%') }} kedvezmény!</div>
        </div>
    @endif
    <div class="card p-2 bg-success text-white text-center mb-2">
        <div class="fw-bold">{{ numformat_with_unit($product->discount_price,'Ft') }} / {{ $product->unit }}</div>
    </div>
    @guest
        <div class="card p-2 bg-danger text-white text-center">
            <div class="fw-bold">Termék megvásárlása csak aktív fiókba történő sikeres bejelentkezés után lehetséges!</div>
            <a href="{{ route('login') }}" class="btn btn-primary w-100">Bejelentkezés</a>
        </div>
    @else
        <div class="card p-2 text-center">
            <div class="fw-bold">Ha tetszik a termék, akkor adja megy azt a mennyiséget, amennyit meg szeretne vásárolni és utána helyezze a terméket a kosárba.</div>
            <div class="input-group">
                <input type="number" class="form-control" id="quantity" value="0" min="0"/>
				<span class="input-group-text">{{ $product->unit }}</span>
			</div>
            <div class="mt-2">
                <button type="button" id="add" class="btn btn-primary w-100">Kosárba helyezés</button>
            </div>
            <span class="badge bg-success mt-2 p-2 d-none" id="success"></span>
            <span class="badge bg-danger mt-2 p-2 d-none" id="error"></span>
        </div>
    @endguest
</div>