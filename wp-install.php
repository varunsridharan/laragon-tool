<?php
require __DIR__ . '/config.php';

require ABSPATH . '/parts/wp-install/list.php';
var_dump( $_POST );
?>
	<form method="post">
		<?php
		include ABSPATH . '/parts/wp-install/vhost.php';
		include ABSPATH . '/parts/wp-install/wp.php';
		include ABSPATH . '/parts/wp-install/database.php';
		include ABSPATH . '/parts/wp-install/mysql-form.php';
		include ABSPATH . '/parts/vhosts/apache.php';
		include ABSPATH . '/parts/vhosts/nginx.php';
		?>
		<button type="submit" class="btn-success btn mt-3" name="gonow">Clone / Install</button>
	</form>
<?php
template( 'footer' );
?>