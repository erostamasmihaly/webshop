<div class="col-sm-4">
    @if($product->discount)
        <div class="card p-2 bg-danger text-white text-center mb-2">
            <div class="text-decoration-line-through">{{ $product->brutto_price }}</div>
            <div class="fw-bold">{{ numformat_with_unit($product->discount,'%') }} kedvezmény!</div>
        </div>
    @endif
    <div class="card p-2 bg-success text-white text-center mb-2">
        <div class="fw-bold">{{ $product->discount_price }}</div>
    </div>
    @guest
        <div class="card p-2 bg-danger text-white text-center">
            <div class="fw-bold">Termék megvásárlása csak aktív fiókba történő sikeres bejelentkezés után lehetséges!</div>
            <a href="{{ route('login') }}" class="btn btn-primary w-100">Bejelentkezés</a>
        </div>
    @else
        <div class="card p-2 text-center">
            <div class="fw-bold">Ha tetszik a termék, akkor adja megy azt a mennyiséget, amennyit meg szeretne vásárolni és utána helyezze a terméket a kosárba.</div>
            <div class="row">
                <div class="col-sm-6">
                    <select class="form-control" id="size">
                        @foreach($product->sizes_array() AS $size)
                            <option value="{{ $size->id }}" max="{{ $size->quantity }}">
                                {{ $size->name }} ({{ $size->quantity }} {{ $product->unit->category->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6">
                    <div class="input-group">
                        <input type="number" class="form-control" id="quantity" value="0" min="0"/>
                        <span class="input-group-text">{{ $product->unit->category->name }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <button type="button" id="cart_add" class="btn btn-primary w-100">Kosárba helyezés</button>
            </div>
            <div class="alert alert-success d-none" role="alert" id="cart_success"></div>
            <div class="alert alert-danger d-none" role="alert" id="cart_error"></div>
        </div>
    @endguest
    @if($images->count()>0)
    <div class="card p-2 mt-2">
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Fényképek</div>
        <div class="alert alert-info" role="alert">
            Fényképekre kattintva nagyobb méretben tekinthetőek meg.
        </div>
        <div class="row">
            @foreach($images AS $image)
            <div class="col-sm-4">
                <a href="{{ $image->url }}" class="colorbox" rel="gallery">
                    <img src="{{ $image->thumb }}" alt="{{ $product->name }}" title="{{ $product->name }}" class="img-thumbnail"/>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>