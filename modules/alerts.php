<?php

namespace VSP\Laragon\Modules;

if ( ! trait_exists( '\VSP\Laragon\Modules\Alert_Handler' ) ) {
	/**
	 * Trait Alerts
	 *
	 * @package VSP\Laragon\Modules\Alerts
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	trait Alert_Handler {
		/**
		 * @var string
		 */
		protected $alert_html;

		/**
		 * @return string
		 */
		public function alerts() {
			$html             = $this->alert_html;
			$this->alert_html = '';
			return $html;
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
		public function primary( $content ) {
			$this->add_alert_html( $content, 'alert alert-primary' );
		}

		/**
		 * @param $content
		 */
		public function secondary( $content ) {
			$this->add_alert_html( $content, 'alert alert-secondary' );
		}

		/**
		 * @param $content
		 */
		public function success( $content ) {
			$this->add_alert_html( $content, 'alert alert-success' );
		}

		/**
		 * @param $content
		 */
		public function danger( $content ) {
			$this->add_alert_html( $content, 'alert alert-danger' );
		}

		/**
		 * @param $content
		 */
		public function warning( $content ) {
			$this->add_alert_html( $content, 'alert alert-warning' );
		}

		/**
		 * @param $content
		 */
		public function info( $content ) {
			$this->add_alert_html( $content, 'alert alert-info' );
		}

		/**
		 * @param $content
		 */
		public function light( $content ) {
			$this->add_alert_html( $content, 'alert alert-light' );
		}

		/**
		 * @param $content
		 */
		public function dark( $content ) {
			$this->add_alert_html( $content, 'alert alert-dark' );
		}
	}
}