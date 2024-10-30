<?php

namespace Megamo;
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

if ( file_exists(MGO_PLUGIN_DIR . "/config/config-local.php") ) {
	require_once MGO_PLUGIN_DIR . "/config/config-local.php";
}


if ( ! defined( 'MGO_VERSION' ) ) {
    define( 'MGO_VERSION', '2.0.3' );
}

if ( ! defined( 'MGO_LOGO_SVG' ) && file_exists( MGO_PLUGIN_DIR . '/assets/images/svg/mgo-logo.svg' ) ) {
	define( 'MGO_LOGO_SVG', file_get_contents( MGO_PLUGIN_DIR . '/assets/images/svg/mgo-logo.svg' ) );
}
if ( ! defined( 'MGO_ICON_SVG' ) && file_exists( MGO_PLUGIN_DIR . '/assets/images/svg/mgo-icon.svg' ) ) {
	define( 'MGO_ICON_SVG', file_get_contents( MGO_PLUGIN_DIR . '/assets/images/svg/mgo-icon.svg' ) );
}

if ( ! defined( 'MGO_SYNC_API_NAMESPCE' ) ) {
	define( 'MGO_SYNC_API_NAMESPCE', "mgo/sync/v1" );
}

if ( ! defined( 'MEGAMO_SERVICE_URL' ) ) {
	define( 'MEGAMO_SERVICE_URL', "https://panel.megamo.co.uk" );
}
