<div id="tab2" class="tab-pane fade">
	<div class="mb-2">
		<ul class="sortable row" id="gallery"></ul>
	</div>
	<div class="mb-2">
		<div class="row">
			<div class="col-sm-6">
				<input id="file" type="file" name="file[]" multiple />
			</div>
			<div class="col-sm-6">
				<button type="button" id="upload" class="btn btn-primary">Feltöltés indítása</button>
			</div>
		</div>
		@if ($errors->has('shop_id'))
			<div class="invalid-feedback d-block">{{ $errors->first('shop_id') }}</div>
		@endif
	</div> 
	<div class="mb-2">
		<div id="upload-error" class="alert alert-danger d-none" role="alert"></div>
	</div>
    <div class="alert alert-primary" role="alert">
		<p>Fényképek sorrendje Fogd-és-Vidd módszerrel módosítható.</p>
		<p><button type="button" id="sequence" class="btn btn-primary mr-2">Sorrend mentése</button>
		gomb megnyomásával az új sorrend lesz a végleges.</p>
    </div>
</div>