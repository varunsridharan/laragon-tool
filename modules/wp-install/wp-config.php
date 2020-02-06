<?php

namespace VSP\Laragon\Modules\WP_Install;

if ( ! class_exists( '\VSP\Laragon\Modules\WP_Install\WPCONFIG' ) ) {
	/**
	 * Class Install
	 *
	 * @package VSP\Laragon\Modules\WP_Install
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class WPCONFIG {
		/**
		 * WPCONFIG constructor.
		 *
		 * @param $config
		 */
		public function __construct( $config ) {
			$this->config = $config;
		}

		/**
		 * Generates WPConfig Data.
		 *
		 * @return false|string|string[]
		 */
		public function generate() {
			$find = array(
				"'{DB_PREFIX}'"           => ( isset( $this->config['db_prefix'] ) ) ? $this->config['db_prefix'] : 'wp_',
				"'{DB_USER}'"             => ( isset( $this->config['db_user'] ) ) ? $this->config['db_user'] : 'root',
				"'{DB_NAME}'"             => ( isset( $this->config['db_name'] ) ) ? $this->config['db_name'] : false,
				"'{DB_PASS}'"             => ( isset( $this->config['db_pass'] ) ) ? $this->config['db_pass'] : '',
				"'{DB_HOST}'"             => ( isset( $this->config['db_host'] ) ) ? $this->config['db_host'] : 'localhost',
				"'{SSL_LOGIN}'"           => ( isset( $this->config['ssl_login'] ) && 'on' === $this->config['ssl_login'] ) ? 'TRUE' : 'FALSE',
				"'{SSL_ADMIN}'"           => ( isset( $this->config['ssl_admin'] ) && 'on' === $this->config['ssl_admin'] ) ? 'TRUE' : 'FALSE',
				"'{FATAL_ERROR_HANDLER}'" => ( isset( $this->config['error_handler'] ) && 'on' === $this->config['error_handler'] ) ? 'TRUE' : 'FALSE',
				"'{MULTISITE}'"           => ( isset( $this->config['multisite'] ) && 'on' === $this->config['multisite'] ) ? 'TRUE' : 'FALSE',
				"'{SUBDOMAIN}'"           => ( isset( $this->config['multisite_subdomain'] ) && 'on' === $this->config['multisite_subdomain'] ) ? 'TRUE' : 'FALSE',
				"'{DEBUG}'"               => ( isset( $this->config['debug'] ) && 'on' === $this->config['debug'] ) ? 'TRUE' : 'FALSE',
				"'{DEBUG_DISPLAY}'"       => ( isset( $this->config['debug_display'] ) && 'on' === $this->config['debug_display'] ) ? 'TRUE' : 'FALSE',
				"'{DEBUG_LOG}'"           => ( isset( $this->config['debug_log'] ) && 'on' === $this->config['debug_log'] ) ? 'TRUE' : 'FALSE',
				"'{SCRIPT_DEBUG}'"        => ( isset( $this->config['script_debug'] ) && 'on' === $this->config['script_debug'] ) ? 'TRUE' : 'FALSE',
				"'{SAVE_QUERIES}'"        => ( isset( $this->config['save_queries'] ) && 'on' === $this->config['save_queries'] ) ? 'TRUE' : 'FALSE',
			);

			$content = file_get_contents( ABSPATH . '/templates/wp-config/basic.php' );
			$content = str_replace( array_keys( $find ), array_values( $find ), $content );
			return $content;
		}
	}
}