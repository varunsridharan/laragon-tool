<div class="jumbotron pb-4 pt-3 mb-0 mt-3" style="background:none; border:1px solid #ccc;">
	<h3 class="mb-1 mt-1">Apache</h3>
	<hr class="my-2">

	<div class="form-row">
		<div class="input-group col-md-12 mb-2">
			<div class="input-group-prepend"><span class="input-group-text">HTTP Access Log</span></div>
			<input type="text" class="form-control" name="vhosts[apache][access_log][http]"
				   id="apache_access_log_http"
				   value="${VHOST_DOCUMENT_ROOT}/logs/apache/http-access.log"
				   placeholder="${VHOST_DOCUMENT_ROOT}/logs/apache/http-access.log" required>
		</div>
		<small class="mb-3">Customize Location to store HTTP Access log. by default it stores inside this
			Vhost's Document root</small>
	</div>

	<div class="form-row">
		<div class="input-group col-md-12 mb-2">
			<div class="input-group-prepend"><span class="input-group-text">HTTPS Access Log</span></div>
			<input type="text" class="form-control" name="vhosts[apache][access_log][https]"
				   id="apache_access_log_https"
				   value="${VHOST_DOCUMENT_ROOT}/logs/apache/https-access.log"
				   placeholder="${VHOST_DOCUMENT_ROOT}/logs/apache/https-access.log" required>
		</div>
		<small class="mb-3">Customize Location to store HTTPS Access log. by default it stores inside this
			Vhost's Document root</small>
	</div>

	<div class="form-row">
		<div class="input-group col-md-12 mb-2">
			<div class="input-group-prepend"><span class="input-group-text">Error Log</span></div>
			<input type="text" class="form-control" name="vhosts[apache][error_log]"
				   id="apache_access_log_https"
				   value="${VHOST_DOCUMENT_ROOT}/logs/apache/error.log"
				   placeholder="${VHOST_DOCUMENT_ROOT}/logs/apache/error.log" required>
		</div>
		<small class="mb-3">Customize Location to store Error log. by default it stores inside this
			Vhost's Document root</small>
	</div>

</div>
