<div class="form-row">
	<div class="input-group col-md-12 mb-2">
		<div class="input-group-prepend"><span class="input-group-text">Document Root</span>
		</div>
		<input type="text" class="form-control" name="vhosts[document_root]"
			   value="${GLOBAL_DOCUMENT_ROOT}/"
			   placeholder="${GLOBAL_DOCUMENT_ROOT}/website-path/"
			   required>
	</div>
	<small class="col-xs-12 form-text text-muted mb-3">
		use <code>${LARAGON_PATH}</code> To get Laragon install path <br/>
		use <code>${GLOBAL_DOCUMENT_ROOT}</code> To get global document root path <br/>
		<strong><i>if path not exists. then it will be created</i></strong>
	</small>
</div>