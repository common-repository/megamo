<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

require_once 'class-requirement.php';

class Requirements {
	private static $allowed_roles = [ 'administrator' ];
	private static $instance = null;

	private $requirements = [];
	private $status = false;

	// returning and instance if exists or creating it
	public static function getInstance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function evaluateRequirements(): bool {
		foreach ( $this->requirements as $requirement ) {
			if ( $requirement->getRequirementStatus() === false ) {
				$this->status = false;

				return false;
			}
		}
		$this->status = true;

		return true;
	}

	// checking if basic WORDPRESS requirements are met
	public function checkRequirements() {
		$this->requirements['php_version'] = new Requirement(
			'WooCommerce version',
			function_exists( 'phpversion' ) && version_compare( phpversion(), '7.0', '>=' ),
			'PHP version is up to date.',
			'PHP version is out of date (' . phpversion() . '), version 2.6 or newer required.',
			'OK!',
			'Please contact your server administrator to update PHP.',
        );

		$this->requirements['wp_installed'] = new Requirement(
			'WordPress instalation',
			function_exists( 'wp' ),
			'WordPress was installed properly.',
			'WordPress was installed inproperly.',
			'OK!',
			'Please verify your Wordpress installation.',
        );

		if ( function_exists( 'wp' ) ) {
			$this->requirements['wp_version'] = new Requirement(
				'WordPress version',
				version_compare( get_bloginfo( 'version' ), '4.4', '>=' ),
				'WordPress version is up to date.',
				'WordPress version is out of date (' . get_bloginfo( 'version' ) . '), version 4.4 or newer required.',
				'OK!',
				'Please update your WordPress installation.',
            );
		}

		$this->requirements['wc_activation'] = new Requirement(
			'WooCommerce activation',
			function_exists( 'wc' ),
			'WooCommerce plugin is installed and activated.',
			'WooCommerce plugin is not installed or activated.',
			'OK!',
			'Please install and activate the WooCommerce plugin.',
        );

		$this->requirements['https_protocol'] = new Requirement(
			'Secure HTTPS connection',
			(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443,
			'The current protocol is HTTPS',
			'The current protocol is HTTP, and HTTPS is required',
			'OK!',
			'Load the page using the secure HTTPS protocol: '.admin_url( 'admin.php?page=mgo_dashboard', 'https' ),
        );

		if ( function_exists( 'wc' ) ) {
			$this->requirements['wc_version'] = new Requirement(
				'WooCommerce version',
				version_compare( wc()->version, '2.6', '>=' ),
				'WooCommerce plugin version is up to date.',
				'WooCommerce plugin version is out of date (' . wc()->version . '), version 2.6 or newer required.',
				'OK!',
				'Please update your WooCommerce plugin.',
            );
		}
		$current_user = wp_get_current_user();

		$this->requirements['user_email'] = new Requirement(
			'Current user e-mail',
			( $current_user->get( 'user_email' ) !== '' ),
			'Your user has an e-mail assigned.',
			'Your user does not have an e-mail assigned.',
			'OK!',
			'Please assign an e-mail to your user.',
        );

		$this->requirements['user_privilages'] = new Requirement(
			'Current user privilages',
			( boolval( array_intersect( $current_user->roles, self::$allowed_roles ) ) ),
			'Your user has proper privilages.',
			'Your user does not have proper privileges.',
			'OK!',
			'Please login into account with one of the following roles: ' . implode( ', ', self::$allowed_roles ),
        );

		$this->evaluateRequirements();
	}

	public function getRequirementsStatus() {
		return $this->status;
	}

	public function getRequirementsList() {
		return $this->requirements;
	}

	public function getRequirementsData() {
		$data = array();

		foreach ( $this->requirements as $requirement ) {
			$data[] = $requirement->getRequirementData();
		}

		return $data;
	}
}
