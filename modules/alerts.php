<?php

namespace VSP\Laragon\Modules;

if ( ! trait_exists( '\VSP\Laragon\Modules\Alerts' ) ) {
	/**
	 * Trait Alerts
	 *
	 * @package VSP\Laragon\Modules\Alerts
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	trait Alerts {
		/**
		 * @var string
		 */
		protected $alert_html;

		/**
		 * @return string
		 */
		public function alerts() {
			return $this->alert_html;
		}

		/**
		 * @param        $content
		 * @param string $class
		 */
		private function add_alert_html( $content, $class = 'alert alert-warning' ) {
			$this->alert_html .= '<div class="' . $class . '" role="alert">  ' . $content . '</div>';
		}

		/**
		 * @param $content
		 */
		private function primary( $content ) {
			$this->add_alert_html( $content, 'alert alert-primary' );
		}

		/**
		 * @param $content
		 */
		private function secondary( $content ) {
			$this->add_alert_html( $content, 'alert alert-secondary' );
		}

		/**
		 * @param $content
		 */
		private function success( $content ) {
			$this->add_alert_html( $content, 'alert alert-success' );
		}

		/**
		 * @param $content
		 */
		private function danger( $content ) {
			$this->add_alert_html( $content, 'alert alert-danger' );
		}

		/**
		 * @param $content
		 */
		private function warning( $content ) {
			$this->add_alert_html( $content, 'alert alert-warning' );
		}

		/**
		 * @param $content
		 */
		private function info( $content ) {
			$this->add_alert_html( $content, 'alert alert-info' );
		}

		/**
		 * @param $content
		 */
		private function light( $content ) {
			$this->add_alert_html( $content, 'alert alert-light' );
		}

		/**
		 * @param $content
		 */
		private function dark( $content ) {
			$this->add_alert_html( $content, 'alert alert-dark' );
		}
	}
}