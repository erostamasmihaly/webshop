<div id="tab1" class="tab-pane in active">
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
			Termékcsoport *
		</div>
		<div class="col-sm-9">
			<select class="form-control select2" name="group_id">
				@foreach($groups AS $group)
					<option value="{{ $group->id }}" @if($new) @selected(old('group_id')==$group->id) @else @selected(old('group_id',$product->group->category->id)==$group->id) @endif>{{ $group->name }}</option>
				@endforeach
			</select>
			@if ($errors->has('group_id'))
				<div class="invalid-feedback d-block">{{ $errors->first('group_id') }}</div>
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
					<option value="{{ $gender->id }}" @if($new) @selected(old('gender_id')==$gender->id) @else @selected(old('gender_id',$product->gender->category->id)==$gender->id) @endif>{{ $gender->name }}</option>
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
					<option value="{{ $age->id }}" @if($new) @selected(old('age_id')==$age->id) @else @selected(old('age_id',$product->age->category->id)==$age->id) @endif>{{ $age->name }}</option>
				@endforeach
			</select>
			@if ($errors->has('age_id'))
				<div class="invalid-feedback d-block">{{ $errors->first('age_id') }}</div>
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
					<option value="{{ $unit->id }}" @if($new) @selected(old('unit_id')==$unit->id) @else @selected(old('unit_id',$product->unit->category->id)==$unit->id) @endif>{{ $unit->name }}</option>
				@endforeach
			</select>
			@if ($errors->has('unit_id'))
				<div class="invalid-feedback d-block">{{ $errors->first('unit_id') }}</div>
			@endif
		</div> 
	</div>
</div>