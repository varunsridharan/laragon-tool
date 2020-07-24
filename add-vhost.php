<?php
require __DIR__ . '/config.php';

if ( isset( $_POST['add_vhost'] ) ) {
	$instance = new \VSP\Laragon\Modules\VHosts\Create();
	$instance->create_new( $_POST['vhosts'] );
	echo $instance->alerts();
	#var_dump( $_POST['vhosts'] );
}
?>

	<form id="addVhosts" method="post" class="needs-validation" novalidate>
		<?php include ABSPATH . '/parts/vhosts/doc-root.php'; ?>
		<?php include ABSPATH . '/parts/vhosts/domains.php'; ?>
		<?php include ABSPATH . '/parts/vhosts/apache.php'; ?>
		<?php include ABSPATH . '/parts/vhosts/nginx.php'; ?>
		<button type="submit" class="btn btn-primary mt-3" name="add_vhost">Create VHost</button>
	</form>
<?php

template( 'footer' );
