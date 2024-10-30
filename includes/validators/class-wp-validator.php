<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

require_once MGO_PLUGIN_DIR . '/includes/interfaces/interface-data-validation.php';

class WPValidator implements DataValidationInterface {
	static private $instance = null;

	// returning an instance if exists or creating it
	public static function getInstance(): WPValidator {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function sanitizeEmail( string $email, bool $check_domain = true ): string {
		return sanitize_email( $email );
	}

	public function sanitizeUrl( $url ): string {
		return sanitize_url( $url );
	}

	public function sanitizeText( string $content ): string {
		return sanitize_text_field( $content );
	}

	public function escapeUrl( string $url ): string {
		return esc_url( $url );
	}

	public function escapeText( string $content ): string {
		return esc_html( $content );
	}

	public function escapeAttr( string $attr ): string {
		return esc_attr( $attr );
	}

	public function escapeSvg( string $svg ): string {
		$svg_args = array(
			'svg'      => array(
				'xmlns' => true,

				'id'    => true,
				'class' => true,
				'style' => true,

				'x'                   => true,
				'y'                   => true,
				'width'               => true,
				'height'              => true,
				'viewbox'             => true,
				'preserveaspectratio' => true,

				'fill'         => true,
				'fill-opacity' => true,
				'fill-rule'    => true,

				'stroke'            => true,
				'stroke-width'      => true,
				'stroke-opacity'    => true,
				'stroke-linecap'    => true,
				'stroke-linejoin'   => true,
				'stroke-dasharray'  => true,
				'stroke-dashoffset' => true,
				'stroke-miterlimit' => true,
			),
			'line'     => array(
				'x1' => true,
				'y1' => true,
				'x2' => true,
				'y2' => true,

				'id'    => true,
				'class' => true,
				'style' => true,

				'fill'         => true,
				'fill-opacity' => true,
				'fill-rule'    => true,

				'stroke'            => true,
				'stroke-width'      => true,
				'stroke-opacity'    => true,
				'stroke-linecap'    => true,
				'stroke-linejoin'   => true,
				'stroke-dasharray'  => true,
				'stroke-dashoffset' => true,
				'stroke-miterlimit' => true,
			),
			'polyline' => array(
				'points' => true,

				'id'    => true,
				'class' => true,
				'style' => true,

				'fill'         => true,
				'fill-opacity' => true,
				'fill-rule'    => true,

				'stroke'            => true,
				'stroke-width'      => true,
				'stroke-opacity'    => true,
				'stroke-linecap'    => true,
				'stroke-linejoin'   => true,
				'stroke-dasharray'  => true,
				'stroke-dashoffset' => true,
				'stroke-miterlimit' => true,
			),
			'polygon'  => array(
				'points' => true,

				'id'    => true,
				'class' => true,
				'style' => true,

				'fill'         => true,
				'fill-opacity' => true,
				'fill-rule'    => true,

				'stroke'            => true,
				'stroke-width'      => true,
				'stroke-opacity'    => true,
				'stroke-linecap'    => true,
				'stroke-linejoin'   => true,
				'stroke-dasharray'  => true,
				'stroke-dashoffset' => true,
				'stroke-miterlimit' => true,
			),
			'path'     => array(
				'd' => true,

				'id'    => true,
				'class' => true,
				'style' => true,

				'fill'         => true,
				'fill-opacity' => true,
				'fill-rule'    => true,

				'stroke'            => true,
				'stroke-width'      => true,
				'stroke-opacity'    => true,
				'stroke-linecap'    => true,
				'stroke-linejoin'   => true,
				'stroke-dasharray'  => true,
				'stroke-dashoffset' => true,
				'stroke-miterlimit' => true,
			),
			'rect'     => array(
				'x'      => true,
				'y'      => true,
				'rx'     => true,
				'ry'     => true,
				'width'  => true,
				'height' => true,

				'id'    => true,
				'class' => true,
				'style' => true,

				'fill'         => true,
				'fill-opacity' => true,
				'fill-rule'    => true,

				'stroke'            => true,
				'stroke-width'      => true,
				'stroke-opacity'    => true,
				'stroke-linecap'    => true,
				'stroke-linejoin'   => true,
				'stroke-dasharray'  => true,
				'stroke-dashoffset' => true,
				'stroke-miterlimit' => true,
			),
			'circle'   => array(
				'r'  => true,
				'cx' => true,
				'cy' => true,

				'id'    => true,
				'class' => true,
				'style' => true,

				'fill'         => true,
				'fill-opacity' => true,
				'fill-rule'    => true,

				'stroke'            => true,
				'stroke-width'      => true,
				'stroke-opacity'    => true,
				'stroke-linecap'    => true,
				'stroke-linejoin'   => true,
				'stroke-dasharray'  => true,
				'stroke-dashoffset' => true,
				'stroke-miterlimit' => true,
			),
			'ellipse'  => array(
				'rx' => true,
				'ry' => true,
				'cx' => true,
				'cy' => true,

				'id'    => true,
				'class' => true,
				'style' => true,

				'fill'         => true,
				'fill-opacity' => true,
				'fill-rule'    => true,

				'stroke'            => true,
				'stroke-width'      => true,
				'stroke-opacity'    => true,
				'stroke-linecap'    => true,
				'stroke-linejoin'   => true,
				'stroke-dasharray'  => true,
				'stroke-dashoffset' => true,
				'stroke-miterlimit' => true,
			),
			'title'    => array(
				'id'    => true,
				'class' => true,
				'style' => true,
			),
			'desc'     => array(
				'id'    => true,
				'class' => true,
				'style' => true,
			),
		);

		return wp_kses( $svg, $svg_args );
	}
}
