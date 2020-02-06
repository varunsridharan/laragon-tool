<?php
require __DIR__ . '/config.php';


#var_dump( $_POST );

if ( isset( $_POST['gonow'] ) ) {
	if ( isset( $_POST['vhosts'] ) ) {
		$vhosts_create = new \VSP\Laragon\Modules\VHosts\Create();
		$vhosts_create->create_new( $_POST['vhosts'] );
		$is_clone = ( isset( $_POST['wp_clon_from'] ) ) ? true : false;

		$vhost_db = new \VSP\Laragon\Modules\VHosts\Read_DB( host_db_file( $vhosts_create->host_id() ) );
		if ( $vhost_db->is_readable() ) {
			$wp_config                    = $_POST['wp_config'];
			$wp_config['domains_list']    = $vhost_db->domains_list(false);
			$wp_config['apache_host']     = $vhost_db->host_config( 'apache', 'live' );
			$wp_config['nginx_host']      = $vhost_db->host_config( 'nginx', 'live' );
			$main_config                  = $_POST['wpinstall'];
			$main_config['document_root'] = $vhost_db->document_root();
			$main_config['is_clone']      = $is_clone;
			$main_config['host_id']       = $vhosts_create->host_id();
			$wp_install                   = new \VSP\Laragon\Modules\WP_Install\Install( $wp_config, $main_config );

			echo $vhosts_create->alerts();
			echo $wp_install->alerts();
		}
	}
}

require ABSPATH . '/parts/wp-install/list.php';
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