<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Suppliers {
	private static $default_source = MGO_PLUGIN_DIR . '/data/suppliers.json';
	private $source;
	private $suppliers;

	public function __construct( $source = null ) {
		if ( $source && file_exists( MGO_PLUGIN_DIR . $source ) ) {
			$this->source = MGO_PLUGIN_DIR . $source;
		} else {
			$this->source = self::$default_source;
		}
	}

	public function loadSuppliersFromFile( $source = null ) {
		if ( ! $source || ! file_exists( MGO_PLUGIN_DIR . $source ) ) {
			$source = $this->source;
		}

		$file_data = json_decode( file_get_contents( $source ), true );

		require_once MGO_PLUGIN_DIR . '/includes/models/class-supplier.php';

		foreach ( $file_data as $supplier ) {
			$this->suppliers[ $supplier['name'] ] = new Supplier(
				$supplier['id'],
				$supplier['code'],
				$supplier['name'],
				array_key_exists( 'catalog', $supplier ) ? $supplier['catalog'] : null,
				array_key_exists( 'category', $supplier ) ? $supplier['category'] : null,
				array_key_exists( 'products', $supplier ) ? $supplier['products'] : null,
				array_key_exists( 'website', $supplier ) ? $supplier['website'] : null,
				array_key_exists( 'description', $supplier ) ? $supplier['description'] : null,
				array_key_exists( 'image', $supplier ) ? $supplier['image'] : null
			);
		}
	}

	public function getSuppliersNames() {
		if ( is_array( $this->suppliers ) ) {
			return array_keys( $this->suppliers );
		} else {
			return [];
		}
	}

	public function getSuppliersList() {
		if ( is_array( $this->suppliers ) ) {
			return ( $this->suppliers );
		} else {
			return [];
		}
	}

	public function getSuppliersData( string $filter = 'name', bool $asc = true ) {
		if ( ! is_array( $this->suppliers ) ) {
			return [];
		}

		// define cryterium
		if ( ! in_array( $filter, [ 'name', 'category', 'products' ] ) ) {
			$filter = 'name';
		}

		$filtering_list = [];

		// prepare data
		foreach ( $this->suppliers as $supplier ) {
			$filtering_list[] = $supplier->getSupplierData();
		}

		// sort ascending
		if ( $asc ) {
			usort( $filtering_list, function ( $item_a, $item_b ) use ( $filter ) {
				return ( array_key_exists( $filter, $item_a ) ? $item_a[ $filter ] : null ) <=> ( array_key_exists( $filter, $item_b ) ? $item_b[ $filter ] : null );
			} );

			// sort descending
		} else {
			usort( $filtering_list, function ( $item_a, $item_b ) use ( $filter ) {
				return ( array_key_exists( $filter, $item_b ) ? $item_b[ $filter ] : null ) <=> ( array_key_exists( $filter, $item_a ) ? $item_a[ $filter ] : null );
			} );
		}

		return $filtering_list;
	}
}
