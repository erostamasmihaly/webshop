<div id="tab3" class="tab-pane fade">
    <table id="prices" class="table table-bordered table-striped table-condensed w-100">
        <thead>
            <tr>
                <th scope="col" class="all">Méret</th>
                <th scope="col" class="all">Mennyiség</th>
                <th scope="col" class="all">Nettó ár</th>
                <th scope="col" class="desktop">ÁFA</th>
                <th scope="col" class="none">Bruttó ár</th>
                <th scope="col" class="desktop">Kedvezmény</th>
                <th scope="col" class="desktop">Kedvezményes ár</th>
            </tr>
        </thead>
    </table>
	<div class="alert alert-primary" role="alert">
		Új árazás felvitele esetén nem kell bejelölni a módosítandó értékek esetén a hozzájuk tartozó Módosítás jelölőnégyzetet. Létező ár módosításakor viszont csak azon értékek fognak módosulni, amelyekhez tartozó Módosítás jelölőnégyzet is be volt jelölve.
	</div>
    <div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Méret *
		</div>
		<div class="col-sm-7">
			<select class="form-control" id="size_id">
				@foreach($sizes AS $size)
					<option value="{{ $size->id }}" @selected(old('size_id')==$size->id)>{{ $size->name }}</option>
				@endforeach
			</select>
		</div> 
	</div>
    <div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Nettó ár *
		</div>
		<div class="col-sm-7">
			<div class="input-group">
				<input type="number" class="form-control" id="price" value="{{ old('price', 0) }}"/>
				<span class="input-group-text">Ft</span>
			</div>
		</div>
		<div class="col-sm-2">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" value="" id="price_check">
				<label class="form-check-label" for="price_check">
					Módosítás
				</label>
			</div>
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			ÁFA *
		</div>
		<div class="col-sm-7">
			<div class="input-group">
				<input type="number" class="form-control" id="vat" value="{{ old('vat', 27) }}"/>
				<span class="input-group-text">%</span>
			</div>
		</div>
		<div class="col-sm-2">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" value="" id="vat_check">
				<label class="form-check-label" for="vat_check">
					Módosítás
				</label>
			</div>
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Kedvezmény *
		</div>
		<div class="col-sm-7">
			<div class="input-group">
				<input type="number" class="form-control" id="discount" value="{{ old('discount', 0) }}"/>
				<span class="input-group-text">%</span>
			</div>
		</div>
		<div class="col-sm-2">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" value="" id="discount_check">
				<label class="form-check-label" for="discount_check">
					Módosítás
				</label>
			</div>
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Mennyiség *
		</div>
		<div class="col-sm-7">
			<input type="number" class="form-control" id="quantity" value="{{ old('quantity', 0) }}"/>
		</div>
		<div class="col-sm-2">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" value="" id="quantity_check">
				<label class="form-check-label" for="quantity_check">
					Módosítás
				</label>
			</div>
		</div>
	</div>
    <div>
        <button type="button" class="btn btn-primary" id="insert_price">Árazás felvitele vagy módosítása</button>
		<div class="alert alert-success d-none" id="success" role="alert">
  			Sikeres művelet!
		</div>
		<div class="alert alert-danger d-none" id="error" role="alert"></div>
    </div>
</div>