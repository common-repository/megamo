<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

require_once MGO_PLUGIN_DIR . '/includes/models/class-requirements.php';

class Plugin {
	private static $instance = null;
	private $requirements;

	// returning and instance if exists or creating it
	public static function getInstance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	// currently unused
	public function activation() {
	}

	// currently unused
	public function deactivation() {
	}

	public function registerScripts( bool $in_footer = true ): void {
		if ( file_exists( MGO_PLUGIN_DIR . '/js/mgo-scripts.js' ) ) {
			wp_register_script( 'mgo-scripts', MGO_PLUGIN_URL . '/js/mgo-scripts.js' );
			wp_enqueue_script( 'mgo-scripts', '', array(), false, $in_footer );
		}
	}

	public function registerStyles(): void {
		if ( file_exists( MGO_PLUGIN_DIR . '/css/mgo-styles.css' ) ) {
			wp_register_style( 'mgo-styles', MGO_PLUGIN_URL . '/css/mgo-styles.css' );
			wp_enqueue_style( 'mgo-styles' );
		}
	}

	//----------------------------------------------------------------
	// DASHBOARD
	public function dashboard(): void {
		// import global logo svg (base64)
		if ( defined( 'MGO_LOGO_SVG' ) ) {
			$mgo_logo_svg_b64 = 'data:image/svg+xml;base64,' . base64_encode( MGO_ICON_SVG );
		} else {
			$mgo_logo_svg_b64 = '';
		}

		// add main menu page
		$this->addWpMenu(
			'MgoSync',
			'mgo_dashboard',
			$mgo_logo_svg_b64,
			'Dashboard',
			'dashboardCtrl'
		);
	}

	public function dashboardCtrl(): void {
		require_once 'controllers/class-dashboard-controller.php';
		$controller = new DashboardController();
		$controller->getView();
	}

	//----------------------------------------------------------------
	// CONTACT FORM
	public function contactForm(): void {
		// add contact form submenu
		$this->addWpSubmenu(
			'mgo_dashboard',
			'Contact us',
			'mgo_contact_us',
			'contactUsCtrl',
        );
	}

	public function contactUsCtrl(): void {
		require_once 'controllers/class-contact-us-controller.php';
		$controller = new ContactUsController();
		$controller->getView();
	}

	//----------------------------------------------------------------
	// SUPPLIER BROWSER
	public function suppliersBrowser(): void {
		// add suppliers browser submenu
		$this->addWpSubmenu(
			'mgo_dashboard',
			'Browse suppliers',
			'mgo_browse_suppliers',
			'browseSuppliersCtrl',
        );
	}

	public function browseSuppliersCtrl(): void {
		require_once 'controllers/class-browse-suppliers-controller.php';
		$controller = new BrowseSuppliersController();
		$controller->getView();
	}

	//----------------------------------------------------------------
	// ABOUT US
	public function aboutUs(): void {
		// add suppliers browser submenu
		$this->addWpSubmenu(
			'mgo_dashboard',
			'About us',
			'mgo_guideline',
			'aboutUsCtrl',
        );
	}


	public function settings(): void {
		// add settings submenu
		$this->addWpSubmenu(
			'mgo_dashboard',
			'Settings',
			'mgo_settings',
			'settingsCtrl'
        );
	}

	public function aboutUsCtrl(): void {
		require_once 'controllers/class-about-us-controller.php';
		$controller = new AboutUsController();
		$controller->getView();
	}


	public function settingsCtrl(): void {
		require_once 'controllers/class-settings-controller.php';
		$controller = new SettingsController();
		$controller->getView();
	}



	//----------------------------------------------------------------
	// WOOCOMMERCE SPECIFIC
	//----------------------------------------------------------------
	// initiating the plugin core functionallity

	private function __construct() {

		$this->requirements = Requirements::getInstance();
		$this->runPlugin();
	}

	// this acts as a mapper for menu creaction in WORDPRESS
	private function addWpMenu(
		string $name,
		string $slug,
		string $img,
		string $submenu_name,
		string $ctrl,
		string $perm = 'manage_options'
	): void {
		$title = 'MgoSync | ' . $name;

		add_menu_page(
			$title,                 // page_title - The text to be displayed in the title tags of the page when the menu is selected.
			$name,                  // menu_title - The text to be used for the menu.
			$perm,                  // capability - The capability required for this menu to be displayed to the user
			$slug,                  // menu_slug - The slug name to refer to this menu by. Should be unique for this menu page and only include lowercase alphanumeric, dashes, and underscores characters.
			array( $this, $ctrl ),    // callback - The function to be called to output the content for this page.
			$img                    // icon_url - The URL to the icon to be used for this menu. ( '' / 'none' / 'dashicons-...' / 'data:image/svg+xml;base64,...' / url )
		);

		$this->addWpSubmenu(
			$slug,
			$submenu_name,
			$slug,
			$ctrl
		);
	}

	// this acts as a mapper for submenu creaction in WORDPRESS
	private function addWpSubmenu(
		string $hook,
		string $name,
		string $slug,
		?string $ctrl = null,
		string $perm = 'manage_options'
	): void {
		$title = 'MgoSync | ' . $name;

		if ( ! $ctrl ) {
			$ctrl = $slug . 'Ctrl';
		}

		add_submenu_page(
			$hook,                  // parent_slug - The slug name for the parent menu (or the file name of a standard WordPress admin page).
			$title,                 // page_title - The text to be displayed in the title tags of the page when the menu is selected.
			$name,                  // menu_title - The text to be used for the menu.
			$perm,                  // capability - The capability required for this menu to be displayed to the user.
			$slug,                  // menu_slug - The slug name to refer to this menu by. Should be unique for this menu and only include lowercase alphanumeric, dashes, and underscores characters
			array( $this, $ctrl )     // callback - The function to be called to output the content for this page.
		);
		do_action( $slug . '_hook' );
	}

	// WORDPRESS specific run function
	private function runPlugin(): void {

		register_activation_hook( __FILE__, array( $this, 'activation' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );

		// apply css on backoffice
		add_action( 'admin_enqueue_scripts', array( $this, 'registerScripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'registerStyles' ) );

		// apply css on storefront - not needed as the app works only on the backoffice
		// add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
		// add_action('wp_enqueue_scripts', array($this, 'register_styles'));

		add_action( 'admin_menu', array( $this, 'dashboard' ) );
		add_action( 'admin_menu', array( $this->requirements, 'checkRequirements' ) );
		add_action( 'mgo_dashboard_hook', array( $this, 'settings' ) );
//		add_action( 'mgo_dashboard_hook', array( $this, 'suppliersBrowser' ) );
		add_action( 'mgo_dashboard_hook', array( $this, 'aboutUs' ) );
		add_action( 'mgo_dashboard_hook', array( $this, 'contactForm' ) );

		//register API endpoints
		require_once MGO_PLUGIN_DIR . '/includes/class-mgosync-api.php';
	}
}
