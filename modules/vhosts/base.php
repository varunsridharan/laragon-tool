<?php

namespace VSP\Laragon\Modules\VHosts;

if ( ! class_exists( '\VSP\Laragon\Modules\VHosts\Config_Base' ) ) {
	/**
	 * Class Config_Base
	 *
	 * @package VSP\Laragon\Modules\VHosts
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	abstract class Config_Base {
		/**
		 * @var array
		 */
		protected $data;

		/**
		 * @var string
		 */
		protected $config_code;

		/**
		 * Config_Base constructor.
		 *
		 * @param $config
		 */
		public function __construct( $config ) {
			$defaults = array(
				'document_root' => false,
				'host_id'       => false,
				'access_log'    => array(
					'http'  => false,
					'https' => false,
				),
				'ssl'           => array(
					'key'  => false,
					'cert' => false,
				),
				'error_log'     => false,
				'domains'       => false,
			);

			$this->data                = array_merge( $defaults, $config );
			$this->data['main_domain'] = $this->data['domains'][0];
			unset( $this->data['domains'][0] );
		}

		/**
		 * Creates Log Folder.
		 */
		protected function create_logs() {
			$this->data['access_log']['http']  = unslashit( str_replace( '${VHOST_DOCUMENT_ROOT}', $this->data['document_root'], $this->data['access_log']['http'] ) );
			$this->data['access_log']['https'] = unslashit( str_replace( '${VHOST_DOCUMENT_ROOT}', $this->data['document_root'], $this->data['access_log']['https'] ) );
			$this->data['error_log']           = unslashit( str_replace( '${VHOST_DOCUMENT_ROOT}', $this->data['document_root'], $this->data['error_log'] ) );

			if ( ! file_exists( $this->data['access_log']['http'] ) ) {
				mkdir( $this->data['access_log']['http'], 0777, true );
				rmdir( $this->data['access_log']['http'] );
				@file_put_contents( $this->data['access_log']['http'], '' );
			}

			if ( ! file_exists( $this->data['access_log']['https'] ) ) {
				mkdir( $this->data['access_log']['https'], 0777, true );
				rmdir( $this->data['access_log']['https'] );
				@file_put_contents( $this->data['access_log']['https'], '' );
			}

			if ( ! file_exists( $this->data['error_log'] ) ) {
				mkdir( $this->data['error_log'], 0777, true );
				rmdir( $this->data['error_log'] );
				@file_put_contents( $this->data['error_log'], '' );
			}
		}

		/**
		 * Saves Cache Config.
		 *
		 * @param $type
		 *
		 * @return bool
		 */
		protected function save_cache( $type ) {
			return ( @file_put_contents( ABSPATH . '/cache/vhosts/' . $type . '/' . $this->data['host_id'] . '.conf', $this->config_code ) );
		}
	}
}