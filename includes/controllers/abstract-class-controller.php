<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

abstract class AbstractController {
	abstract public function getView(): void;
}