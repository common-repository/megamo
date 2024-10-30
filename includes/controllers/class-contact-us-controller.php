<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

require_once 'abstract-class-controller.php';
require_once MGO_PLUGIN_DIR . '/includes/validators/class-wp-validator.php';

//----------------------------------------------------------------
class ContactUsController extends AbstractController {
	private static $default_view = MGO_PLUGIN_DIR . '/includes/views/contact-us-view.php';
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
			$form_sent    = ( $_SERVER['REQUEST_METHOD'] == 'POST' );
			$current_user = wp_get_current_user();

			$show_new_supplier_form = $_GET[ 'new_supplier_form' ] ?? false;
			$show_help_form = $_GET[ 'help_form' ] ?? false;

			if( !$show_new_supplier_form && !$show_help_form ){
				$show_new_supplier_form = true;
				$show_help_form = true;
			}

			if ( $form_sent ) {

				$keys    = [ 'e_mail', 'domain', 'query', 'consent' ];
				$request = array();

				foreach ( $keys as $key ) {
					if ( in_array( $key, [ 'e_mail' ] ) ) {
						$request[ $key ] = isset( $_POST[ $key ] ) ? $validator->sanitizeEmail( $_POST[ $key ] ) : null;
						continue;
					}

					$request[ $key ] = isset( $_POST[ $key ] ) ? $validator->sanitizeText( $_POST[ $key ] ) : null;
				}

				$output_string = '';
				foreach ( $request as $a => $b ) {
					$output_string .= $validator->escapeText( $a ) . ': <br>' . $validator->escapeText( $b ) . '<br><br>';
				}

				wp_mail( 'integrations@megamo.pl', 'Wordpress MgoSync | New contact form', $output_string );
			}

			include( $this->view );
		} else {
			echo '<div class="wrap"><h1>Error: Missing file</h1><p>Path:' . $validator->escapeText( $this->view ) . '</p></div>';
		}
	}
}
