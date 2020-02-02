<?php

namespace VSP\Laragon\Modules\Hosts;

if ( ! class_exists( '\VSP\Laragon\Modules\Hosts\Parse' ) ) {
	class Parse {
		protected $hosts;

		public function __construct() {
			$contents = $this->contents();
			$this->parse( $contents );
		}

		public function get_list() {
			return $this->hosts;
		}

		/**
		 * Retrives File Contents.
		 *
		 * @return array|string
		 */
		private function contents() {
			if ( is_hosts_file_readable() ) {
				$file    = hosts_file_path();
				$content = file_get_contents( $file );
				return $content;
			}
			return '';
		}

		/**
		 * Parses Hosts File.
		 *
		 * @param $contents
		 */
		private function parse( $contents ) {
			$re = '/^\s*(#*)\s*(\b[1-2]{0,1}[0-9]{1,2}\.[1-2]{0,1}[0-9]{1,2}\.[1-2]{0,1}[0-9]{1,2}\.[1-2]{0,1}[0-9]{1,2}\b)\s+([a-zA-Z0-9\.\- ]+)(?:\s+)*?(#.*)?/mi';
			preg_match_all( $re, $contents, $matches, PREG_SET_ORDER, 0 );
			if ( ! empty( $matches ) ) {
				foreach ( $matches as $host ) {
					$is_disabled        = ( isset( $host[1] ) && ! empty( $host[1] ) && '#' === trim( $host[1] ) ) ? true : false;
					$ip                 = ( isset( $host[2] ) ) ? $host[2] : null;
					$domain             = ( isset( $host[3] ) ) ? $host[3] : null;
					$comment            = ( isset( $host[4] ) ) ? $host[4] : null;
					$array              = array(
						'is_disabled' => $is_disabled,
						'ip'          => $ip,
						'domain'      => explode( ' ', trim( $domain ) ),
						'comment'     => $comment,
						'by_tool'     => false,
					);
					$id                 = md5( serialize( $array ) );
					$this->hosts[ $id ] = $array;
				}
			}
		}
	}
}