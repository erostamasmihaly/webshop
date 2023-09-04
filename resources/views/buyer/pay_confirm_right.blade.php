<div class="col-sm-4 mb-2">
    <div class="card p-2">
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Kosár tartalma</div>
        <div class="row p-2">
            @foreach($carts AS $cart)
                <div class="col-sm-6">
                    <div class="card p-1">
                        <p class="fw-bold">
                            {{ $cart->name }} 
                            ({{ $cart->quantity }} {{ $cart->unit }})
                        </p>
                        <div class="badge bg-success">{{ $cart->discount_ft }}</div>
                    </div>
                </div>
            @endforeach
            <div class="col-sm-12 mt-2">
                <div class="card bg-info p-1">
                    <p class="fw-bold">Összesen</p>
                    <div class="badge bg-success">{{ $total_ft }}</div>
                </div>
            </div>
        </div>
    </div>
</div>