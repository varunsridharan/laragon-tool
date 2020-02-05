<?php

namespace VSP\Laragon\Modules\VHosts;

if ( ! class_exists( '\VSP\Laragon\Modules\VHosts\Nginx' ) ) {
	class Nginx extends Config_Base {
		public function __construct( $data ) {
			parent::__construct( $data );
			parent::__construct( $data );
			$this->create_logs();
			$this->config_code = $this->generate_config_code();
		}

		/**
		 * Generates Nginx Config.
		 *
		 * @return string
		 */
		public function generate_config_code() {
			$doc_root         = $this->data['document_root'];
			$main_domain      = $this->data['main_domain'];
			$error_log        = $this->data['error_log'];
			$http_access_log  = $this->data['access_log']['http'];
			$https_access_log = $this->data['access_log']['https'];
			$http_port        = nginx_port();
			$https_port       = nginx_port( true );
			$ssl_key          = $this->data['ssl']['key'];
			$ssl_cert         = $this->data['ssl']['cert'];
			$main_domain      .= ' ' . implode( ' ', $this->data['domains'] );
			#var_dump( $this->data );
			$config = <<<config
server {
    listen $http_port;
    listen $https_port ssl;
    server_name $main_domain;
    root "$doc_root";
    
    index index.html index.htm index.php;
 
	access_log $http_access_log;
	error_log $error_log;
        
    location / {
        try_files \$uri \$uri/ /index.php\$is_args\$args;
		autoindex on;
    }
    
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass php_upstream;		
        #fastcgi_pass unix:/run/php/php7.0-fpm.sock;
    }

    # Enable SSL
    ssl_certificate "$ssl_cert";
    ssl_certificate_key "$ssl_key";
    ssl_session_timeout 5m;
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    ssl_ciphers ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv3:+EXP;
    ssl_prefer_server_ciphers on;
	
	
    charset utf-8;
	
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    location ~ /\.ht {
        deny all;
    }
}
config;
			return $config;

		}

		/**
		 * Saves Config.
		 *
		 * @param $code
		 *
		 * @return bool
		 */
		public function save_config() {
			$this->save_cache( 'nginx' );
			return ( @file_put_contents( slashit( nginx_sites_config() ) . $this->data['host_id'] . '.conf', $this->config_code ) );
		}
	}
}