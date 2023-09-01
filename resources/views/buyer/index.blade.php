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
							<div class="card-header bg-info fw-bold text-center mb-1">{{ $product->name }}</div>
							<img src="{{ asset('images/products/'.$product->id.'/main_image.jpg') }}" class="img-thumbnail"/>
							@if($product->discount)
								<span class="badge bg-secondary p-2 mb-2">
									<span class="text-decoration-line-through">{{ $product->brutto_price }}</span>
									<span class="badge rounded-pill bg-danger">
										{{ numformat_with_unit($product->discount,'%') }}
										<span class="visually-hidden">leárazás</span>
									</span>
								</span>
							@endif
							<span class="badge bg-success p-2 mb-2">{{ $product->discount_price }}</span>
							<a href="{{ route('product',$product->id) }}" class="btn btn-primary">Megtekintés</a>
						</div>
					</div>
				@endforeach
			</div>
		</div>
    </div>
</div>
@endsection
