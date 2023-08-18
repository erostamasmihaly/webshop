<div id="tab2" class="tab-pane fade">
    <div class="row mb-2">
		<div class="col-sm-4 fw-bold">
			Cím
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="address" value="{{ old('address', $shop->address) }}"/>
			@if ($errors->has('adress'))
				<div class="invalid-feedback d-block">{{ $errors->first('address') }}</div>
			@endif
		</div>  
	</div>   
	<div class="row mb-2">
		<div class="col-sm-4 fw-bold">
			URL cím
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="url" value="{{ old('url', $shop->url) }}"/>
			@if ($errors->has('url'))
				<div class="invalid-feedback d-block">{{ $errors->first('url') }}</div>
			@endif
		</div>  
	</div>   
	<div class="row mb-2">
		<div class="col-sm-4 fw-bold">
			E-mail cím
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="email" value="{{ old('email', $shop->email) }}"/>
			@if ($errors->has('email'))
				<div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
			@endif
		</div>  
	</div>   
	<div class="row mb-2">
		<div class="col-sm-4 fw-bold">
			Telefon
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="telephone" value="{{ old('telephone', $shop->telephone) }}"/>
			@if ($errors->has('telephone'))
				<div class="invalid-feedback d-block">{{ $errors->first('telephone') }}</div>
			@endif
		</div>  
	</div>   
	<div class="row mb-2">
		<div class="col-sm-4 fw-bold">
			GPS szélesség
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="latitude" value="{{ old('latitude', $shop->latitude) }}"/>
			@if ($errors->has('latitude'))
				<div class="invalid-feedback d-block">{{ $errors->first('latitude') }}</div>
			@endif
		</div>  
	</div>  
	<div class="row mb-2">
		<div class="col-sm-4 fw-bold">
			GPS hosszúság
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="longitude" value="{{ old('longitude', $shop->longitude) }}"/>
			@if ($errors->has('longitude'))
				<div class="invalid-feedback d-block">{{ $errors->first('longitude') }}</div>
			@endif
		</div>  
	</div>  
	<div class="row mb-2">
		<div class="col-sm-4 fw-bold">
			Térkép
		</div>
		<div class="col-sm-8">
			<div id="map"></div>
		</div>  
	</div> 
</div>