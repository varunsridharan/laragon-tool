<?php
define( 'ABSPATH', __DIR__ );

require ABSPATH . '/functions.php';

fetch_settings();

template( 'header' );

glob_include( ABSPATH . '/modules/*.php' );

glob_include( ABSPATH . '/modules/*/*.php' );

cache_setup();

mk_cert_install();

#require_once ABSPATH . '/modules/ssl/create.php';
