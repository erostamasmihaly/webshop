<div id="tab2" class="tab-pane fade">
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Rövid leírás *
		</div>
		<div class="col-sm-9">
			<textarea type="text" class="form-control" name="summary" row="3">{{ old('summary', $product->summary) }}</textarea>
			@if ($errors->has('summary'))
				<div class="invalid-feedback d-block">{{ $errors->first('summary') }}</div>
			@endif
		</div> 
	</div>
	<div class="row mb-2">
		<div class="col-sm-3 fw-bold">
			Bővebb leírás *
		</div>
		<div class="col-sm-9">
			<textarea type="text" class="form-control tinyeditor" name="body">{!! old('body', $product->body) !!}</textarea>
			@if ($errors->has('body'))
				<div class="invalid-feedback d-block">{{ $errors->first('body') }}</div>
			@endif
		</div> 
	</div>
</div>