<?php
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
define( 'CUSTOM_USER_TABLE', $table_prefix . 'user' );
define( 'CUSTOM_USER_META_TABLE', $table_prefix . 'usermeta' );

/* Security Keys */
// {AUTH_KEYS}

/* HTTPS */
define( 'FORCE_SSL_LOGIN', true );
define( 'FORCE_SSL_ADMIN', true );
define( 'WP_DISABLE_FATAL_ERROR_HANDLER', false );

/* URL / Path */
define( 'WP_SITEURL', $site_url );
define( 'WP_HOME', $site_url );
define( 'WP_CONTENT_DIR', __DIR__ . '/wp-content' );
define( 'WP_CONTENT_URL', $site_url . '/wp-content' );
define( 'WP_PLUGIN_DIR', __DIR__ . '/wp-content/plugins' );
define( 'PLUGINDIR', __DIR__ . '/wp-content/plugins' );
define( 'WP_PLUGIN_URL', $site_url . '/wp-content/plugins' );
define( 'UPLOADS', 'wp-content/uploads' );

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

/* Content */
define( 'AUTOSAVE_INTERVAL', 30 );
define( 'WP_POST_REVISIONS', 5 );
define( 'MEDIA_TRASH', false );
define( 'EMPTY_TRASH_DAYS', 7 );
define( 'WP_MAIL_INTERVAL', 86400 );

/* Memory */
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

/* Updating */
define( 'AUTOMATIC_UPDATER_DISABLED', true );
define( 'WP_AUTO_UPDATE_CORE', false );
define( 'CORE_UPGRADE_SKIP_NEW_BUNDLED', false );
define( 'DO_NOT_UPGRADE_GLOBAL_TABLES', true );

/* File edition */
define( 'DISALLOW_FILE_MODS', true );
define( 'DISALLOW_FILE_EDIT', true );
define( 'IMAGE_EDIT_OVERWRITE', false );

/* Performance */
define( 'WP_CACHE', true );
define( 'WP_CACHE_KEY_SALT', 'y2usqlmmbvx1ftfl1m:' );
define( 'COMPRESS_CSS', true );
define( 'COMPRESS_SCRIPTS', true );
define( 'CONCATENATE_SCRIPTS', true );
define( 'ENFORCE_GZIP', true );

/* Cron */
define( 'DISABLE_WP_CRON', false );
define( 'ALTERNATE_WP_CRON', false );
define( 'WP_CRON_LOCK_TIMEOUT', 60 );

/* Plugins Must-Use */
define( 'WPMU_PLUGIN_DIR', __DIR__ . '/wp-content/mu-plugins/' );
define( 'WPMU_PLUGIN_URL', $site_url . '/wp-content/mu-plugins/' );
define( 'MUPLUGINDIR', __DIR__ . '/wp-content/mu-plugins/' );

/* MultiSite */
define( 'WP_ALLOW_MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', true );
define( 'NOBLOGREDIRECT', $site_url );
define( 'WP_DEFAULT_THEME', 'twentytwenty' );

/* External URL Requests */
define( 'WP_HTTP_BLOCK_EXTERNAL', false );
if ( WP_HTTP_BLOCK_EXTERNAL ) {
	define( 'WP_ACCESSIBLE_HOSTS', '*.wordpress.org,*.github.com' );
}

/* Debug */
define( 'WP_DEBUG', true );
if ( WP_DEBUG ) {
	define( 'WP_DEBUG_DISPLAY', true );
	define( 'WP_DEBUG_LOG', __DIR__ . '/wp-content/debug.log' );
}
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );

/* Do not change anything else after this line! Thank you! */

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}
require_once ABSPATH . 'wp-settings.php';
