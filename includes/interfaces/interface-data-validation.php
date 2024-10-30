<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

interface DataValidationInterface {
	public function sanitizeEmail( string $email ): string;

	public function sanitizeUrl( string $url ): string;

	public function sanitizeText( string $text ): string;

	public function escapeUrl( string $url ): string;

	public function escapeText( string $content ): string;
}