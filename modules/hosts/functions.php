<?php

function hosts_file_path() {
	return get_option( 'hosts_file' );
}

function is_hosts_file_readable() {
	return is_readable( hosts_file_path() );
}

function is_hosts_file_writeable() {
	return is_writable( hosts_file_path() );
}

function hosts_file_checks() {
	$alert = new \VSP\Laragon\Modules\Alert();

	if ( ! is_hosts_file_readable() ) {
		$alert->danger( 'Hosts File Not Readable <code>' . hosts_file_path() . '</code>' );
	}

	if ( ! is_hosts_file_writeable() ) {
		$alert->danger( 'Hosts File Not Writable <code>' . hosts_file_path() . '</code>' );
	}

	return $alert->alerts();
}


function host_db_file( $host_id ) {
	return ABSPATH . '/db/vhosts/' . $host_id . '.json';
}