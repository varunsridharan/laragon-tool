<?php

namespace VSP\Laragon\Modules\WP_Install;

use VSP\Laragon\Modules\Alert_Handler;

if ( ! class_exists( '\VSP\Laragon\Modules\WP_Install\Install' ) ) {
	/**
	 * Class Install
	 *
	 * @package VSP\Laragon\Modules\WP_Install
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class Install {
		use Alert_Handler;

		/**
		 * @var array
		 */
		protected $data;

		/**
		 * @var array
		 */
		protected $config;

		/**
		 * Install constructor.
		 *
		 * @param $config
		 * @param $install_data
		 */
		public function __construct( $config, $install_data ) {
			$this->config                = $config;
			$this->data                  = $install_data;
			$this->data['document_root'] = slashit( $this->data['document_root'] );
			$this->create_database();
			$this->success( 'Database Created' );
			if ( $this->data['is_clone'] ) {

			} else {
				$this->copy_source();
			}
			$this->wpconfig();
		}

		/**
		 * Generates WPConfig.
		 *
		 * @return false|string|string[]
		 */
		public function wpconfig() {
			$instance = new \VSP\Laragon\Modules\WP_Install\WPCONFIG( array_merge( $this->config, array(
				'db_host' => isset( $this->data['mysql']['host'] ) ? $this->data['mysql']['host'] : 'localhost',
				'db_user' => isset( $this->data['mysql']['user'] ) ? $this->data['mysql']['user'] : 'root',
				'db_pass' => isset( $this->data['mysql']['password'] ) ? $this->data['mysql']['password'] : '',
			) ) );

			if ( file_exists( $this->data['document_root'] . 'wp-config.php' ) ) {
				@unlink( $this->data['document_root'] . 'wp-config.php' );
			}

			@file_put_contents( $this->data['document_root'] . 'wp-config.php', $instance->generate() );
			@file_put_contents( ABSPATH . '/cache/wpconfig/' . $this->data['host_id'] . '.txt', $instance->generate() );
			$this->success( 'WP-Config File Generated. Cached Source Located @ <a href="cache/wpconfig/' . $this->data['host_id'] . '.txt">cache/wpconfig/' . $this->data['host_id'] . '.txt</a>' );
			return $instance->generate();
		}

		/**
		 * Creates Database.
		 *
		 * @return string
		 */
		public function create_database() {
			return shell_exec( 'mysql -h ' . $this->data['mysql']['host'] . ' -u ' . $this->data['mysql']['user'] . ' --password=' . $this->data['mysql']['password'] . ' -e "create database ' . $this->config['db_name'] . '" ' );
		}

		/**
		 * Creates A Fresh Copy.
		 */
		public function copy_source() {
			$source_file = ABSPATH . '/templates/wp/' . $this->data['version'] . '.zip';
			if ( file_exists( $source_file ) ) {
				$zip = new \ZipArchive;
				$res = $zip->open( $source_file );
				if ( $res === true ) {
					$zip->extractTo( $this->data['document_root'] );
					$zip->close();
					if ( file_exists( $this->data['document_root'] . 'wordpress/index.php' ) ) {
						shell_exec( 'cp -r ' . $this->data['document_root'] . 'wordpress/* ' . $this->data['document_root'] );
						system("rm -rf ".escapeshellarg($this->data['document_root'] . 'wordpress/'));
					}
				} else {
					$this->danger( 'Unable To Open WordPress Source Zip File @ <code>' . $source_file . '</code>' );
				}
			} else {
				$this->danger( 'WordPress Version Does Not Exists.' );
			}
		}
	}
}