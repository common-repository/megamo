<?php

namespace Megamo;

use \Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Megamo_Api_Rest_Client {

	private $namespace = "mgo/sync/v1";
	private $api_url;
	private $api_key;
	private $access_token = null;




	function __construct( string $url, string $api_key ) {

		$this->api_url = $url . "/api";
		$this->api_key = $api_key;
	}

	public function get_access_token() {

		if ( $this->access_token ) {
			return $this->access_token;
		}

		$args = [
			"body" => [
				"key" => $this->api_key,
			],
		];

		$req_url_elements = [
			"base_url" => $this->api_url,
			"endpoint" => "token",
		];

		$request_url = implode( "/", $req_url_elements );

		$response      = wp_remote_post( $request_url, $args );
		$response_body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( $response_body === false || ! isset( $response_body['access_token'] ) ) {
			throw new Exception ( "Invalid API response [Err=GAT001]" );
		}

		$this->access_token = $response_body['access_token'];

		return $this->access_token;
	}

	private function _get( string $endpoint, string $resourceId = "", array $args = [] ) {
		return $this->_request("GET", $this->prepareEndpoint($endpoint, $resourceId), $args);
	}

	private function _post( string $endpoint, array $args = [] ) {
		return $this->_request("POST", $endpoint, $args);
	}

	private function _put( string $endpoint, string $resourceId, array $args = [] ) {
		return $this->_request("PUT", $this->prepareEndpoint($endpoint, $resourceId), $args);
	}

	private function prepareEndpoint(string $endpoint, string $resourceId = ""){
		$endpointParts = [
			'name' => $endpoint,
			'resource_id' => $resourceId,
		];

		$endpointParts = array_filter($endpointParts);

		return implode("/", $endpointParts);
	}

	private function _request($method, $endpoint, array $args = [] ) {

		$method = strtoupper($method);

		if ( !in_array($method, ["GET", "POST", "PUT"]) ) {
			throw new Exception ( "Invalid HTTP method" );
		}

		$args = [
			'method'    => $method,
			'headers' => [
//				'Authorization' => 'Basic ' . base64_encode( YOUR_USERNAME . ':' . YOUR_PASSWORD )
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			],
			"body"    => $args,
		];

		$req_url_elements = [
			"base_url" => $this->api_url,
			"endpoint" => $endpoint,
		];

		$request_url   = implode( "/", $req_url_elements );
		$response      = (new \WP_Http())->request( $request_url, $args );
		$response_body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( $response_body === false ) {
			throw new Exception ( "Invalid API response  [Err=R001]" );
		}

		if ( ! $response_body['success'] ) {
			throw new Exception ( "API error: {$response_body['message']}" );
		}

		return $response_body['data'];
	}

	public function get_shops() {
		return $this->_get( "shop", "", [] );
	}

	public function add_shop($params) {
		return $this->_post( "shop", $params );
	}

	public function update_shop($id, $params) {
		return $this->_put( "shop", $id, $params );
	}
}
