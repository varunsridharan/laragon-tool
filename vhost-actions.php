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
			header( 'location:vhost.php?success=sslregen' );
			exit;
		}
		header( 'location:vhost.php?failed=sslregen' );
		exit;
	}
}