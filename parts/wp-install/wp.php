<div class="jumbotron pb-4 pt-3 mb-0 mt-3" style="background:none; border:1px solid #ccc;">
	<h3 class="mb-1 mt-1">WordPress</h3>
	<hr class="my-2">

	<div class="form-row">

		<div class="col-md-3 mb-3">
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" name="wp_config[multisite]" id="multisite" checked>
				<label class="custom-control-label" for="multisite">Multisite</label>
			</div>
			<small class="form-text text-muted">Enable Multisite / Network Ability.</small>
		</div>

		<div class="col-md-3 mb-3">
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" name="wp_config[multisite_subdomain]"
					   id="multisite_subdomain" checked>
				<label class="custom-control-label" for="multisite_subdomain">Sites in subdomains</label>
			</div>
			<small class="form-text text-muted">Enabled means subdomains, disabled means folders.</small>
		</div>

		<div class="col-md-3 mb-3">
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" name="wp_config[debug]" id="debug" checked>
				<label class="custom-control-label" for="debug">WP Debug</label>
			</div>
			<small class="form-text text-muted">Display errors and warnings.</small>
		</div>

		<div class="col-md-3 mb-3">
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" name="wp_config[debug_log]" id="debug_log" checked>
				<label class="custom-control-label" for="debug_log">WP Debug Log</label>
			</div>
			<small class="form-text text-muted">Log errors and warnings.</small>
		</div>

		<div class="col-md-3 mb-3">
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" name="wp_config[debug_display]" id="debug_display"
					   checked>
				<label class="custom-control-label" for="debug_display">WP Debug Display</label>
			</div>
			<small class="form-text text-muted">Display errors and warnings.</small>
		</div>

		<div class="col-md-3 mb-3">
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" name="wp_config[script_debug]" id="script_debug"
					   checked>
				<label class="custom-control-label" for="script_debug">WP Script Debug</label>
			</div>
			<small class="form-text text-muted">JavaScript or CSS errors.</small>
		</div>

		<div class="col-md-3 mb-3">
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" name="wp_config[save_queries]" id="save_queries"
					   checked>
				<label class="custom-control-label" for="save_queries">WP Save Queries</label>
			</div>
			<small class="form-text text-muted">Save database queries in an array <code>($wpdb->queries)</code> for
				analysis.</small>
		</div>

		<div class="col-md-3 mb-3">
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" name="wp_config[ssl_login]" id="ssl_login" checked>
				<label class="custom-control-label" for="ssl_login">WP SSL Login</label>
			</div>
			<small class="form-text text-muted">Force SSL Login.</small>
		</div>

		<div class="col-md-3 mb-3">
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" name="wp_config[ssl_admin]" id="ssl_admin" checked>
				<label class="custom-control-label" for="ssl_admin">WP SSL Admin</label>
			</div>
			<small class="form-text text-muted">Force SSL Admin.</small>
		</div>

		<div class="col-md-3 mb-3">
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" name="wp_config[error_handler]" id="error_handler"
					   checked>
				<label class="custom-control-label" for="error_handler">WP Fatal Error Handler</label>
			</div>
		</div>
	</div>

	<h3 class="mb-1 mt-1">Database</h3>
	<hr class="my-2">

	<div class="form-row">
		<div class="input-group col-md-12 mb-2">
			<div class="input-group-prepend"><span class="input-group-text">Database Name</span></div>
			<input type="text" class="form-control" name="wp_config[db_name]" placeholder="wp_<?php echo time(); ?>">
		</div>
	</div>

	<div class="form-row">
		<div class="input-group col-md-12 mb-2">
			<div class="input-group-prepend"><span class="input-group-text">Table Prefix</span></div>
			<input type="text" class="form-control" name="wp_config[db_prefix]" value="wp_">
		</div>
	</div>
</div>