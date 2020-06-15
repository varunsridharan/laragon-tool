<?php
require __DIR__ . '/config.php';
$output = '';
echo '<pre>';
exec( 'cd ' . ABSPATH . ' && composer run update_data', $output );
echo implode( PHP_EOL, array_filter( $output ) );
echo '<pre>';
template( 'footer' );
