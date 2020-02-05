<?php

namespace VSP\Laragon\Modules\VHosts;

use VSP\Laragon\Modules\Alert_Handler;

if ( ! class_exists( '\VSP\Laragon\Modules\VHosts\Create' ) ) {
	/**
	 * Class Create
	 *
	 * @package VSP\Laragon\Modules\VHosts
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class Create {
		use Alert_Handler;

		/**
		 * @var array
		 */
		protected $data = array();

		protected $host_id = null;

		/**
		 * Create constructor.
		 *
		 * @param array $data
		 */
		public function create_new( $data ) {
			#$this->host_id = time();
			$default = array(
				'document_root' => false,
				'vhostdomains'  => false,
				'apache'        => array(
					'error_log'  => '${VHOST_DOCUMENT_ROOT}/logs/apache/error.log',
					'access_log' => array(
						'http'  => '${VHOST_DOCUMENT_ROOT}/logs/apache/http-access.log',
						'https' => '${VHOST_DOCUMENT_ROOT}/logs/apache/https-access.log',
					),
				),
				'nginx'         => array(
					'error_log'  => '${VHOST_DOCUMENT_ROOT}/logs/nginx/error.log',
					'access_log' => array(
						'http'  => '${VHOST_DOCUMENT_ROOT}/logs/nginx/http-access.log',
						'https' => '${VHOST_DOCUMENT_ROOT}/logs/nginx/https-access.log',
					),
				),
			);
			$data    = array_merge( $default, $data );

			if ( empty( $data['document_root'] ) ) {
				$this->danger( 'Invalid Document Root. Unable To Create VHost' );
			}

			if ( empty( $data['vhostdomains'] ) ) {
				$this->danger( 'No Domains Provided. Unable To Create VHost' );
			}

			if ( ! is_hosts_file_writeable() ) {
				$this->warning( 'Hosts File Not Writeable. Unable to add required hosts entry.' );
			}

			if ( ! empty( $data['document_root'] ) && ! empty( $data['vhostdomains'] ) ) {
				$this->host_id = md5( $data['document_root'] );
				if ( ! file_exists( $this->host_db_file_path() ) ) {
					$this->data = $data;
					$status     = $this->create_root();
					if ( $status ) {
						$this->handle_domains();
						$this->add_hosts_entry();

						$ssl = new \VSP\Laragon\Modules\SSL\Create( $this->host_id, array_merge( $this->data['vhostdomains']['base'], $this->data['vhostdomains']['wildcard'] ) );
						if ( ! $ssl->generate_ssl() ) {
							$cachef1 = $ssl->key_file( true );
							$cachef2 = $ssl->key_file();
							$cachef3 = $ssl->cert_file( true );
							$cachef4 = $ssl->cert_file();
							$html    = <<<HTML
Unable To Generate SSL / Move Generated SSL From Cache <br/>
1. Copy File From : <code>$cachef1</code>  <br/> To <code>$cachef2</code> <br/><br/>
2. Copy File From : <code>$cachef3</code> <br/> To <code>$cachef4</code>
HTML;
							$this->warning( $html );
						}

						$this->data['ssl'] = array(
							'key'  => $ssl->key_file(),
							'cert' => $ssl->cert_file(),
						);

						$instance = new \VSP\Laragon\Modules\VHosts\Apache( array_merge( array(
							'document_root' => $this->data['document_root'],
							'host_id'       => $this->host_id,
							'ssl'           => array(
								'key'  => $ssl->key_file(),
								'cert' => $ssl->cert_file(),
							),
							'domains'       => array_merge( $this->data['vhostdomains']['base'], $this->data['vhostdomains']['wildcard'] ),
						), $this->data['apache'] ) );
						if ( ! $instance->save_config() ) {
							$this->danger( 'Unable to create Apache config for this VHost' );
						}

						$instance = new \VSP\Laragon\Modules\VHosts\Nginx( array_merge( array(
							'document_root' => $this->data['document_root'],
							'host_id'       => $this->host_id,
							'ssl'           => array(
								'key'  => $ssl->key_file(),
								'cert' => $ssl->cert_file(),
							),
							'domains'       => array_merge( $this->data['vhostdomains']['base'], $this->data['vhostdomains']['wildcard'] ),
						), $this->data['nginx'] ) );
						if ( ! $instance->save_config() ) {
							$this->danger( 'Unable to create Nginx config for this VHost' );
						}

						$this->save_db();
						$this->success( 'VHost Created. Reload Laragon And Start Using it.' );
						#$this->reload_laragon();
					} else {
						$this->danger( 'Unable to create <code>document root</code>. Unable To Create VHost' );
					}
				} else {
					$this->danger( 'VHost Already Exists. edit existing vhost to add more domains.' );
				}
			}
		}

		/**
		 * Generates DB File Path
		 *
		 * @return string
		 */
		public function host_db_file_path() {
			return ABSPATH . '/db/vhosts/' . $this->host_id . '.json';
		}

		/**
		 * @return bool
		 */
		private function create_root() {
			if ( ! empty( $this->data['document_root'] ) ) {
				$this->data['document_root'] = slashit( str_replace( array(
					'${GLOBAL_DOCUMENT_ROOT}',
					'${LARAGON_PATH}',
				), array(
					global_document_root(),
					laragon_install_path(),
				), $this->data['document_root'] ) );
				@mkdir( $this->data['document_root'], 0777, true );
				return file_exists( $this->data['document_root'] );
			}
			return false;
		}

		/**
		 * Creates Domain Array.
		 */
		public function handle_domains() {
			$this->data['vhostdomains'][] = 'abc.domain4.pc';
			$base_domains                 = array();
			$widlcard_domains             = array();

			foreach ( $this->data['vhostdomains'] as $key => $val ) {
				$val                                  = trim( $val );
				$wildcard                             = ltrim( $val, '*.' );
				$base_domains[ $val ]                 = $val;
				$widlcard_domains[ '*.' . $wildcard ] = '*.' . $wildcard;
			}
			$this->data['orginal_vhostdomains'] = $this->data['vhostdomains'];
			$this->data['vhostdomains']         = array(
				'base'     => array_values( array_unique( $base_domains ) ),
				'wildcard' => array_values( array_unique( $widlcard_domains ) ),
			);
			#$this->data['host_entry']           = array_values( array_unique( $hosts_entry_domains ) );
		}

		/**
		 * Adds VHosts Entry.
		 */
		public function add_hosts_entry() {
			$instance = \VSP\Laragon\Modules\Hosts\Parse::instance();
			foreach ( $this->data['vhostdomains']['base'] as $domain ) {
				$instance->add( array(
					'is_disabled' => false,
					'ip'          => '127.0.0.1',
					'domain'      => $domain,
					'comment'     => 'VHosts Entry',
					'by_tool'     => true,
				) );
			}
			$instance->save();
		}

		/**
		 * Creates VHosts data file.
		 */
		public function save_db() {
			$data                = $this->data;
			$data['host_id']     = $this->host_id;
			$data['host_config'] = array(
				'apache' => array(
					'cache'   => ABSPATH . '/cache/vhosts/apache/' . $this->host_id . '.conf',
					'live'    => apache_sites_config() . $this->host_id . '.conf',
					'offline' => apache_sites_config() . 'offline/' . $this->host_id . '.conf',
				),
				'nginx'  => array(
					'cache'   => ABSPATH . '/cache/vhosts/nginx/' . $this->host_id . '.conf',
					'live'    => nginx_sites_config() . $this->host_id . '.conf',
					'offline' => nginx_sites_config() . 'offline/' . $this->host_id . '.conf',
				),
			);
			$status              = file_put_contents( $this->host_db_file_path(), json_encode( $data ) );
			if ( false === $status ) {
				$this->danger( 'Unable to create database file @ <code>' . $this->host_db_file_path() . '</code> with below content <div class="mt-3"><pre>' . json_encode( $data ) . '</pre></div>' );
			}
		}

		public function reload_laragon() {
			var_dump( microtime() );
			var_dump( system( laragon_install_path() . 'laragon reload' ) );
			var_dump( microtime() );
		}
	}
}