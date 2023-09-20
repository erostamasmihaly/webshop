@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('message')
		<div class="card">
			<div class="card-body">
				<div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Szűrők</div>
				<div class="row">
					<div class="col-lg-3 col-sm-4 col-6 mb-2">
						<select class="form-control select2" id="filter_shop">
							<option>Bolt kiválasztása</option>
							@foreach($shops AS $shop)
								<option value="{{ $shop->id }}">{{ $shop->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-lg-3 col-sm-4 col-6 mb-2">
						<select class="form-control select2" id="filter_size">
							<option>Méret kiválasztása</option>
							@foreach($sizes AS $size)
								<option value="{{ $size->id }}">{{ $size->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-lg-3 col-sm-4 col-6 mb-2">
						<select class="form-control select2" id="filter_gender">
							<option>Nem kiválasztása</option>
							@foreach($genders AS $gender)
								<option value="{{ $gender->id }}">{{ $gender->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-lg-3 col-sm-4 col-6 mb-2">
						<select class="form-control select2" id="filter_age">
							<option>Korosztály kiválasztása</option>
							@foreach($ages AS $age)
								<option value="{{ $age->id }}">{{ $age->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-lg-3 col-sm-4 col-6 mb-2">
						<button type="button" class="btn btn-primary w-100" id="filter">Szűrés</button>
					</div>
				</div>
				<div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Termékcsoportok</div>
				<div class="row mb-2" id="groups"></div>
				<div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Termékek</div>
				<div class="row mb-2" id="products"></div>
			</div>
		</div>
    </div>
</div>
@endsection
