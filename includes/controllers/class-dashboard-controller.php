<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

require_once 'abstract-class-controller.php';
require_once MGO_PLUGIN_DIR . '/includes/validators/class-wp-validator.php';
require_once MGO_PLUGIN_DIR . '/includes/services/class-megamo-service.php';
require_once MGO_PLUGIN_DIR . '/includes/services/class-mgosync-service.php';

//----------------------------------------------------------------
class DashboardController extends AbstractController {
	private static $default_view = MGO_PLUGIN_DIR . '/includes/views/dashboard-view.php';
	private $view;

	private static $suppliers_source = '/data/featured.json';
	private $suppliers = array();

	private $requirements;

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

		require_once MGO_PLUGIN_DIR . '/includes/models/class-requirements.php';

		$this->requirements = Requirements::getInstance();
	}

	public function getView(): void {
		$validator = WPValidator::getInstance();

		if ( file_exists( $this->view ) ) {
			$mgo_page    = isset( $_GET['mgopage'] ) ? $validator->sanitizeText( $_GET['mgopage'] ) : "";
			$mgo_size    = isset( $_GET['mgosize'] ) ? $validator->sanitizeText( $_GET['mgosize'] ) : "";
			$mgo_sort_by = isset( $_GET['mgofilter'] ) ? $validator->sanitizeText( $_GET['mgofilter'] ) : 'name';
			$mgo_asc     = ( isset( $_GET['mgoasc'] ) && $validator->sanitizeText( $_GET['mgoasc'] ) === 'false' ) ? false : true;

			$current_user = wp_get_current_user();

			$this->suppliers->loadSuppliersFromFile();
			$suppliers = $this->suppliers->getSuppliersData( $mgo_sort_by, $mgo_asc );
			$view_reqs = $this->requirements->getRequirementsStatus();

			$mgoSyncService = new MgoSync_Service();
			$settingsCTA = !$mgoSyncService->check_settings();

			$megamoService = new Megamo_Service();
			$megamoApiKey = $megamoService->get_megamo_apikey();
			$registerAtMegamoUrl = $megamoService->prepare_registration_link();
			$integrationPanelUrl = $megamoService->prepare_integration_panel_link();

			$megamoAccess = [
				'granted' => ( strlen( $megamoApiKey ) > 0 ),
//				'grantedBy' => "{$mgoSyncAccessData['userName']} [{$mgoSyncAccessData['datetime']}]",
			];

			$mgoNewSupplierContactUsUrl = admin_url('admin.php?page=mgo_contact_us&new_supplier_form=1');

			include( $this->view );
		} else {
			echo '<div class="wrap"><h1>Error: Missing file</h1><p>Path:' . $validator->escapeText( $this->view ) . '</p></div>';
		}
	}
}
