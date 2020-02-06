<?php

namespace VSP\Laragon\Modules\VHosts;

if ( ! class_exists( '\VSP\Laragon\Modules\VHosts\Read_DB' ) ) {
	/**
	 * Class Config_Base
	 *
	 * @package VSP\Laragon\Modules\VHosts
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class Read_DB {
		/**
		 * @var array
		 */
		protected $data;

		/**
		 * @var string
		 */
		protected $config_file;

		/**
		 * Config_Base constructor.
		 *
		 * @param $db_file
		 */
		public function __construct( $db_file ) {
			$this->config_file = $db_file;
		}

		/**
		 * Checks if file readable.
		 *
		 * @return bool
		 */
		public function is_readable() {
			if ( file_exists( $this->config_file ) && is_readable( $this->config_file ) ) {
				$content = @file_get_contents( $this->config_file );
				if ( ! empty( $content ) ) {
					$content = json_decode( $content, true );
					if ( ! empty( $content ) && isset( $content['host_id'] ) && ! empty( $content['host_id'] ) ) {
						$this->data = $content;
						return true;
					}
				}
			}
			return false;
		}

		/**
		 * @return mixed|string
		 */
		public function document_root() {
			return ( isset( $this->data ['document_root'] ) ) ? $this->data ['document_root'] : '';
		}

		/**
		 * @return mixed
		 */
		public function host_id() {
			return $this->data['host_id'];
		}

		/**
		 * @param $type
		 * @param $status
		 *
		 * @return bool
		 */
		public function host_config( $type, $status ) {
			return ( isset( $this->data['host_config'][ $type ][ $status ] ) ) ? $this->data['host_config'][ $type ][ $status ] : false;
		}

		/**
		 *  Generates Domain Lists.
		 *
		 * @param bool $html
		 *
		 * @return array|string
		 */
		public function domains_list( $html = true ) {
			$vhostdomains = array_merge( $this->data['vhostdomains']['base'], $this->data['vhostdomains']['wildcard'] );
			return ( true === $html ) ? implode( '<br/>', $vhostdomains ) : $vhostdomains;
		}

		/**
		 * @return bool|string
		 */
		public function apache_status() {
			if ( file_exists( $this->host_config( 'apache', 'live' ) ) ) {
				return 'online';
			}

			if ( file_exists( $this->host_config( 'apache', 'offline' ) ) ) {
				return 'offline';
			}
			return false;
		}

		/**
		 * @return bool|string
		 */
		public function nginx_status() {
			if ( file_exists( $this->host_config( 'nginx', 'live' ) ) ) {
				return 'online';
			}

			if ( file_exists( $this->host_config( 'nginx', 'offline' ) ) ) {
				return 'offline';
			}
			return false;
		}

		/**
		 * @param $type
		 *
		 * @return string
		 */
		public function vhost_readable_status( $type ) {
			$status = ( 'nginx' === $type ) ? $this->nginx_status() : $this->apache_status();
			if ( 'online' === $status ) {
				return 'V-Host Online';
			}

			if ( 'offline' === $status ) {
				return 'V-Host Offline';
			}

			return 'Config File Not Found';
		}

		/**
		 * Changes VHost Status.
		 *
		 * @param $type
		 * @param $status
		 *
		 * @return bool
		 */
		public function change_status( $type, $status ) {
			@mkdir( apache_sites_config() . 'offline' );
			@mkdir( nginx_sites_config() . 'offline' );
			$type = ( in_array( $type, array( 'apache', 'nginx' ), true ) ) ? $type : 'apache';

			if ( 'online' === $status && file_exists( $this->host_config( $type, 'offline' ) ) ) {
				@copy( $this->host_config( $type, 'offline' ), $this->host_config( $type, 'live' ) );
				@unlink( $this->host_config( $type, 'offline' ) );
				return true;
			}

			if ( 'offline' === $status && file_exists( $this->host_config( $type, 'live' ) ) ) {
				@copy( $this->host_config( $type, 'live' ), $this->host_config( $type, 'offline' ) );
				@unlink( $this->host_config( $type, 'live' ) );
				return true;
			}

			return false;
		}

		/**
		 * Restores Config.
		 *
		 * @param $type
		 *
		 * @return bool
		 */
		public function restore_config( $type ) {
			$type = ( in_array( $type, array( 'apache', 'nginx' ), true ) ) ? $type : 'apache';

			if ( file_exists( $this->host_config( $type, 'cache' ) ) ) {
				@copy( $this->host_config( $type, 'cache' ), $this->host_config( $type, 'live' ) );
				return true;
			}
			return false;
		}

		/**
		 * Regenerates SSL.
		 *
		 * @return bool
		 */
		public function regenerate_ssl() {
			$ssl = new \VSP\Laragon\Modules\SSL\Create( $this->host_id(), array_merge( $this->data['vhostdomains']['base'], $this->data['vhostdomains']['wildcard'] ) );
			return $ssl->generate_ssl();
		}

		/**
		 * Regenerate Config.
		 *
		 * @param $type
		 *
		 * @return bool
		 */
		public function regenerate_config( $type ) {
			if ( 'apache' === $type ) {
				$instance = new \VSP\Laragon\Modules\VHosts\Apache( array_merge( array(
					'document_root' => $this->document_root(),
					'host_id'       => $this->host_id(),
					'ssl'           => array(
						'key'  => $this->data['ssl']['key'],
						'cert' => $this->data['ssl']['cert'],
					),
					'domains'       => array_merge( $this->data['vhostdomains']['base'], $this->data['vhostdomains']['wildcard'] ),
				), $this->data['apache'] ) );
				return $instance->save_config();
			}

			if ( 'apache' === $type ) {
				$instance = new \VSP\Laragon\Modules\VHosts\Nginx( array_merge( array(
					'document_root' => $this->document_root(),
					'host_id'       => $this->host_id(),
					'ssl'           => array(
						'key'  => $this->data['ssl']['key'],
						'cert' => $this->data['ssl']['cert'],
					),
					'domains'       => array_merge( $this->data['vhostdomains']['base'], $this->data['vhostdomains']['wildcard'] ),
				), $this->data['nginx'] ) );

				return $instance->save_config();
			}
		}

		/**
		 * @return string
		 */
		public function ssl_expairy_status() {
			if ( isset( $this->data['ssl']['cert'] ) && file_exists( $this->data['ssl']['cert'] ) ) {
				$certinfo = openssl_x509_parse( file_get_contents( $this->data['ssl']['cert'] ) );
				if ( $certinfo['validFrom_time_t'] > time() || $certinfo['validTo_time_t'] < time() ) {
					return '<span class="text-danger">SSL Expaired</span>';
				} else {
					return '<span class="text-success">' . date( 'D d/M/Y', $certinfo['validTo_time_t'] ) . '</span>';
				}
			}
			return '<span class="text-danger">SSL Certificate Does Not Exists</span>';
		}

		public function delete_vhost() {
			if ( file_exists( $this->host_config( 'apache', 'live' ) ) ) {
				unlink( $this->host_config( 'apache', 'live' ) );
			}

			if ( file_exists( $this->host_config( 'apache', 'offline' ) ) ) {
				unlink( $this->host_config( 'apache', 'offline' ) );
			}

			if ( file_exists( $this->host_config( 'apache', 'cache' ) ) ) {
				unlink( $this->host_config( 'apache', 'cache' ) );
			}

			if ( file_exists( $this->host_config( 'nginx', 'live' ) ) ) {
				unlink( $this->host_config( 'nginx', 'live' ) );
			}

			if ( file_exists( $this->host_config( 'nginx', 'offline' ) ) ) {
				unlink( $this->host_config( 'nginx', 'offline' ) );
			}

			if ( file_exists( $this->host_config( 'nginx', 'cache' ) ) ) {
				unlink( $this->host_config( 'nginx', 'cache' ) );
			}

			$ssl = new \VSP\Laragon\Modules\SSL\Create( $this->host_id(), '' );

			if ( file_exists( $ssl->key_file() ) ) {
				unlink( $ssl->key_file() );
			}

			if ( file_exists( $ssl->key_file( true ) ) ) {
				unlink( $ssl->key_file( true ) );
			}

			if ( file_exists( $ssl->cert_file() ) ) {
				unlink( $ssl->cert_file() );
			}

			if ( file_exists( $ssl->cert_file( true ) ) ) {
				unlink( $ssl->cert_file( true ) );
			}

			if ( file_exists( dirname( $ssl->key_file() ) ) ) {
				rmdir( dirname( $ssl->key_file() ) );
			}

			if ( file_exists( dirname( $ssl->key_file( true ) ) ) ) {
				rmdir( dirname( $ssl->key_file( true ) ) );
			}

			if ( file_exists( dirname( $ssl->cert_file() ) ) ) {
				rmdir( dirname( $ssl->cert_file() ) );
			}

			if ( file_exists( dirname( $ssl->cert_file( true ) ) ) ) {
				rmdir( dirname( $ssl->cert_file( true ) ) );
			}

			if ( file_exists( host_db_file( $this->host_id() ) ) ) {
				unlink( host_db_file( $this->host_id() ) );
			}
		}
	}
}