<?php
/**
 * Installs MKCRT
 */
function mk_cert_install() {
	$cmd = mk_cert_path() . ' -install';
	/*var_dump( 'System' );
	$exec_output = $exec_return = false;
	var_dump( shell_exec( $cmd ) );
	var_dump( $exec_output, $exec_return );*/
}

function mk_cert( $domains ) {
	$cmd = mk_cert_path() . ' ' . $domains;
	$p1  = $p2 = '';
	#var_dump( exec( $cmd, $p1, $p2 ) );
	#var_dump( shell_exec( $cmd ) );
	var_dump( passthru( $cmd, $p1 ) );
	var_dump( $p1, $p2 );
}