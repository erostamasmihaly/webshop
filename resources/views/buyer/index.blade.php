@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('message')
		<div class="card">
			<div class="card-body">
				<div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Kategóriák</div>
				<div class="row mb-2" id="categories"></div>
				<div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Termékek</div>
				<div class="row mb-2" id="products"></div>
			</div>
		</div>
    </div>
</div>
@endsection
