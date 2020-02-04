<?php

namespace VSP\Laragon\Modules\VHosts;

if ( ! class_exists( '\VSP\Laragon\Modules\VHosts\Nginx' ) ) {
	class Nginx extends Config_Base {
		public function __construct( $data ) {
			parent::__construct( $data );
			$this->create_logs();
		}
	}
}