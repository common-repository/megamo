<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

$top = file_exists( MGO_PLUGIN_DIR . '/assets/images/svg/top.svg' )
	? file_get_contents( MGO_PLUGIN_DIR . '/assets/images/svg/top.svg' )
	: 'UP';
?>

<?php
require_once MGO_PLUGIN_DIR . '/includes/views/components/settings-missing-cta.php';
?>

<section id='mgo-header' class='mgo-column'>


    <div id='mgo-header-logo'><?php echo MGO_LOGO_SVG ?></div>

    <a id='mgo-back-to-top' class='mgo-button' onclick='mgoBackToTop()'
       mgo-hidden><?php echo $validator->escapeSvg( $top ) ?></a>
</section>