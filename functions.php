<?php
global $settings;
$settings = array();

/**
 * Runs include cmd using glob function.
 *
 * @param $path
 */
function glob_include( $path ) {
	$data = array_filter( glob( $path ) );
	if ( ! empty( $data ) ) {
		foreach ( $data as $p ) {
			include $p;
		}
	}
}

/**
 * Checks if file exits and if it does then returns its content.
 *
 * @param $path
 *
 * @return bool|false|string
 */
function get_file_data( $path ) {
	if ( file_exists( $path ) ) {
		return file_get_contents( $path );
	}
	return false;
}

/**
 * Recursively find a key's value in array
 *
 * @param string       $keys 'a/b/c'
 * @param array|object $array_or_object
 * @param null|mixed   $default
 * @param string       $delimiter
 *
 * @return mixed
 */
function array_key_get( $keys, $array_or_object, $default = null, $delimiter = '/' ) {
	if ( ! is_array( $keys ) ) {
		$keys = explode( $delimiter, (string) $keys );
	}

	$key_or_property = array_shift( $keys );
	$is_object       = is_object( $array_or_object );

	if ( isset( $keys[0] ) ) {
		return ( $is_object ) ? array_key_get( $keys, $array_or_object->{$key_or_property}, $default ) : array_key_get( $keys, $array_or_object[ $key_or_property ], $default );
	} else {
		if ( $is_object ) {
			return ( isset( $array_or_object->{$key_or_property} ) ) ? $array_or_object->{$key_or_property} : $default;
		}
		return ( isset( $array_or_object[ $key_or_property ] ) ) ? $array_or_object[ $key_or_property ] : $default;
	}
}

/**
 * Fetches Settings From DB.
 */
function fetch_settings() {
	global $settings;
	$config         = get_file_data( ABSPATH . '/db/config.json' );
	$config         = json_decode( $config, true );
	$default_config = get_file_data( ABSPATH . '/db/default-config.json' );
	$default_config = json_decode( $default_config, true );
	$config         = array_replace_recursive( $default_config, $config );
	$settings       = $config;
}

/**
 * @param      $key
 * @param null $default
 *
 * @return mixed
 */
function get_option( $key, $default = null ) {
	global $settings;
	return array_key_get( $key, $settings, $default );
}

/**
 * Checks & Includes The File.
 *
 * @param $type
 *
 * @return bool
 */
function template( $type ) {
	$files = array(
		'header'        => ABSPATH . '/parts/header.php',
		'footer'        => ABSPATH . '/parts/footer.php',
		'menu'          => ABSPATH . '/parts/menu.php',
		'breadcrumb'    => ABSPATH . '/parts/breadcrumb.php',
		'add-new-hosts' => ABSPATH . '/parts/add-new-hosts.php',
	);

	if ( isset( $files[ $type ] ) ) {
		require $files[ $type ];
		return true;
	}
	return false;
}

/**
 * Setup Basic Cache Folders.
 */
function cache_setup() {
	if ( ! file_exists( ABSPATH . '/cache' ) ) {
		@mkdir( ABSPATH . '/cache' );
	}

	if ( ! file_exists( ABSPATH . '/cache/vhosts' ) ) {
		@mkdir( ABSPATH . '/cache/vhosts' );
		@mkdir( ABSPATH . '/cache/vhosts/apache' );
		@mkdir( ABSPATH . '/cache/vhosts/nginx' );
	}

	if ( ! file_exists( ABSPATH . '/cache/ssl' ) ) {
		@mkdir( ABSPATH . '/cache/ssl' );
	}

	if ( ! file_exists( ABSPATH . '/cache/hosts' ) ) {
		@mkdir( ABSPATH . '/cache/hosts' );
	}
}

/**
 * @param $str
 *
 * @return string
 */
function unslashit( $str ) {
	return str_replace( '//', '/', rtrim( $str, '/' ) );
}

/**
 * @param $str
 *
 * @return string
 */
