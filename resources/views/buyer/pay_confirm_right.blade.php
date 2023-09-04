<div class="col-sm-4 mb-2">
    <div class="card p-2">
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Kosár tartalma</div>
        <div class="row p-2">
            @foreach($carts AS $cart)
                <div class="col-sm-6">
                    <div class="card p-1">
                        <p class="fw-bold">
                            <a href="{{ route('product',$cart->id) }}"><i class="fa-solid fa-link"></i> {{ $cart->name }}</a>
                            <br>
                            <small>Mennyiség: {{ $cart->quantity }} {{ $cart->unit }}</small>
                        </p>
                        <div class="badge bg-success">{{ $cart->discount_ft }}</div>
                    </div>
                </div>
            @endforeach
            <div class="col-sm-12 mt-2">
                <div class="card bg-success fw-bold p-1 text-light text-center">
                    Fizetendő: {{ $total_ft }}
                </div>
            </div>
        </div>
    </div>
</div>