<?php

namespace VSP\Laragon\Modules\WP_Install;

if ( ! class_exists( '\VSP\Laragon\Modules\WP_Install\Install' ) ) {
	/**
	 * Class Install
	 *
	 * @package VSP\Laragon\Modules\WP_Install
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class Install {
		public function __construct( $config, $install_data ) {
			$this->config       = $config;
			$this->install_data = $install_data;
			$this->wpconfig();
		}

		public function wpconfig() {
			$instance = new \VSP\Laragon\Modules\WP_Install\WPCONFIG( array_merge( $this->config, array(
				'db_host' => isset( $this->install_data['mysql']['host'] ) ? $this->install_data['mysql']['host'] : 'localhost',
				'db_user' => isset( $this->install_data['mysql']['user'] ) ? $this->install_data['mysql']['user'] : 'root',
				'db_pass' => isset( $this->install_data['mysql']['password'] ) ? $this->install_data['mysql']['password'] : '',
			) ) );

			return $instance->generate();
		}
	}
}