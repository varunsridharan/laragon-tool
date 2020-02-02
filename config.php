<?php
define( 'ABSPATH', __DIR__ );
define( 'SUPPORTED_PLATFORM', array( 'windows', 'linux', 'mac' ) );

require ABSPATH . '/functions.php';

fetch_settings();

template( 'header' );

glob_include( ABSPATH . '/modules/*.php' );
glob_include( ABSPATH . '/modules/*/*.php' );

cache_setup();
mk_cert_install();
