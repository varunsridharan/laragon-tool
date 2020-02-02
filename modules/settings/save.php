<?php

namespace VSP\Laragon\Modules\Settings;

use VSP\Laragon\Modules\Alert_Handler;

if ( ! class_exists( '\VSP\Laragon\Modules\Settings\Save' ) ) {
	/**
	 * Class save
	 *
	 * @package VSP\Laragon\Modules\Settings
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class Save {
		use Alert_Handler;

		/**
		 * Save constructor.
		 */
		public function __construct() {
			$data        = $_POST;
			$delete_vars = array( 'update_settings' );
			foreach ( $delete_vars as $key ) {
				if ( isset( $data[ $key ] ) ) {
					unset( $data[ $key ] );
				}
			}

			$data['hosts_file_entry'] = ( isset( $data['hosts_file_entry'] ) ) ? 'on' : false;
			$data['platform']         = strtolower( $data['platform'] );

			if ( ! in_array( strtolower( $data['platform'] ), SUPPORTED_PLATFORM, true ) ) {
				$this->warning( 'Invalid Platform Given <code>(' . $data['platform'] . ')</code> expected are : <code>' . implode( ',', SUPPORTED_PLATFORM ) . '</code>' );
				$data['platform'] = 'windows';
			}

			$default_config = get_file_data( ABSPATH . '/db/default-config.json' );
			$default_config = json_decode( $default_config, true );
			$config         = array_replace_recursive( $default_config, $data );

			file_put_contents( ABSPATH . '/db/config.json', json_encode( $config ) );
			global $settings;
			$settings = $config;
			$this->success( 'Settings Saved.' );
		}

	}
}