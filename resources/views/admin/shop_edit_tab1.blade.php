<div id="tab1" class="tab-pane in active">
    <div class="row mb-2">
		<div class="col-sm-4 fw-bold">
			Név *
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="name" value="{{ old('name', $shop->name) }}"/>
			@if ($errors->has('name'))
				<div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
			@endif
		</div>  
	</div>   
	<div class="row mb-2">
		<div class="col-sm-4 fw-bold">
			Rövid leírás *
		</div>
		<div class="col-sm-8">
			<textarea type="text" class="form-control" name="summary" rows="2">{{ old('summary', $shop->summary) }}</textarea>
			@if ($errors->has('summary'))
				<div class="invalid-feedback d-block">{{ $errors->first('summary') }}</div>
			@endif
		</div> 
	</div>
	<div class="row mb-2">
		<div class="col-sm-4 fw-bold">
			Bővebb leírás
		</div>
		<div class="col-sm-8">
			<textarea type="text" class="form-control" name="body" rows="5">{{ old('body', $shop->body) }}</textarea>
			@if ($errors->has('body'))
				<div class="invalid-feedback d-block">{{ $errors->first('body') }}</div>
			@endif
		</div> 
	</div>
</div>