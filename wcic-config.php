<?php
function wpic_server_url() {
        $server_name = $_SERVER['SERVER_NAME'];
        if (!in_array($_SERVER['SERVER_PORT'], [80, 443])) {
            $port = ":$_SERVER[SERVER_PORT]";
        } else {
            $port = '';
        }
        if (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) {
            $scheme = 'https';
        } else {
            $scheme = 'http';
        }
        return $scheme.'://'.$server_name.$port;
}
define( 'WP_SITE_URL', wpic_server_url() );

define( 'WP_CONTENT_DIR', dirname( __FILE__ ) ); // no trailing slash, full paths only - WP_SITE_URL is defined further down

define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/dependency' ); // full path, no trailing slash

define( 'WP_PLUGIN_URL', WP_SITE_URL . '/dependency' ); // full url, no trailing slash

/** Sets up Apps vars and included files. */
require_once( ABSPATH . 'wcic-database.php' );
/** Sets up Apps vars and included files. */
require_once( ABSPATH . 'wcic-settings.php' );