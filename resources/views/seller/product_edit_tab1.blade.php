<div id="tab1" class="tab-pane in active">
    <div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Üzlet *
		</div>
		<div class="col-sm-9">
			<select class="form-control select2" name="shop_id">
				@foreach($shops AS $shop)
					<option value="{{ $shop->id }}" @selected(old('shop_id',$product->shop_id)==$shop->id)>{{ $shop->name }}</option>
				@endforeach
			</select>
			@if ($errors->has('shop_id'))
				<div class="invalid-feedback d-block">{{ $errors->first('shop_id') }}</div>
			@endif
		</div> 
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Név *
		</div>
		<div class="col-sm-9">
			<input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}"/>
			@if ($errors->has('name'))
				<div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
			@endif
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Termékcsoport *
		</div>
		<div class="col-sm-9">
			<select class="form-control select2" name="group_id">
				@foreach($groups AS $group)
					<option value="{{ $group->id }}" @selected(old('group_id',$product->group->category->id)==$group->id)>{{ $group->name }}</option>
				@endforeach
			</select>
			@if ($errors->has('group_id'))
				<div class="invalid-feedback d-block">{{ $errors->first('group_id') }}</div>
			@endif
		</div> 
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Méret *
		</div>
		<div class="col-sm-9">
			<select class="form-control select2" name="size_id">
				@foreach($sizes AS $size)
					<option value="{{ $size->id }}" @selected(old('size_id',$product->size->category->id)==$size->id)>{{ $size->name }}</option>
				@endforeach
			</select>
			@if ($errors->has('size_id'))
				<div class="invalid-feedback d-block">{{ $errors->first('size_id') }}</div>
			@endif
		</div> 
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Nem *
		</div>
		<div class="col-sm-9">
			<select class="form-control select2" name="gender_id">
				@foreach($genders AS $gender)
					<option value="{{ $gender->id }}" @selected(old('gender_id',$product->gender->category->id)==$gender->id)>{{ $gender->name }}</option>
				@endforeach
			</select>
			@if ($errors->has('gender_id'))
				<div class="invalid-feedback d-block">{{ $errors->first('gender_id') }}</div>
			@endif
		</div> 
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Korosztály *
		</div>
		<div class="col-sm-9">
			<select class="form-control select2" name="age_id">
				@foreach($ages AS $age)
					<option value="{{ $age->id }}" @selected(old('age_id',$product->age->category->id)==$age->id)>{{ $age->name }}</option>
				@endforeach
			</select>
			@if ($errors->has('age_id'))
				<div class="invalid-feedback d-block">{{ $errors->first('age_id') }}</div>
			@endif
		</div> 
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Nettó ár *
		</div>
		<div class="col-sm-9">
			<div class="input-group">
				<input type="number" class="form-control" name="price" value="{{ old('price', $product->price) }}"/>
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
				<input type="number" class="form-control" name="vat" value="{{ old('vat', $product->vat) }}"/>
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
				<input type="number" class="form-control" name="discount" value="{{ old('discount', $product->discount) }}"/>
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
			<input type="number" class="form-control" name="quantity" value="{{ old('quantity', $product->quantity) }}"/>
			@if ($errors->has('quantity'))
				<div class="invalid-feedback d-block">{{ $errors->first('quantity') }}</div>
			@endif
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Mértékegység *
		</div>
		<div class="col-sm-9">
			<select class="form-control select2" name="unit_id">
				@foreach($units AS $unit)
					<option value="{{ $unit->id }}" @selected(old('unit_id',$product->unit->category->id)==$unit->id)>{{ $unit->name }}</option>
				@endforeach
			</select>
			@if ($errors->has('unit_id'))
				<div class="invalid-feedback d-block">{{ $errors->first('unit_id') }}</div>
			@endif
		</div> 
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold mb-3">
			Aktív *
		</div>
		<div class="col-sm-9">
			<select name="active" class="form-control">
				<option value="0" @selected(old('active',$product->active)==0)>Nem</option>
				<option value="1" @selected(old('active',$product->active)==1)>Igen</option>
			</select>
		</div>
	</div>
</div>