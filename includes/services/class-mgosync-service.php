<?php

namespace Megamo;

use function Megamo\get_current_user_id;
use function Megamo\get_option;
use function Megamo\get_userdata;
use function Megamo\update_option;

class MgoSync_Service {

	public function get_mgosync_api_access_token( ?string $key = null, bool $forceRefresh = false ) {

		if ( $forceRefresh || ( $token = \get_option( 'mgosync_api_access_token' ) ) === false ) {

			$key = $key ?? \get_option( 'siteurl' );

			$token = md5( $key . time() );
			\update_option( 'mgosync_api_access_token', $token );
		}

		return $token;
	}

	public function verify_mgosync_api_access_token( string $key ) {

		return $key === $this->get_mgosync_api_access_token();
	}

	public function prepare_grant_access_to_woo_link() {

		$userId = \get_current_user_id();

		$grantAccessToWooBaseUrl  = \get_option( 'siteurl' ) . "/wc-auth/v1/authorize";
		$grantAccessToWooUrlParts = [
			"app_name"     => "mgoSync",
			"scope"        => "read_write",
			"user_id"      => $userId,
			"return_url"   => \get_option( 'siteurl' ) . "/wp-admin/admin.php?page=mgo_settings",
			"callback_url" => urlencode( \get_option( 'siteurl' ) . '/wp-json/' . MGO_SYNC_API_NAMESPCE . '/woo_callback' ),
		];

		return $grantAccessToWooBaseUrl . "?" . http_build_query( $grantAccessToWooUrlParts );
	}

	public function get_mgoSync_access_data(bool $raw = false) {

		$stored_value = \get_option( 'mgosync_wc_access_data' );

		if($raw){
			return $stored_value;
		}

		if ( is_string( $stored_value ) ) {
			$value = json_decode( base64_decode( $stored_value ), 1 );
		} else {
			$value = $stored_value;
		}

		return is_array( $value ) ? $value : [];
	}

	public function update_mgoSync_access_data( array $new_value ) {

		$new_value_json_64 = base64_encode( json_encode( $new_value ) );
		\update_option( 'mgosync_wc_access_data', $new_value_json_64 );
	}

	public function check_woo_connection() {

		$mgoSyncAccessData = $this->get_mgoSync_access_data();

		return is_array( $mgoSyncAccessData ) && $mgoSyncAccessData['ck'] && $mgoSyncAccessData['cs'];
	}

	public function check_mgo_connection() {

		$megamoService = new Megamo_Service();
		$megamoApiKey  = $megamoService->get_megamo_apikey();

		return ( strlen( $megamoApiKey ) > 0 );
	}

	public function check_settings() {

		return $this->check_woo_connection() && $this->check_mgo_connection();
	}
}
