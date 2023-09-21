@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('message')
		<div class="card">
			<div class="card-body">
				<div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold row">
					<div class="col-sm-2"></div>
					<div class="col-sm-8">Szűrők</div>
					<button class="col-sm-2" id="filter_default">
						<i class="fa-solid fa-rotate-left"></i> Alapállapot
					</span>
				</div>
				<div class="row fw-bold">
					<div class="col-lg-3 col-sm-4 col-6 mb-2">
						<div class="text-center w-100">Bolt kiválasztása</div>
						<select class="form-control select2 filter" id="filter_shop" multiple>
							@foreach($shops AS $shop)
								<option value="{{ $shop->id }}">{{ $shop->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-lg-3 col-sm-4 col-6 mb-2">
						<div class="text-center w-100">Méret kiválasztása</div>
						<select class="form-control select2 filter" id="filter_size" multiple>
							@foreach($sizes AS $size)
								<option value="{{ $size->id }}">{{ $size->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-lg-3 col-sm-4 col-6 mb-2">
						<div class="text-center w-100">Nem kiválasztása</div>
						<select class="form-control select2 filter" id="filter_gender" multiple>
							@foreach($genders AS $gender)
								<option value="{{ $gender->id }}">{{ $gender->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-lg-3 col-sm-4 col-6 mb-2">
						<div class="text-center w-100">Korosztály kiválasztása</div>
						<select class="form-control select2 filter" id="filter_age" multiple>
							@foreach($ages AS $age)
								<option value="{{ $age->id }}">{{ $age->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="bg-info bg-gradient text-dark mb-2 fw-bold row">
					<div class="text-center">Termékcsoportok</div>
				</div>
				<div class="row mb-2" id="groups"></div>
				<div class="bg-info bg-gradient text-dark mb-2 fw-bold row">
					<button class="text-center col-sm-2" id="back">
						<i class="fa-solid fa-arrow-left"></i> Vissza
					</button>
					<div class="text-center col-sm-8">
						Termékek (<span id="current"></span> oldal)
					</div>
					<button class="text-center col-sm-2" id="next">
						Előre <i class="fa-solid fa-arrow-right"></i>
					</button>
				</div>
				<div class="row mb-2" id="products"></div>
			</div>
		</div>
    </div>
</div>
@endsection
