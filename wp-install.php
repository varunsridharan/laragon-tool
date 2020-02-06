<?php
require __DIR__ . '/config.php';

require ABSPATH . '/parts/wp-install/list.php';
var_dump( $_POST );

if ( isset( $_POST['gonow'] ) ) {
	if ( isset( $_POST['vhosts'] ) ) {
		$vhosts_create = new \VSP\Laragon\Modules\VHosts\Create();
		$vhosts_create->create_new( $_POST['vhosts'] );
		$is_clone = ( isset( $_POST['wp_clon_from'] ) ) ? true : false;

		$vhost_db = new \VSP\Laragon\Modules\VHosts\Read_DB( host_db_file( $vhosts_create->host_id() ) );
		if ( $vhost_db->is_readable() ) {
			$main_config                  = $_POST['wpinstall'];
			$main_config['document_root'] = $vhost_db->document_root();
			$wp_install                   = new \VSP\Laragon\Modules\WP_Install\Install( $_POST['wp_config'], $main_config );
		}

		echo $vhosts_create->alerts();
	}
}

?>
	<form method="post">
		<?php
		include ABSPATH . '/parts/wp-install/vhost.php';
		include ABSPATH . '/parts/wp-install/wp.php';
		include ABSPATH . '/parts/wp-install/mysql-form.php';
		include ABSPATH . '/parts/vhosts/apache.php';
		include ABSPATH . '/parts/vhosts/nginx.php';
		?>
		<button type="submit" class="btn-success btn mt-3" name="gonow">Clone / Install</button>
	</form>
<?php
template( 'footer' );
?>