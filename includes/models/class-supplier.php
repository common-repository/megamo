<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Supplier {
	private static $image_path = '/assets/images/jpg/suppliers/';
	private static $default_image = 'default.jpg';
	private static $default_descrpiton = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
	private $id, $code, $name;
	private $catalog;
	private $products;
	private $description;
	private $image;
	private $website;
	private $category;

	public function __construct( $id, $code, $name, $catalog = null, $category = null, $products = null, $website = null, $description = null, $image = null ) {
		$this->id   = $id;
		$this->code = $code;
		$this->name = $name;

		$this->catalog = $catalog
			? $catalog
			: 'https://www.megamo.pl/en/' . $this->id . '-' . $this->code . '.html';

		$this->description = $description
			? $description
			: self::$default_descrpiton;
		$this->products    = $products
			? $products
			: 0;
		$this->website     = $website
			? $website
			: '';
		$this->category    = $category
			? $category
			: '';

		if ( $image ) {
			if ( str_starts_with( $image, 'https://' ) ) {
				$this->image = $image;
			} else {
				$this->image = file_exists( MGO_PLUGIN_DIR . self::$image_path . $image )
					? MGO_PLUGIN_URL . self::$image_path . $image
					: MGO_PLUGIN_URL . self::$image_path . self::$default_image;
			}
		} else {
			$this->image = MGO_PLUGIN_URL . self::$image_path . self::$default_image;
		}
	}

	public function getSupplierName() {
		return $this->name;
	}

	public function getSupplierData() {
		return array(
			'name'        => $this->name,
			'catalog'     => $this->catalog,
			'products'    => $this->products,
			'description' => $this->description,
			'image'       => $this->image,
			'website'     => $this->website,
			'category'    => $this->category,
		);
	}
}
