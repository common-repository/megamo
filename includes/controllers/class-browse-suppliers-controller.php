<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

require_once 'abstract-class-controller.php';
require_once MGO_PLUGIN_DIR . '/includes/validators/class-wp-validator.php';

//----------------------------------------------------------------
class BrowseSuppliersController extends AbstractController {
	private static $default_view = MGO_PLUGIN_DIR . '/includes/views/browse-suppliers-view.php';
	private $view;

	private static $suppliers_source = '/data/suppliers.json';
	private $suppliers = array();

	public function __construct( $source = null, $view = null ) {
		if ( $view && file_exists( MGO_PLUGIN_DIR . $view ) ) {
			$this->view = MGO_PLUGIN_DIR . $view;
		} else {
			$this->view = self::$default_view;
		}

		require_once MGO_PLUGIN_DIR . '/includes/models/class-suppliers.php';

		if ( $source && file_exists( MGO_PLUGIN_DIR . $source ) ) {
			$this->suppliers = new Suppliers( MGO_PLUGIN_DIR . $source );
		} else {
			$this->suppliers = new Suppliers( self::$suppliers_source );
		}
	}

	public function getView(): void {
		$validator = WPValidator::getInstance();

		if ( file_exists( $this->view ) ) {
			$mgo_page    = isset( $_GET['mgopage'] ) ? $validator->sanitizeText( $_GET['mgopage'] ) : null;
			$mgo_size    = isset( $_GET['mgosize'] ) ? $validator->sanitizeText( $_GET['mgosize'] ) : null;
			$mgo_sort_by = isset( $_GET['mgofilter'] ) ? $validator->sanitizeText( $_GET['mgofilter'] ) : 'name';
			$mgo_asc     = ( isset( $_GET['mgoasc'] ) && $validator->sanitizeText( $_GET['mgoasc'] ) === 'false' ) ? false : true;

			$this->suppliers->loadSuppliersFromFile();
			$suppliers    = $this->suppliers->getSuppliersData( $mgo_sort_by, $mgo_asc );
			$current_user = wp_get_current_user();
			$form_sent    = ( $_SERVER['REQUEST_METHOD'] == 'POST' );

			if ( $form_sent ) {
				$keys    = [ 'e_mail', 'domain', 'query', 'supplier_name', 'supplier_website', 'file_url', 'consent' ];
				$request = array();

				foreach ( $keys as $key ) {
					if ( in_array( $key, [ 'domain', 'supplier_website', 'file_url' ] ) ) {
						$request[ $key ] = isset( $_POST[ $key ] ) ? $validator->sanitizeUrl( $_POST[ $key ] ) : null;
						continue;
					}
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

				wp_mail( 'integrations@megamo.pl', 'Wordpress MgoSync | New integration form', $output_string );
			}

			include( $this->view );
		} else {
			echo '<div class="wrap"><h1>Error: Missing file</h1><p>Path:' . $validator->escapeText( $this->view ) . '</p></div>';
		}
	}
}
