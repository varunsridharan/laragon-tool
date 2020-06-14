<?php
require __DIR__ . './config.php';

if ( isset( $_POST['update_settings'] ) ) {
	$instance = new \VSP\Laragon\Modules\Settings\Save();
	echo $instance->alerts();
}

if ( isset( $_GET['success'] ) || isset( $_GET['failed'] ) ) {
	$instance = new \VSP\Laragon\Modules\Alert();
	if ( isset( $_GET['success'] ) ) {
		switch ( $_GET['success'] ) {
			case 'restoreconfig':
				$instance->success( 'VHost Config Restored Successfully. <strong>Please Restart Laragon</strong>.' );
				break;
			case 'sslregen':
				$instance->success( 'VHost SSL Certificate Regenerated Successfully. <strong>Please Restart Laragon</strong>' );
				break;
			case 'delete':
				$instance->success( 'VHost Deleted Successfully. <strong>Please Restart Laragon</strong>' );
				$instance->info( '<i>Document Root</i> , <i>Access Logs</i> & <i>Error Logs</i> are not deleted. you can remove them' );
				break;
		}
	}

	if ( isset( $_GET['failed'] ) ) {
		switch ( $_GET['failed'] ) {
			case 'restoreconfig':
				$instance->warning( 'Failed To Restore VHost Conf.</strong>.' );
				break;
			case 'sslregen':
				$instance->warning( 'Failed To Generate SSL.</strong>' );
				break;
			case 'delete':
				$instance->success( 'Failed To Selected VHost' );
				break;
		}
	}
	echo $instance->alerts();
}

?>
	<div class="row">
		<div class="col-6">
			<a href="add-vhost.php" class="btn btn-success">Add Virtual Host</a>
		</div>
		<div class="col-6 text-right">
			<div class="dropdown">
				<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="regen"
						data-toggle="dropdown"
						aria-haspopup="true" aria-expanded="false">Re-Generate
				</button>
				<div class="dropdown-menu" aria-labelledby="regen">
					<a class="dropdown-item" href="vhost-actions.php?action=regenerate&type=ssl">SSL Certificate</a>
					<h6 class="dropdown-header">VHost Config</h6>
					<a class="dropdown-item" href="vhost-actions.php?action=regenerate&type=apache">Apache</a>
					<a class="dropdown-item" href="vhost-actions.php?action=regenerate&type=nginx">Nginx</a>
				</div>
			</div>
		</div>
	</div>
	<br/>
	<table class="table table-striped table-bordered table-hover">
		<thead class="thead-dark">
		<tr>
			<th>Host Info</th>
			<th>Domains</th>
			<th style="width:20px;">Apache</th>
			<th style="width:20px;">Nginx</th>
			<th style="width:160px;">SSL Expairy</th>
			<th style="width:150px;">Actions</th>
		</tr>
		</thead>

		<tbody>
		<?php
		$files = glob( ABSPATH . '/db/vhosts/*.json' );
		if ( ! empty( $files ) ) {
			foreach ( $files as $db ) {
				$instance = new \VSP\Laragon\Modules\VHosts\Read_DB( $db );


				if ( $instance->is_readable() ) {
					$doc_root        = $instance->document_root();
					$doc_root_bg     = ( is_dir( $doc_root ) && ! file_exists( $doc_root ) ) ? 'table-danger' : '';
					$doc_root_exists = ( is_dir( $doc_root ) && ! file_exists( $doc_root ) ) ? '<span class="text-danger font-weight-bolder">Document Root Not Found</span>' : '';

					$nginx_status       = $instance->apache_status();
					$nginx_status       = ( 'online' === $nginx_status ) ? 'checked' : $nginx_status;
					$nginx_status       = ( 'offline' === $nginx_status ) ? ' ' : $nginx_status;
					$nginx_status       = ( false === $nginx_status ) ? 'disabled="disabled"' : $nginx_status;
					$apache_status_html = '
<div class="custom-control custom-switch" data-toggle="tooltip" data-placement="bottom" title="' . $instance->vhost_readable_status( 'apache' ) . '" >
<input type="checkbox" class="custom-control-input change-vhost-status" id="' . $instance->host_id() . '_apache_status" ' . $nginx_status . ' data-type="apache" data-hostid="' . $instance->host_id() . '" />
<label class="custom-control-label" for="' . $instance->host_id() . '_apache_status"></label>
</div > ';

					$nginx_status      = $instance->nginx_status();
					$nginx_status      = ( 'online' === $nginx_status ) ? 'checked' : $nginx_status;
					$nginx_status      = ( 'offline' === $nginx_status ) ? ' ' : $nginx_status;
					$nginx_status      = ( false === $nginx_status ) ? 'disabled="disabled"' : $nginx_status;
					$nginx_status_html = '
<div class="custom-control custom-switch" data-toggle="tooltip" data-placement="bottom" title="' . $instance->vhost_readable_status( 'nginx' ) . '" >
<input type="checkbox" class="custom-control-input change-vhost-status" id="' . $instance->host_id() . '_nginx_status" ' . $nginx_status . '  data-type="nginx" data-hostid="' . $instance->host_id() . '"/>
<label class="custom-control-label" for="' . $instance->host_id() . '_nginx_status"></label>
</div > ';

					echo <<<HTML
<tr class="${doc_root_bg}">
	<td>
		<small><strong>Host ID : </strong> {$instance->host_id()}</small> <br/>
		<small> <strong>Root : </strong> <a target="_new" href="file:{$instance->document_root()}">{$instance->document_root()}</a> </small>
		<small class="d-block">$doc_root_exists</small>
	</td>
	<td><small>{$instance->domains_list()}</small></td>
	<td>$apache_status_html</td>
	<td>$nginx_status_html</td>
	<td>{$instance->ssl_expairy_status()}</td>
	<td>
		<div class="dropdown">
			<button class="btn btn-secondary btn-sm dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Edit </button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
				<h6 class="dropdown-header">Basic</h6>
				<a class="dropdown-item" href="#">Add / Edit Domains</a>
				<a class="dropdown-item regen-ssl" href="vhost-actions.php?action=regenssl&id={$instance->host_id()}&type=apache">Regenerate SSL</a>
				<div class="dropdown-divider"></div>
				<h6 class="dropdown-header">Edit Config</h6>
				<a class="dropdown-item" href="vhost-actions.php?action=edit-config&id={$instance->host_id()}&type=apache">Apache</a>
				<a class="dropdown-item" href="vhost-actions.php?action=edit-config&id={$instance->host_id()}&type=nginx">Nginx</a>
				<div class="dropdown-divider"></div>
				<h6 class="dropdown-header">Restore Config</h6>
				<a class="dropdown-item text-danger restore-vhost-config" href="vhost-actions.php?action=restore&id={$instance->host_id()}&type=apache">Apache</a>
				<a class="dropdown-item text-danger restore-vhost-config" href="vhost-actions.php?action=restore&id={$instance->host_id()}&type=nginx">Nginx</a>
			</div>
			<a type="button" class="btn btn-danger btn-sm delete-vhost" href="vhost-actions.php?action=delete&id={$instance->host_id()}">Delete</a>
		</div>
	</td>
</tr>
HTML;

				}
			}
		}
		?>

		</tbody>

		<tfoot class="thead-dark">
		<tr>
			<th>Host Info</th>
			<th>Domains</th>
			<th>Apache</th>
			<th>Nginx</th>
			<th>SSL Expairy</th>
			<th>Actions</th>
		</tr>
		</tfoot>

	</table>
<?php

template( 'footer' );
