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
		'header'     => ABSPATH . '/parts/header.php',
		'footer'     => ABSPATH . '/parts/footer.php',
		'menu'       => ABSPATH . '/parts/menu.php',
		'breadcrumb' => ABSPATH . '/parts/breadcrumb.php',
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
	}

	if ( ! file_exists( ABSPATH . '/cache/ssl' ) ) {
		@mkdir( ABSPATH . '/cache/ssl' );
	}
}

/**
 * Hosts File Related Functions.
 */

function hosts_file_path() {
	return get_option( 'hosts_file' );
}

function is_hosts_file_readable() {
	return is_readable( hosts_file_path() );
}

function is_hosts_file_writeable() {
	return is_readable( hosts_file_path() );
}

function hosts_file_checks() {
	$alert = new \VSP\Laragon\Modules\Alert();

	if ( ! is_hosts_file_readable() ) {
		$alert->danger( 'Hosts File Not Readable <code>' . hosts_file_path() . '</code>' );
	}

	if ( ! is_hosts_file_writeable() ) {
		$alert->danger( 'Hosts File Not Writable <code>' . hosts_file_path() . '</code>' );
	}

	return $alert->alerts();
}