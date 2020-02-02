<?php

namespace VSP\Laragon\Modules\Hosts;

if ( ! class_exists( '\VSP\Laragon\Modules\Hosts\Parse' ) ) {
	/**
	 * Class Parse
	 *
	 * @package VSP\Laragon\Modules\Hosts
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class Parse {
		/**
		 * @var array
		 */
		protected $hosts;

		protected static $instance = null;

		/**
		 * Returns A Static Instance.
		 *
		 * @static
		 * @return \VSP\Laragon\Modules\Hosts\Parse
		 */
		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Parse constructor.
		 */
		public function __construct() {
			$contents = $this->contents();
			$this->parse( $contents );
		}

		/**
		 * @return array
		 */
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
		 * Generates Host's ID.
		 *
		 * @param $array
		 *
		 * @return string
		 */
		private function host_record_id( $array ) {
			return ( is_array( $array ) ) ? md5( serialize( $array ) ) : '';
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
					$is_disabled                                    = ( isset( $host[1] ) && ! empty( $host[1] ) && '#' === trim( $host[1] ) ) ? true : false;
					$ip                                             = ( isset( $host[2] ) ) ? $host[2] : null;
					$domain                                         = ( isset( $host[3] ) ) ? $host[3] : null;
					$comment                                        = ( isset( $host[4] ) ) ? $host[4] : null;
					$array                                          = array(
						'is_disabled' => $is_disabled,
						'ip'          => $ip,
						'domain'      => explode( ' ', trim( $domain ) ),
						'comment'     => $comment,
						'by_tool'     => false,
					);
					$this->hosts[ $this->host_record_id( $array ) ] = $array;
				}
			}
		}

		/**
		 * Add Record.
		 *
		 * @param $data
		 *
		 * @return bool
		 */
		public function add( $data ) {
			$defaults = array(
				'is_disabled' => false,
				'ip'          => '127.0.0.1',
				'domain'      => array(),
				'comment'     => null,
				'by_tool'     => false,
			);
			$data     = array_merge( $defaults, $data );

			if ( ! is_array( $data['domain'] ) ) {
				$data['domain'] = array_filter( explode( ' ', $data['domain'] ) );
			}

			$data['ip'] = ( ! empty( $data['ip'] ) ) ? $data['ip'] : '127.0.0.1';

			if ( ! empty( $data['domain'] ) ) {
				$this->hosts[ $this->host_record_id( $data ) ] = $data;
				return true;
			}
			return false;
		}

		/**
		 *  Saves Hosts File.
		 */
		public function save() {
			if ( is_hosts_file_readable() && is_hosts_file_writeable() ) {
				$backup_name = 'backup-hosts-' . time();
				copy( hosts_file_path(), ABSPATH . '/cache/hosts/' . $backup_name );

				$by_tool    = array();
				$by_general = array();

				foreach ( $this->get_list() as $host ) {
					$content = ( true === $host['is_disabled'] ) ? '# ' : '';
					$content .= $host['ip'] . ' ';
					$content .= ( is_array( $host['domain'] ) ) ? implode( ' ', $host['domain'] ) : $host['domain'];
					$content .= ' # ' . trim( ltrim( $host['comment'], '#' ) );
					if ( true === $host['by_tool'] ) {
						$by_tool[] = trim( $content );
					} else {
						$by_general[] = trim( $content );
					}
				}

				$file_content = implode( PHP_EOL, $by_general ) . PHP_EOL . PHP_EOL;
				$file_content .= '##################################' . PHP_EOL;
				$file_content .= '         Laragon ToolKit' . PHP_EOL;
				$file_content .= '########                 #########' . PHP_EOL . PHP_EOL;
				$file_content .= implode( PHP_EOL, $by_tool ) . PHP_EOL . PHP_EOL;
				$file_content .= '########                 #########' . PHP_EOL;
				$file_content .= '         Laragon ToolKit' . PHP_EOL;
				$file_content .= '##################################' . PHP_EOL;
				file_put_contents( hosts_file_path(), $file_content );
				return true;
			}
			return false;
		}

		/**
		 * Validates if given hosts exists.
		 *
		 * @param $id
		 *
		 * @return bool
		 */
		public function hosts_exists( $id ) {
			return ( isset( $this->hosts[ $id ] ) );
		}

		/**
		 * Updates hosts information.
		 *
		 * @param $id
		 * @param $data
		 *
		 * @return bool
		 */
		public function update_hosts_data( $id, $data ) {
			if ( ! $this->hosts_exists( $id ) ) {
				return false;
			}
			if ( ! empty( $data ) && is_array( $data ) ) {
				foreach ( $data as $key => $val ) {
					$this->hosts[ $id ][ $key ] = $val;
				}

				$new_id                 = $this->host_record_id( $this->hosts[ $id ] );
				$this->hosts[ $new_id ] = $this->hosts[ $id ];
				unset( $this->hosts[ $id ] );
				return $new_id;
			}
			return true;
		}

		/**
		 * Removes A Host.
		 *
		 * @param $host_id
		 *
		 * @return bool
		 */
		public function remove_host( $host_id ) {
			if ( $this->hosts_exists( $host_id ) ) {
				unset( $this->hosts[ $host_id ] );
				$this->save();
			}
			return true;
		}
	}
}