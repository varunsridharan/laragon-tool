<?php

namespace VSP\Laragon\Modules\VHosts;

if ( ! class_exists( '\VSP\Laragon\Modules\VHosts\Apache' ) ) {
	/**
	 * Class Apache
	 *
	 * @package VSP\Laragon\Modules\VHosts
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class Apache extends Config_Base {
		/**
		 * Apache constructor.
		 *
		 * @param $data
		 */
		public function __construct( $data ) {
			parent::__construct( $data );
			$this->create_logs();
			$code = $this->generate_config_code();
			$this->save_config( $code );
		}

		/**
		 * Generates Config File.
		 *
		 * @return string
		 */
		public function generate_config_code() {
			$doc_root         = $this->data['document_root'];
			$main_domain      = $this->data['main_domain'];
			$error_log        = $this->data['error_log'];
			$http_access_log  = $this->data['access_log']['http'];
			$https_access_log = $this->data['access_log']['https'];
			$http_port        = apache_port();
			$https_port       = apache_port( true );

			$ServerAlias = array();
			if ( ! empty( $this->data['domains'] ) ) {
				foreach ( $this->data['domains'] as $adomain ) {
					#$$ServerAlias .= '	ServerAlias ' . $adomain . PHP_EOL;
					$ServerAlias[] = <<<CONF
	ServerAlias $adomain
CONF;

				}
			}
			$ServerAlias = implode( PHP_EOL, $ServerAlias );

			$config = <<<config
define DOC_ROOT "$doc_root"
define MAIN_DOMAIN "$main_domain"
define ERROR_LOG "$error_log"
define HTTP_ACCESS_LOG "$http_access_log"
define HTTPS_ACCESS_LOG "$https_access_log"
define SSL_CERT ""
define SSL_KEY ""

<VirtualHost *:$http_port>
	DocumentRoot "\${DOC_ROOT}"
	ServerName \${MAIN_DOMAIN}
$ServerAlias

	ErrorLog "\${ERROR_LOG}"

	<IfModule log_config_module>
		CustomLog "\${HTTP_ACCESS_LOG}" combined
	</IfModule>

	<Directory "\${DOC_ROOT}">
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>

<VirtualHost *:$https_port>
    DocumentRoot "\${DOC_ROOT}"
    ServerName \${MAIN_DOMAIN}
$ServerAlias

	<IfModule log_config_module>
        CustomLog "\${HTTPS_ACCESS_LOG}" combined
    </IfModule>

	<Directory "\${DOC_ROOT}">
        AllowOverride All
        Require all granted
    </Directory>

    #SSLEngine on
    #SSLCertificateFile      \${SSL_CERT}
    #SSLCertificateKeyFile   \${SSL_KEY}
</VirtualHost>
config;
			return $config;
		}

		/**
		 * Saves Config.
		 *
		 * @param $code
		 */
		protected function save_config( $code ) {
			$this->save_cache( 'apache', $code );
			file_put_contents( slashit( apache_sites_config() ) . $this->data['host_id'] . '.conf', $code );
		}
	}
}