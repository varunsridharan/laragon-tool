<?php
define( 'ABSPATH', __DIR__ . '/' );
define( 'SUPPORTED_PLATFORM', array( 'windows', 'linux', 'mac' ) );

require ABSPATH . '/functions.php';

fetch_settings();

if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) || isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest' ) {
	template( 'header' );
}

glob_include( ABSPATH . '/modules/*.php' );
glob_include( ABSPATH . '/modules/*/*.php' );

cache_setup();
mk_cert_install();
