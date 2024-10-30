<?php

namespace Megamo;

use Megamo\AbstractController;
use Megamo\Megamo_Service;
use Megamo\MgoSync_Service;
use Megamo\Requirements;
use Megamo\Suppliers;
use Megamo\WPValidator;
use function Megamo\wp_get_current_user;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

require_once 'abstract-class-controller.php';
require_once MGO_PLUGIN_DIR . '/includes/validators/class-wp-validator.php';
require_once MGO_PLUGIN_DIR . '/includes/services/class-megamo-service.php';
require_once MGO_PLUGIN_DIR . '/includes/services/class-mgosync-service.php';

//----------------------------------------------------------------
class SettingsController extends AbstractController {
	private static $default_view = MGO_PLUGIN_DIR . '/includes/views/settings-view.php';
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

		require_once MGO_PLUGIN_DIR . '/includes/models/class-requirements.php';

		$this->requirements = Requirements::getInstance();
	}

	public function getView(): void {
		$validator = WPValidator::getInstance();

		if ( file_exists( $this->view ) ) {
			$current_user = \wp_get_current_user();

			$view_reqs = $this->requirements->getRequirementsStatus();

			$mgoSyncService = new MgoSync_Service();
			$mgoSyncAccessData = $mgoSyncService->get_mgoSync_access_data();
			$grantAccessToWooUrl = $mgoSyncService->prepare_grant_access_to_woo_link();

			$wooApiAccess = [
				'granted'   => ( is_array($mgoSyncAccessData) && $mgoSyncAccessData['ck'] && $mgoSyncAccessData['cs'] ),
				'grantedBy' => is_array($mgoSyncAccessData) ? "{$mgoSyncAccessData['userName']} [{$mgoSyncAccessData['datetime']}]" : "---",
			];


			$megamoService = new Megamo_Service();
			$megamoApiKey = $megamoService->get_megamo_apikey();
			$registerAtMegamoUrl = $megamoService->prepare_registration_link();

			$megamoAccess = [
				'granted' => ( strlen( $megamoApiKey ) > 0 ),
//				'grantedBy' => "{$mgoSyncAccessData['userName']} [{$mgoSyncAccessData['datetime']}]",
			];

			$settingsCTA = !$mgoSyncService->check_settings();
			$mgoContactUsUrl = admin_url('admin.php?page=mgo_contact_us&help_form=1');

			include( $this->view );
		} else {
			echo '<div class="wrap"><h1>Error: Missing file</h1><p>Path:' . $validator->escapeText( $this->view ) . '</p></div>';
		}
	}
}
