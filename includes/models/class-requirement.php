<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Requirement {
	private static $default_true_message = 'Condition met.';
	private static $default_false_message = 'Condition not met.';
	private static $default_true_suggestion = '';
	private static $default_false_suggestion = '';

	private $true_message;
	private $false_message;
	private $true_suggestion;
	private $false_suggestion;
	private $status;
	private $name;

	public function __construct(
		string $name,
		bool $func,
		?string $true_message = null,
		?string $false_message = null,
		?string $true_suggestion = null,
		?string $false_suggestion = null
	) {

		$this->name   = $name;
		$this->status = $func;

		// feedback if passed
		$this->true_message    = isset( $true_message )
			? $true_message
			: self::$default_true_message;
		$this->true_suggestion = isset( $true_suggestion )
			? $true_suggestion
			: self::$default_true_suggestion;

		// feedback if failed
		$this->false_message    = isset( $false_message )
			? $false_message
			: self::$default_false_message;
		$this->false_suggestion = isset( $false_suggestion )
			? $false_suggestion
			: self::$default_false_suggestion;
	}

	public function getRequirementStatus(): bool {
		return $this->status;
	}

	public function getRequirementData(): array {
		if ( $this->status ) {
			return array(
				'name'       => $this->name,
				'status'     => 'passed',
				'message'    => $this->true_message,
				'suggestion' => $this->true_suggestion,
			);
		} else {
			return array(
				'name'       => $this->name,
				'status'     => 'failed',
				'message'    => $this->false_message,
				'suggestion' => $this->false_suggestion,
			);
		}
	}
}
