<div class="col-sm-4 mb-2">
    <div class="card p-2">
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Kosár tartalma</div>
        <div class="row p-1 mb-2">
            @foreach($carts AS $cart)
                <div class="col-sm-6">
                    <div class="card p-1">
                        <p class="fw-bold">
                            <a href="{{ route('product',$cart->id) }}"><i class="fa-solid fa-arrow-up-right-from-square"></i> {{ $cart->name }}</a>
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
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Fizetéssel kapcsolatos információk</div>
        <div>
            <h5 class="fw-bold text-center">
                <a href="{{ asset('documents/simplepay.pdf') }}" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> SIMPLEPAY<br>ONLINE FIZETÉSI RENDSZER<br>Fizetési tájékoztató
                </a>
            </h5>
            <p>
                <a href="https://simplepay.hu/vasarlo-aff/" target="_blank">
                    <img src="{{ asset('images/simplepay.png') }}" class="img-thumbnail"/>
                </a>
            </p>
            <p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" name="accept" id="accept">
                    <label class="form-check-label" for="accept">Elfogadom a 
                        <a href="https://simplepay.hu/vasarlo-aff/" target="_blank">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Vásárlói általános felhasználási feltételeket
                        </a>
                    </label>
                </div>
            </p>
        </div>
        <div class="bg-dark p-2">
            <a href="" class="btn btn-primary float-end">Fizetés megerősítése</a>
        </div>
    </div>
</div>