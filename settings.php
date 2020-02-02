<?php

require __DIR__ . '/config.php';
?>
	<form id="settingsform" method="post" class="needs-validation" novalidate>

		<div class="accordion" id="settings_accordion">
			<div class="card">
				<div class="card-header" id="general_config">
					<h2 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse"
								data-target="#general_config_data"
								aria-expanded="true" aria-controls="collapseOne">
							General Config
						</button>
					</h2>
				</div>

				<div id="general_config_data" class="collapse show" aria-labelledby="general_config"
					 data-parent="#settings_accordion">
					<div class="card-body">
						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend"><span
											class="input-group-text">Larangon Install Path</span></div>
								<input type="text" class="form-control" name="laragon_path"
									   placeholder="Full Path on where laragon is installed" required>
							</div>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend"><span class="input-group-text">Document Root</span>
								</div>
								<input type="text" class="form-control" name="document_root"
									   placeholder="${LARAGON_PATH}/www" required>
							</div>
							<small class="col-xs-12 form-text text-muted mb-3"> use <code>${LARAGON_PATH}</code> to
								locate config
								inside current install path</small>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend"><span
											class="input-group-text">Vhosts File Prefix</span></div>
								<input type="text" class="form-control" name="host_file_prefix" placeholder="auto-"
									   required>
							</div>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend"><span class="input-group-text">PLATFORM</span></div>
								<input type="text" class="form-control" name="host_file_prefix"
									   placeholder="windows,linux,mac"
									   required>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header" id="host_file_config">
					<h2 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse"
								data-target="#host_file_config_data">
							Hosts File Config
						</button>
					</h2>
				</div>

				<div id="host_file_config_data" class="collapse" aria-labelledby="host_file_config"
					 data-parent="#settings_accordion">
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" name="hosts_file_entry"
										   id="hosts_file_entry"
										   required>
									<label class="custom-control-label" for="hosts_file_entry">Auto Add Hosts File
										Entry</label>
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend"><span
											class="input-group-text">Host File Location</span></div>
								<input type="text" class="form-control" name="hosts_file"
									   placeholder="C:\Windows\System32\drivers\etc/hosts" required>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header" id="library_config">
					<h2 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse"
								data-target="#library_config_data">
							Library Config
						</button>
					</h2>
				</div>

				<div id="library_config_data" class="collapse" aria-labelledby="library_config"
					 data-parent="#settings_accordion">
					<div class="card-body">
						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">MK Cert Location</span>
								</div>
								<input type="text" class="form-control" name="mkcert_path" placeholder="default"
									   required>
							</div>
							<small class="col-xs-12 form-text text-muted">
								if you have <a href="https://github.com/FiloSottile/mkcert">mkcert</a> already installed
								please
								provide the exact location or enter <strong>default</strong> to use prepacked source
							</small>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header" id="apache_config">
					<h2 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse"
								data-target="#apache_config_data">
							Apache Config
						</button>
					</h2>
				</div>

				<div id="apache_config_data" class="collapse" aria-labelledby="apache_config"
					 data-parent="#settings_accordion">
					<div class="card-body">
						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Config Location</span>
								</div>
								<input type="text" class="form-control" name="apache[config]"
									   placeholder="${LARAGON_PATH}/etc/apache2/"
									   required>
							</div>
							<small class="col-xs-12 form-text text-muted mb-3"> use <code>${LARAGON_PATH}</code> to
								locate config
								inside current install path</small>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Sites Config</span>
								</div>
								<input type="text" class="form-control" name="apache[sites_enabled]"
									   placeholder="${APACHE_LOCATION}/sites-enabled/" required>
							</div>
							<small class="col-xs-12 form-text text-muted mb-3">
								use <code>${APACHE_LOCATION}</code> to Apache config inside current install path. <br/>
								use <code>${LARAGON_PATH}</code> to locate config inside current install path.
							</small>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Alias Config</span>
								</div>
								<input type="text" class="form-control" name="apache[alias]"
									   placeholder="${APACHE_LOCATION}/alias/"
									   required>
							</div>
							<small class="col-xs-12 form-text text-muted mb-3">
								use <code>${APACHE_LOCATION}</code> to Apache config inside current install path. <br/>
								use <code>${LARAGON_PATH}</code> to locate config inside current install path.
							</small>
						</div>

						<h4 class="mb-3">Ports</h4>

						<div class="form-row">
							<div class="input-group col-xs-12 col-md-6 mb-2">
								<div class="input-group-prepend"><span class="input-group-text">HTTP</span></div>
								<input type="number" class="form-control" name="apache[ports][http]" placeholder="80"
									   required>
							</div>

							<div class="input-group col-xs-12 col-md-6 mb-2">
								<div class="input-group-prepend"><span class="input-group-text">HTTPS</span></div>
								<input type="number" class="form-control" name="apache[ports][https]" placeholder="443"
									   required>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header" id="nginx_config">
					<h2 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse"
								data-target="#nginx_config_data">
							Nginx Config
						</button>
					</h2>
				</div>

				<div id="nginx_config_data" class="collapse" aria-labelledby="nginx_config"
					 data-parent="#settings_accordion">
					<div class="card-body">
						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Config Location</span>
								</div>
								<input type="text" class="form-control" name="nginx[config]" placeholder="${LARAGON_PATH}/etc/nginx/"
									   required>
							</div>
							<small class="col-xs-12 form-text text-muted mb-3"> use <code>${LARAGON_PATH}</code> to locate config
								inside current install path</small>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Sites Config</span>
								</div>
								<input type="text" class="form-control" name="nginx[sites_enabled]"
									   placeholder="${NGINX_LOCATION}/sites-enabled/" required>
							</div>
							<small class="col-xs-12 form-text text-muted mb-3">
								use <code>${NGINX_LOCATION}</code> to NGINX config inside current install path. <br/>
								use <code>${LARAGON_PATH}</code> to locate config inside current install path.
							</small>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Alias Config</span>
								</div>
								<input type="text" class="form-control" name="nginx[alias]" placeholder="${NGINX_LOCATION}/alias/"
									   required>
							</div>
							<small class="col-xs-12 form-text text-muted mb-3">
								use <code>${NGINX_LOCATION}</code> to Nginx config inside current install path. <br/>
								use <code>${LARAGON_PATH}</code> to locate config inside current install path.
							</small>
						</div>

						<h4 class="mb-3">Ports</h4>

						<div class="form-row">
							<div class="input-group col-xs-12 col-md-6 mb-2">
								<div class="input-group-prepend"><span class="input-group-text">HTTP</span></div>
								<input type="number" class="form-control" name="nginx[ports][http]" placeholder="80" required>
							</div>

							<div class="input-group col-xs-12 col-md-6 mb-2">
								<div class="input-group-prepend"><span class="input-group-text">HTTPS</span></div>
								<input type="number" class="form-control" name="nginx[ports][https]" placeholder="443" required>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>


	</form>
<?php

template( 'footer' );
