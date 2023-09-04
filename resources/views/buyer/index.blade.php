@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('message')
		<div class="card">
			<div class="card-body row">
				@foreach($products AS $product)
					<div class="col-sm-3">
						<div class="card p-1">
							<div class="card-header bg-info fw-bold text-center mb-1">
                                <a href="{{ route('product',$product->id) }}" class="text-dark">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> {{ $product->name }}
                                </a>
                            </div>
							<img src="{{ asset('images/products/'.$product->id.'/main_image.jpg') }}" class="img-thumbnail"/>
							<span class="badge bg-success p-2 mb-2">{{ $product->discount_price }}
								@if($product->discount)
									<span class="badge rounded-pill bg-danger">
										{{ numformat_with_unit($product->discount,'%') }}
									</span>
								@endif
							</span>
						</div>
					</div>
				@endforeach
			</div>
		</div>
    </div>
</div>
@endsection
