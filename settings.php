<?php
require __DIR__ . '/config.php';

if ( isset( $_POST['update_settings'] ) ) {
	$instance = new \VSP\Laragon\Modules\Settings\Save();
	echo $instance->alerts();
}
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
									   placeholder="Full Path on where laragon is installed"
									   value="<?php echo get_option( 'laragon_path' ); ?>" required>
							</div>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend"><span
											class="input-group-text">Global Document Root</span>
								</div>
								<input type="text" class="form-control" name="document_root"
									   placeholder="${LARAGON_PATH}/www" required
									   value="<?php echo get_option( 'document_root' ); ?>">
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
									   required value="<?php echo get_option( 'host_file_prefix' ); ?>">
							</div>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend"><span class="input-group-text">SSL Storage Path</span>
								</div>
								<input type="text" class="form-control" name="ssl_storage_path"
									   placeholder="${LARAGON_PATH}/etc/ssl" required
									   value="<?php echo get_option( 'ssl_storage_path' ); ?>">
							</div>
							<small class="col-xs-12 form-text text-muted mb-3"> use <code>${LARAGON_PATH}</code> to get
								install path</small>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend"><span class="input-group-text">PLATFORM</span></div>
								<input type="text" class="form-control" name="platform"
									   placeholder="windows,linux,mac"
									   required value="<?php echo get_option( 'platform', 'windows' ); ?>">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header" id="host_file_config">
					<h2 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse"
								data-target="#host_file_config_data">Hosts File Config
						</button>
					</h2>
				</div>

				<div id="host_file_config_data" class="collapse show" aria-labelledby="host_file_config"
					 data-parent="#settings_accordion">
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" name="hosts_file_entry"
										   id="hosts_file_entry"
										   required <?php echo ( ! empty( get_option( 'hosts_file_entry', 'on' ) ) ) ? 'checked' : ''; ?>>
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
									   placeholder="C:\Windows\System32\drivers\etc/hosts" required
									   value="<?php echo get_option( 'hosts_file' ); ?>">
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

				<div id="library_config_data" class="collapse show" aria-labelledby="library_config"
					 data-parent="#settings_accordion">
					<div class="card-body">
						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">MK Cert Location</span>
								</div>
								<input type="text" class="form-control" name="library[mkcert_path]"
									   placeholder="${LARAGON_TOOLKIT_PATH}/library/mkcert.exe"
									   required
									   value="<?php echo get_option( 'library/mkcert_path', '${LARAGON_TOOLKIT_PATH}/library/mkcert.exe' ); ?>">
							</div>
							<small class="col-xs-12 form-text text-muted">
								if you have <a href="https://github.com/FiloSottile/mkcert">mkcert</a> already installed
								please
								provide the exact location or enter
								<code>${LARAGON_TOOLKIT_PATH}/library/mkcert.exe</code> to use prepacked source
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

				<div id="apache_config_data" class="collapse show" aria-labelledby="apache_config"
					 data-parent="#settings_accordion">
					<div class="card-body">
						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Config Location</span>
								</div>
								<input type="text" class="form-control" name="apache[config]"
									   placeholder="${LARAGON_PATH}/etc/apache2/"
									   required value="<?php echo get_option( 'apache/config' ); ?>">
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
									   placeholder="${APACHE_PATH}/sites-enabled/" required
									   value="<?php echo get_option( 'apache/sites_enabled' ); ?>">
							</div>
							<small class="col-xs-12 form-text text-muted mb-3">
								use <code>${APACHE_PATH}</code> to Apache config inside current install path. <br/>
								use <code>${LARAGON_PATH}</code> to locate config inside current install path.
							</small>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Alias Config</span>
								</div>
								<input type="text" class="form-control" name="apache[alias]"
									   placeholder="${APACHE_PATH}/alias/"
									   required value="<?php echo get_option( 'apache/alias' ); ?>">
							</div>
							<small class="col-xs-12 form-text text-muted mb-3">
								use <code>${APACHE_PATH}</code> to Apache config inside current install path. <br/>
								use <code>${LARAGON_PATH}</code> to locate config inside current install path.
							</small>
						</div>

						<div class="form-row">
							<div class="col-md-12 mb-3">
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" name="apache[force_ssl]"
										   id="apache_force_ssl"
										   required <?php echo ( true === get_option( 'apache/force_ssl', true ) ) ? 'checked' : ''; ?>>
									<label class="custom-control-label" for="apache_force_ssl">Force SSL
										Redirect</label>
								</div>
							</div>
						</div>

						<h4 class="mb-3">Ports</h4>

						<div class="form-row">
							<div class="input-group col-xs-12 col-md-6 mb-2">
								<div class="input-group-prepend"><span class="input-group-text">HTTP</span></div>
								<input type="number" class="form-control" name="apache[ports][http]" placeholder="80"
									   required value="<?php echo get_option( 'apache/ports/http' ); ?>">
							</div>

							<div class="input-group col-xs-12 col-md-6 mb-2">
								<div class="input-group-prepend"><span class="input-group-text">HTTPS</span></div>
								<input type="number" class="form-control" name="apache[ports][https]" placeholder="443"
									   required value="<?php echo get_option( 'apache/ports/https' ); ?>">
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

				<div id="nginx_config_data" class="collapse show" aria-labelledby="nginx_config"
					 data-parent="#settings_accordion">
					<div class="card-body">
						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Config Location</span>
								</div>
								<input type="text" class="form-control" name="nginx[config]"
									   placeholder="${LARAGON_PATH}/etc/nginx/"
									   required value="<?php echo get_option( 'nginx/config' ); ?>">
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
								<input type="text" class="form-control" name="nginx[sites_enabled]"
									   placeholder="${NGINX_PATH}/sites-enabled/" required
									   value="<?php echo get_option( 'nginx/sites_enabled' ); ?>">
							</div>
							<small class="col-xs-12 form-text text-muted mb-3">
								use <code>${NGINX_PATH}</code> to NGINX config inside current install path. <br/>
								use <code>${LARAGON_PATH}</code> to locate config inside current install path.
							</small>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Alias Config</span>
								</div>
								<input type="text" class="form-control" name="nginx[alias]"
									   placeholder="${NGINX_PATH}/alias/"
									   required value="<?php echo get_option( 'nginx/alias' ); ?>">
							</div>
							<small class="col-xs-12 form-text text-muted mb-3">
								use <code>${NGINX_PATH}</code> to Nginx config inside current install path. <br/>
								use <code>${LARAGON_PATH}</code> to locate config inside current install path.
							</small>
						</div>

						<h4 class="mb-3">Ports</h4>

						<div class="form-row">
							<div class="input-group col-xs-12 col-md-6 mb-2">
								<div class="input-group-prepend"><span class="input-group-text">HTTP</span></div>
								<input type="number" class="form-control" name="nginx[ports][http]" placeholder="80"
									   required value="<?php echo get_option( 'nginx/ports/http' ); ?>">
							</div>

							<div class="input-group col-xs-12 col-md-6 mb-2">
								<div class="input-group-prepend"><span class="input-group-text">HTTPS</span></div>
								<input type="number" class="form-control" name="nginx[ports][https]" placeholder="443"
									   required value="<?php echo get_option( 'nginx/ports/https' ); ?>">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header" id="mysql_config">
					<h2 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse"
								data-target="#mysql_config_data">
							MySQL Config
						</button>
					</h2>
				</div>

				<div id="mysql_config_data" class="collapse show" aria-labelledby="mysql_config"
					 data-parent="#settings_accordion">
					<div class="card-body">
						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Host</span>
								</div>
								<input type="text" class="form-control" name="mysql[host]"
									   placeholder="" value="<?php echo get_option( 'mysql/host' ); ?>">
							</div>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Username</span>
								</div>
								<input type="text" class="form-control" name="mysql[username]"
									   placeholder="root" required
									   value="<?php echo get_option( 'mysql/username' ); ?>">
							</div>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Password</span>
								</div>
								<input type="text" class="form-control" name="mysql[password]"
									   placeholder="" value="<?php echo get_option( 'mysql/password' ); ?>">
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="card">
				<div class="card-header" id="wpclone_config">
					<h2 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse"
								data-target="#wpclone_config_data">
							WP Clone Config
						</button>
					</h2>
				</div>

				<div id="wpclone_config_data" class="collapse show" aria-labelledby="wpclone_config"
					 data-parent="#settings_accordion">
					<div class="card-body">
						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Template WordPress Files</span>
								</div>
								<input type="text" class="form-control" name="wp_clone[template]"
									   placeholder="" value="<?php echo get_option( 'wp_clone/template' ); ?>">
							</div>
						</div>

						<div class="form-row">
							<div class="input-group col-md-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text">Template WordPress Database</span>
								</div>
								<input type="text" class="form-control" name="wp_clone[template_db]"
									   placeholder="root" required
									   value="<?php echo get_option( 'wp_clone/template_db' ); ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<button type="submit" class="btn btn-primary mt-3" name="update_settings">Update Settings</button>
	</form>
<?php

template( 'footer' );
