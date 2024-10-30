<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

require_once 'abstract-class-controller.php';
require_once MGO_PLUGIN_DIR . '/includes/validators/class-wp-validator.php';

//----------------------------------------------------------------
class AboutUsController extends AbstractController {
	private static $default_view = MGO_PLUGIN_DIR . '/includes/views/about-us-view.php';
	private $view;

	public function __construct( $view = null ) {
		if ( $view && file_exists( MGO_PLUGIN_DIR . $view ) ) {
			$this->view = MGO_PLUGIN_DIR . $view;
		} else {
			$this->view = self::$default_view;
		}
	}

	public function getView(): void {
		$validator = WPValidator::getInstance();

		if ( file_exists( $this->view ) ) {
			include( $this->view );
		} else {
			echo '<div class="wrap"><h1>Error: Missing file</h1><p>Path:' . $validator->escapeText( $this->view ) . '</p></div>';
		}
	}
}