function slashit( $str ) {
	return str_replace( '//', '/', unslashit( $str ) . '/' );
}

/**
 * Settings Config.
 */

/**
 * @param $type
 *
 * @return string
 */
function laragon_toolkit_paths( $type ) {
	$return = null;
	switch ( $type ) {
		case 'laragon_install_path':
			$return = slashit( get_option( 'laragon_path' ) );
			break;
		case 'global_document_root':
			$return = slashit( str_replace( '${LARAGON_PATH}', laragon_install_path(), get_option( 'document_root' ) ) );
			break;
		case 'mk_cert_path':
			$path   = get_option( 'library/mkcert_path', '${LARAGON_TOOLKIT_PATH}/library/mkcert.exe' );
			$return = unslashit( str_replace( '${LARAGON_TOOLKIT_PATH}', ABSPATH, $path ) );
			break;

		case 'ssl_storage':
			$return = slashit( str_replace( '${LARAGON_PATH}', laragon_install_path(), get_option( 'ssl_storage_path' ) ) );
			break;
		case 'apache/config':
		case 'nginx/config':
			$return = slashit( str_replace( '${LARAGON_PATH}', laragon_install_path(), get_option( $type ) ) );
			break;
		case 'apache/sites_enabled':
		case 'apache/alias':
		case 'nginx/sites_enabled':
		case 'nginx/alias':
			$return = slashit( str_replace( array(
				'${LARAGON_PATH}',
				'${APACHE_PATH}',
				'${NGINX_PATH}',
			), array(
				laragon_install_path(),
				apache_config(),
				nginx_config(),
			), get_option( $type ) ) );
			break;
	}
	return $return;
}

/**
 * Returns Laragon Install Path.
 *
 * @return string
 */
function laragon_install_path() {
	return laragon_toolkit_paths( 'laragon_install_path' );
}

/**
 * Returns Global Document Root.
 *
 * @return string
 */
function global_document_root() {
	return laragon_toolkit_paths( 'global_document_root' );
}

/**
 * Fetches & Returns MKCERT_PATH
 *
 * @return mixed|string
 */
function mk_cert_path() {
	return laragon_toolkit_paths( 'mk_cert_path' );
}

/**
 * Retuns Apache Config.
 *
 * @return string
 */
function apache_config() {
	return laragon_toolkit_paths( 'apache/config' );
}

/**
 * Retuns Apache Sites Config.
 *
 * @return string
 */
function apache_sites_config() {
	return laragon_toolkit_paths( 'apache/sites_enabled' );
}

/**
 * Retuns Apache Sites Config.
 *
 * @return string
 */
function apache_alias_config() {
	return laragon_toolkit_paths( 'apache/alias' );
}

/**
 * Retuns Nginx Config.
 *
 * @return string
 */
function nginx_config() {
	return laragon_toolkit_paths( 'nginx/config' );
}

/**
 * Retuns Nginx Sites Config.
 *
 * @return string
 */
function nginx_sites_config() {
	return laragon_toolkit_paths( 'nginx/sites_enabled' );
}

/**
 * Retuns nginx Sites Config.
 *
 * @return string
 */
function nginx_alias_config() {
	return laragon_toolkit_paths( 'nginx/alias' );
}

/**
 * Returns Apache Port.
 *
 * @param bool $https
 *
 * @return mixed
 */
function apache_port( $https = false ) {
	return ( $https ) ? get_option( 'apache/ports/https' ) : get_option( 'apache/ports/http' );
}

/**
 * Returns Nginx Port.
 *
 * @param bool $https
 *
 * @return mixed
 */
function nginx_port( $https = false ) {
	return ( $https ) ? get_option( 'nginx/ports/https' ) : get_option( 'nginx/ports/http' );
}

/**
 * Returns Production Storage Path.
 *
 * @return string
 */
function ssl_storage() {
	return laragon_toolkit_paths( 'ssl_storage' );
}