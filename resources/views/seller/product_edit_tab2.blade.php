<div id="tab2" class="tab-pane fade">
    <div class="row mb-2">
	    <div class="col-sm-4 fw-bold">
		    Fényképek megtekintése
		</div>
		<div class="col-sm-8 row" id="images"></div>
	</div>
    <div class="row mb-2">
		<div class="col-sm-4 fw-bold">
			Fénykép feltöltése *
		</div>
		<div class="col-sm-8">
			<input id="file" type="file" name="file[]" multiple />
			@if ($errors->has('shop_id'))
				<div class="invalid-feedback d-block">{{ $errors->first('shop_id') }}</div>
			@endif
		</div> 
	</div>
	<div id="upload-error" class="alert alert-danger d-none" role="alert"></div>
    <div>
        <button type="button" id="upload" class="btn btn-primary">Feltöltés indítása</button>
    </div>
</div>