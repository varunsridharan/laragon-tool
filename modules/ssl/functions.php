<?php
define( 'MKCERT_PATH_DEFAULT', ABSPATH . '/library/mkcert.exe' );

/**
 * Fetches & Returns MKCERT_PATH
 *
 * @return mixed|string
 */
function mk_cert_path() {
	$path = get_option( 'LIBRARY/mkcert_path', 'default' );
	return ( 'default' !== $path ) ? $path : MKCERT_PATH_DEFAULT;
}

/**
 * Installs MKCRT
 */
function mk_cert_install() {
	$cmd = mk_cert_path() . ' -install';
	exec( $cmd );
}

function mk_cert( $domains ) {
	$cmd = mk_cert_path() . ' ' . $domains;
	$p1  = $p2 = '';
	#var_dump( exec( $cmd, $p1, $p2 ) );
	#var_dump( shell_exec( $cmd ) );
	var_dump( passthru( $cmd, $p1 ) );
	var_dump( $p1, $p2 );
}