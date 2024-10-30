<?php

namespace Megamo;

use \Exception;

if (!defined('ABSPATH')) {
	exit('No direct script access allowed');
}

require_once MGO_PLUGIN_DIR . '/includes/services/class-mgosync-service.php';
require_once MGO_PLUGIN_DIR . '/includes/services/class-megamo-service.php';

class Mgosync_Api
{
	private $namespace = "mgo/sync/v1";
	private $mgosync_service;
	private $megamo_service;

	function __construct(?string $namespace = null)
	{

//		$this->log(__CLASS__ . __FUNCTION__);

		if (!is_null($namespace)) {
			$this->namespace = $namespace;
		}

		$this->mgosync_service = new MgoSync_Service();
		$this->megamo_service = new Megamo_Service();

		add_action('rest_api_init', [$this, 'init']);
	}

	public function log($data)
	{
		$file_path = __DIR__ . '../../log.txt';
		file_put_contents($file_path, $data . "\n", FILE_APPEND);
	}

	function init()
	{
		\register_rest_route($this->namespace, '/woo_callback', [
			[
				'methods' => 'POST',
				'callback' => [$this, 'woo_callback'],
				'args' => [],
			]
		]);

		\register_rest_route($this->namespace, '/update_mgo_api_key', [
			[
				'methods' => 'POST',
				'callback' => [$this, 'update_mgo_api_key'],
				'args' => [],
			]
		]);


		\register_rest_route($this->namespace, '/wooData', [
			'methods' => 'GET',
			'callback' => [$this, 'getCallbackData'],
		]);
	}

	public function update_mgo_api_key($request)
	{
		try {

			if (($token = $this->mgosync_service->get_mgosync_api_access_token()) === false) {
				throw new Exception("First register your shop on Meagmo Dropshipping", 400);
			}

			$requestToken = sanitize_text_field($request['token']);

			if (!$this->mgosync_service->verify_mgosync_api_access_token($requestToken)) {
				throw new Exception("The token is invalid", 401);
			}

			$mgoSyncApiKey = sanitize_text_field($request['api_key']);

			if (strlen($mgoSyncApiKey) === 0) {
				throw new Exception("The API key is invalid", 401);
			}

			$this->megamo_service->update_megamo_apikey($mgoSyncApiKey);

		} catch (Exception $e) {
			wp_send_json_error($e->getMessage(), $e->getCode());
		}

		return wp_send_json_success(['The API key has been saved correctly'], 200);
	}


	public function woo_callback( $request ) {

		try {

			$postData = $request->get_body();
			if ( ! is_array( $request->get_body() ) ) {
				$postData = json_decode( $postData );
			}

			$ck          = sanitize_text_field( $postData->consumer_key );
			$cs          = sanitize_text_field( $postData->consumer_secret );
			$permissions = sanitize_text_field( $postData->key_permissions );
			$userId      = sanitize_text_field( $postData->user_id );
			$userData    = get_userdata( $userId );
			$userName    = $userData->user_login;
			$datetime    = date( 'Y-m-d H:i:s' );

			if ( ! is_string( $ck ) || ! is_string( $cs ) || ! is_string( $permissions ) ) {
				throw new Exception("Incomplete list of parameters");
			}

			$shopDetails = [
				'url'         => get_option( 'siteurl' ),
				'currency'    => get_option( 'woocommerce_currency' ),
				'weightUnit'  => get_option( 'woocommerce_weight_unit' ),
				'userId'      => $userId,
				'userName'    => $userName,
				'permissions' => $permissions,
				'ck'          => $ck,
				'cs'          => $cs,
				'datetime'    => $datetime,
			];

//			$this->log( print_r( $shopDetails, 1 ) );
			$this->mgosync_service->update_mgoSync_access_data( $shopDetails );
			$this->megamo_service->update_shop_access();

			wp_send_json_success();

		} catch ( Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}
	}

	public function getCallbackData() {
		$dataToInstaller = ( $this->mgosync_service->get_mgoSync_access_data() );
		wp_send_json_success( $dataToInstaller);
	}
}

new Mgosync_Api( MGO_SYNC_API_NAMESPCE );
