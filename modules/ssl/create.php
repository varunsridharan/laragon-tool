<?php

namespace VSP\Laragon\Modules\SSL;

if ( ! class_exists( '\VSP\Laragon\Modules\SSL\Create' ) ) {
	/**
	 * Class Create
	 *
	 * @package VSP\Laragon\Modules\SSL
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class Create {
		protected $domains;
		protected $host_id;

		/**
		 * Create constructor.
		 *
		 * @param $host_id
		 * @param $domains
		 */
		public function __construct( $host_id, $domains ) {
			$this->host_id = $host_id;
			$this->domains = $domains;
		}

		/**
		 * Generates Key File Path.
		 *
		 * @param bool $cache
		 *
		 * @return string
		 */
		public function key_file( $cache = false ) {
			$cache_dir = ABSPATH . '/cache/ssl/' . $this->host_id;
			$ssl_dir   = ssl_storage() . $this->host_id;
			@mkdir( $cache_dir, 0777, true );
			@mkdir( $ssl_dir, 0777, true );
			$dir = ( $cache ) ? $cache_dir : $ssl_dir;
			return $dir . '/key.pem';
		}

		/**
		 * Generates Cert File Path.
		 *
		 * @param bool $cache
		 *
		 * @return string
		 */
		public function cert_file( $cache = false ) {
			$cache_dir = ABSPATH . '/cache/ssl/' . $this->host_id;
			$ssl_dir   = ssl_storage() . $this->host_id;
			@mkdir( $cache_dir, 0777, true );
			@mkdir( $ssl_dir, 0777, true );
			$dir = ( $cache ) ? $cache_dir : $ssl_dir;
			return $dir . '/cert.pem';
		}

		/**
		 * Generates SSL.
		 */
		public function generate_ssl() {
			$domains = is_array( $this->domains ) ? implode( ' ', $this->domains ) : $this->domains;
			$cmd     = mk_cert_path() . ' -key-file ' . $this->key_file( true ) . ' -cert-file ' . $this->cert_file( true ) . ' ' . $domains;
			exec( $cmd );
			$is_exists = ( file_exists( $this->key_file( true ) ) && file_exists( $this->cert_file( true ) ) );
			if ( $is_exists ) {
				$cp1 = copy( $this->key_file( true ), $this->key_file( false ) );
				$cp2 = copy( $this->cert_file( true ), $this->cert_file( false ) );
				return ( $cp1 && $cp2 );
			}
			return true;
		}
	}
}