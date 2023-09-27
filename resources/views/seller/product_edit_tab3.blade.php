<div id="tab3" class="tab-pane fade">
    <table id="prices" class="table table-bordered table-striped table-condensed w-100">
        <thead>
            <tr>
                <th scope="col" class="all">Darab</th>
                <th scope="col" class="all">Méret</th>
                <th scope="col" class="all">Nettó ár</th>
                <th scope="col" class="none">ÁFA</th>
                <th scope="col" class="none">Bruttó ár</th>
                <th scope="col" class="none">Kedvezmény</th>
                <th scope="col" class="none">Kedvezményezett ár</th>
            </tr>
        </thead>
    </table>
    <div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Méret *
		</div>
		<div class="col-sm-9">
			<select class="form-control" id="size_id">
				@foreach($sizes AS $size)
					<option value="{{ $size->id }}" @selected(old('size_id')==$size->id)>{{ $size->name }}</option>
				@endforeach
			</select>
			@if ($errors->has('size_id'))
				<div class="invalid-feedback d-block">{{ $errors->first('size_id') }}</div>
			@endif
		</div> 
	</div>
    <div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Nettó ár *
		</div>
		<div class="col-sm-9">
			<div class="input-group">
				<input type="number" class="form-control" id="price" value="{{ old('price', $product->price) }}"/>
				<span class="input-group-text">Ft</span>
			</div>
			@if ($errors->has('price'))
				<div class="invalid-feedback d-block">{{ $errors->first('price') }}</div>
			@endif
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			ÁFA *
		</div>
		<div class="col-sm-9">
			<div class="input-group">
				<input type="number" class="form-control" id="vat" value="{{ old('vat', $product->vat) }}"/>
				<span class="input-group-text">%</span>
			</div>
			@if ($errors->has('vat'))
				<div class="invalid-feedback d-block">{{ $errors->first('vat') }}</div>
			@endif
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Kedvezmény *
		</div>
		<div class="col-sm-9">
			<div class="input-group">
				<input type="number" class="form-control" id="discount" value="{{ old('discount', $product->discount) }}"/>
				<span class="input-group-text">%</span>
			</div>
			@if ($errors->has('discount'))
				<div class="invalid-feedback d-block">{{ $errors->first('discount') }}</div>
			@endif
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Mennyiség *
		</div>
		<div class="col-sm-9">
			<input type="number" class="form-control" id="quantity" value="{{ old('quantity', $product->quantity) }}"/>
			@if ($errors->has('quantity'))
				<div class="invalid-feedback d-block">{{ $errors->first('quantity') }}</div>
			@endif
		</div>
	</div>
    <div>
        <button class="btn btn-primary" id="insert_price">Ár felvitele</button>
    </div>
</div>