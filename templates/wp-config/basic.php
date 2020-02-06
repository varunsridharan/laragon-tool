<?php
/**
 * Domains List : {DOMAINS_LIST}
 * Created Date & Time : {CREATED_TIME}
 * Apache Host : {APACHE_HOST}
 * Nginx Host : {NGINX_HOST}
 */

/* Debug */
define( 'WP_DEBUG', '{DEBUG}' );
if ( WP_DEBUG ) {
	define( 'WP_DEBUG_DISPLAY', '{DEBUG_DISPLAY}' );
	define( 'WP_DEBUG_LOG', '{DEBUG_LOG}' );
}
define( 'SCRIPT_DEBUG', '{SCRIPT_DEBUG}' );
define( 'SAVEQUERIES', '{SAVE_QUERIES}' );

$site_url = '';
$domain   = '';
$scheme   = '';
if ( ! defined( 'WP_CLI' ) ) {
	$scheme   = $_SERVER['REQUEST_SCHEME'];
	$domain   = $_SERVER['HTTP_HOST'];
	$site_url = $scheme . '://' . $domain . '/';
}

/* Database connection */
define( 'DB_NAME', '{DB_NAME}' );
define( 'DB_USER', '{DB_USER}' );
define( 'DB_PASSWORD', '{DB_PASS}' );
define( 'DB_HOST', '{DB_HOST}' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', 'utf8mb4_general_ci' );

/* Tables */
$table_prefix = '{DB_PREFIX}';
define( 'CUSTOM_USER_TABLE', $table_prefix . 'users' );
define( 'CUSTOM_USER_META_TABLE', $table_prefix . 'usermeta' );

/* Security Keys */
// {AUTH_KEYS}

/* HTTPS */
define( 'FORCE_SSL_LOGIN', '{SSL_LOGIN}' );
define( 'FORCE_SSL_ADMIN', '{SSL_ADMIN}' );
define( 'WP_DISABLE_FATAL_ERROR_HANDLER', '{FATAL_ERROR_HANDLER}' );

/* URL / Path */
define( 'WP_SITEURL', $site_url );
define( 'WP_HOME', $site_url );
define( 'WP_CONTENT_URL', $site_url . '/wp-content' );
define( 'WP_PLUGIN_URL', $site_url . '/wp-content/plugins' );
define( 'WPMU_PLUGIN_URL', $site_url . '/wp-content/mu-plugins/' ); # Plugins Must-Use

define( 'WP_CONTENT_DIR', __DIR__ . '/wp-content' );
define( 'WP_PLUGIN_DIR', __DIR__ . '/wp-content/plugins' );
define( 'PLUGINDIR', __DIR__ . '/wp-content/plugins' );
define( 'WPMU_PLUGIN_DIR', __DIR__ . '/wp-content/mu-plugins/' ); # Plugins Must-Use
define( 'MUPLUGINDIR', __DIR__ . '/wp-content/mu-plugins/' ); # Plugins Must-Use
define( 'UPLOADS', 'wp-content/uploads' );
define( 'MEDIA_TRASH', true );

/* Cookies */
define( 'COOKIE_DOMAIN', $domain );
define( 'TEST_COOKIE', 'wordpress_test_cookie' );
define( 'COOKIEHASH', 'V95jHHxAusrL4PLi9H4hMmyjZrNYffJQV7lzEwpjtFHR0NcBndGcLv0OV3T3nJYq' );
define( 'LOGGED_IN_COOKIE', 'wordpress_logged_in_V95jHHxAusrL4PLi9H4hMmyjZrNYffJQV7lzEwpjtFHR0NcBndGcLv0OV3T3nJYq' );
define( 'SECURE_AUTH_COOKIE', 'wordpress_logged_in_V95jHHxAusrL4PLi9H4hMmyjZrNYffJQV7lzEwpjtFHR0NcBndGcLv0OV3T3nJYq' );
define( 'AUTH_COOKIE', 'wordpress_V95jHHxAusrL4PLi9H4hMmyjZrNYffJQV7lzEwpjtFHR0NcBndGcLv0OV3T3nJYq' );
define( 'PASS_COOKIE', 'wordpresspass_V95jHHxAusrL4PLi9H4hMmyjZrNYffJQV7lzEwpjtFHR0NcBndGcLv0OV3T3nJYq' );
define( 'USER_COOKIE', 'wordpressuser_V95jHHxAusrL4PLi9H4hMmyjZrNYffJQV7lzEwpjtFHR0NcBndGcLv0OV3T3nJYq' );
define( 'RECOVERY_MODE_COOKIE', 'wordpress_rec_V95jHHxAusrL4PLi9H4hMmyjZrNYffJQV7lzEwpjtFHR0NcBndGcLv0OV3T3nJYq' );

/* Memory */
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

/* Updating */
define( 'WP_AUTO_UPDATE_CORE', false );
define( 'AUTOMATIC_UPDATER_DISABLED', true );
define( 'CORE_UPGRADE_SKIP_NEW_BUNDLED', false );

/* File edition */
define( 'DISALLOW_FILE_MODS', false );
define( 'DISALLOW_FILE_EDIT', false );
define( 'IMAGE_EDIT_OVERWRITE', false );

/* Performance */
define( 'WP_CACHE', false );
define( 'WP_CACHE_KEY_SALT', 'y2usqlmmbvx1ftfl1m:' );
define( 'COMPRESS_CSS', false );
define( 'COMPRESS_SCRIPTS', false );
define( 'CONCATENATE_SCRIPTS', false );
define( 'ENFORCE_GZIP', false );


/* MultiSite */
define( 'WP_ALLOW_MULTISITE', '{MULTISITE}' );
define( 'SUBDOMAIN_INSTALL', '{SUBDOMAIN}' );
define( 'NOBLOGREDIRECT', $site_url );
define( 'WP_DEFAULT_THEME', 'twentytwenty' );

/* External URL Requests */
define( 'WP_HTTP_BLOCK_EXTERNAL', false );
if ( WP_HTTP_BLOCK_EXTERNAL ) {
	define( 'WP_ACCESSIBLE_HOSTS', '*.wordpress.org,*.github.com' );
}

/* Do not change anything else after this line! Thank you! */

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}
require_once ABSPATH . 'wp-settings.php';
