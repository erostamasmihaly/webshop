<div id="tab2" class="tab-pane fade">
    <div class="row mb-2">
	    <div class="col-sm-4 fw-bold">
		    Galéria
		</div>
		<div class="col-sm-8">
			<ul class="sortable row" id="gallery"></ul>
		</div>
	</div>
    <div class="row mb-2">
		<div class="col-sm-4 fw-bold">
			Feltöltés *
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
		<button type="button" id="sequence" class="btn btn-primary mr-2">Sorrend mentése</button>
        <button type="button" id="upload" class="btn btn-primary">Feltöltés indítása</button>
    </div>
</div>