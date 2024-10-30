<?php

/*
 * Plugin Name:	Megamo
 * Plugin URI:	https://www.megamo.pl/en
 * Description:	MgoSync app enables WooCommmerce stores to connect with Megamo integration tool. Expand your store by importing products from any supplier and keeping them up to date!
 * Version:	2.1.5
 * Author:	megamo
 * Author URI: https://megamo.pl
 */

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

// adding some global variables to be used elsewhere
define( 'MGO_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'MGO_PLUGIN_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

// load config
require_once 'config/config.php';

// calling main class
require_once 'includes/class-plugin.php';

// if (is_admin()) {
Plugin::getInstance();
// }
