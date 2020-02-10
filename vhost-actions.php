<?php
require __DIR__ . './config.php';
if ( isset( $_REQUEST['action'] ) ) {
	$action  = ( isset( $_REQUEST['action'] ) ) ? $_REQUEST['action'] : false;
	$type    = ( isset( $_REQUEST['type'] ) ) ? $_REQUEST['type'] : false;
	$type    = ( 'nginx' === $type ) ? 'nginx' : 'apache';
	$host_id = ( isset( $_REQUEST['id'] ) ) ? $_REQUEST['id'] : false;

	if ( 'vhost-update-status' === $action ) {
		$instance = new \VSP\Laragon\Modules\VHosts\Read_DB( host_db_file( $host_id ) );
		if ( $instance->is_readable() ) {
			$status = ( 'false' === $_POST['status'] ) ? 'offline' : 'online';
			var_dump( $instance->change_status( $type, $status ) );
		} else {
			echo json_encode( array( 'status' => 'VHost Not Found!' ) );
		}
		exit;
	}

	if ( 'restore' === $action ) {
		$instance = new \VSP\Laragon\Modules\VHosts\Read_DB( host_db_file( $host_id ) );
		if ( $instance->is_readable() ) {
			$status = $instance->restore_config( $type );
			if ( ! $status ) {
				if ( $instance->regenerate_config( $type ) ) {
					header( 'location:vhost.php?success=restoreconfig' );
					exit;
				}
			} else {
				header( 'location:vhost.php?success=restoreconfig' );
				exit;
			}
		}
		header( 'location:vhost.php?failed=restoreconfig' );
		exit;
	}

	if ( 'regenssl' === $action ) {
		$instance = new \VSP\Laragon\Modules\VHosts\Read_DB( host_db_file( $host_id ) );
		if ( $instance->is_readable() && $instance->regenerate_ssl() ) {
			header( 'location:vhost.php?success=sslregen' );
			exit;
		}
		header( 'location:vhost.php?failed=sslregen' );
		exit;
	}

	if ( 'delete' === $action ) {
		$instance = new \VSP\Laragon\Modules\VHosts\Read_DB( host_db_file( $host_id ) );
		if ( $instance->is_readable() ) {
			$instance->delete_vhost();
			header( 'location:vhost.php?success=delete' );
			exit;
		}
		header( 'location:vhost.php?failed=delete' );
		exit;
	}

	if ( 'edit-config' === $action ) {
		$instance = new \VSP\Laragon\Modules\VHosts\Read_DB( host_db_file( $host_id ) );
		if ( $instance->is_readable() ) {
			if ( isset( $_POST['force-save'] ) && 'yes' === $_POST['force-save'] && isset( $_POST['config-file'] ) && ! empty( $_POST['config-file'] ) ) {
				@file_put_contents( $instance->host_config( $type, 'live' ), $_POST['config-file'] );
				echo <<<HTML
<div class="alert alert-success" role="alert"> Config Updated. Please Restart Laragon </div>
HTML;

			}


			if ( file_exists( $instance->host_config( $type, 'live' ) ) ) {
				$config = @file_get_contents( $instance->host_config( $type, 'live' ) );

				echo <<<HTML
<form method="post">
<h4> Editing : {$instance->host_config( $type, 'live' )} </h4>
	<div class="form-row">
		<textarea name="config-file" style="width: 100%; min-height: 350px; max-height: 650px; height: 550px;font-size: 13px;">$config</textarea>
		<input type="hidden" value="$host_id" name="id">
		<input type="hidden" value="$type" name="type">
		<input type="hidden" value="yes" name="force-save">
	</div>
	<div class="form-row mt-3">
		<button name="save_config" class="btn btn-success">Save Config</button>
	</div>
</form>
HTML;

			}
		}
	}
}