<?php
require __DIR__ . './config.php';

if ( isset( $_POST['update_settings'] ) ) {
	$instance = new \VSP\Laragon\Modules\Settings\Save();
	echo $instance->alerts();
}
?>
	<a href="add-vhost.php" class="btn btn-success">Add Virtual Host</a>
<?php

template( 'footer' );
