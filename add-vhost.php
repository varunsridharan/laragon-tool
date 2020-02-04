<?php
require __DIR__ . './config.php';

if ( isset( $_POST['add_vhost'] ) ) {
	$instance = new \VSP\Laragon\Modules\VHosts\Create(  );
	$instance->create_new($_POST['vhosts']);
	echo $instance->alerts();
	#var_dump( $_POST['vhosts'] );
}
?>

	<form id="addVhosts" method="post" class="needs-validation" novalidate>

		<div class="form-row">
			<div class="input-group col-md-12 mb-2">
				<div class="input-group-prepend"><span class="input-group-text">Document Root</span>
				</div>
				<input type="text" class="form-control" name="vhosts[document_root]"
					   value="${GLOBAL_DOCUMENT_ROOT}/testing/website-path/"
					   placeholder="${GLOBAL_DOCUMENT_ROOT}/website-path/"
					   required>
			</div>
			<small class="col-xs-12 form-text text-muted mb-3">
				use <code>${LARAGON_PATH}</code> To get Laragon install path <br/>
				use <code>${GLOBAL_DOCUMENT_ROOT}</code> To get global document root path <br/>
				<strong><i>if path not exists. then it will be created</i></strong>
			</small>
		</div>

		<div class="form-row" id="vhostdomains">
			<div class="input-group col-md-12 mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text">Domain</span>
				</div>
				<input type="text" class="form-control" name="vhosts[vhostdomains][0]" id="vhostdomains_0"
					   placeholder="Enter Domain" required>
				<div class="input-group-append">
					<span class="input-group-text"><a class="vhostdomains_add" href="javascript:void(0);">Add</a></span>
				</div>
			</div>
			<small class="mb-3">
				Click <code>Add</code> to set custom alias <br/>
				wildcard <code>(*.example.com)</code> will be auto created for each and every alias & main domain
			</small>
		</div>


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


		<div class="jumbotron pb-4 pt-3 mb-0 mt-3" style="background:none; border:1px solid #ccc;">
			<h3 class="mb-1 mt-1">Nginx</h3>
			<hr class="my-2">

			<div class="form-row">
				<div class="input-group col-md-12 mb-2">
					<div class="input-group-prepend"><span class="input-group-text">HTTP Access Log</span></div>
					<input type="text" class="form-control" name="vhosts[nginx][access_log][http]"
						   id="apache_access_log_http"
						   value="${VHOST_DOCUMENT_ROOT}/logs/nginx/http-access.log"
						   placeholder="${VHOST_DOCUMENT_ROOT}/logs/nginx/http-access.log" required>
				</div>
				<small class="mb-3">Customize Location to store HTTP Access log. by default it stores inside this
					Vhost's Document root</small>
			</div>

			<div class="form-row">
				<div class="input-group col-md-12 mb-2">
					<div class="input-group-prepend"><span class="input-group-text">HTTPS Access Log</span></div>
					<input type="text" class="form-control" name="vhosts[nginx][access_log][https]"
						   id="apache_access_log_https"
						   value="${VHOST_DOCUMENT_ROOT}/logs/nginx/https-access.log"
						   placeholder="${VHOST_DOCUMENT_ROOT}/logs/nginx/https-access.log" required>
				</div>
				<small class="mb-3">Customize Location to store HTTPS Access log. by default it stores inside this
					Vhost's Document root</small>
			</div>

			<div class="form-row">
				<div class="input-group col-md-12 mb-2">
					<div class="input-group-prepend"><span class="input-group-text">Error Log</span></div>
					<input type="text" class="form-control" name="vhosts[nginx][error_log]"
						   id="apache_access_log_https"
						   value="${VHOST_DOCUMENT_ROOT}/logs/nginx/error.log"
						   placeholder="${VHOST_DOCUMENT_ROOT}/logs/nginx/error.log" required>
				</div>
				<small class="mb-3">Customize Location to store Error log. by default it stores inside this
					Vhost's Document root</small>
			</div>

		</div>

		<button type="submit" class="btn btn-primary mt-3" name="add_vhost">Create VHost</button>
	</form>
<?php

template( 'footer' );
