<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}
?>

<div class='wrap mgo-wrap'>
	<?php include MGO_PLUGIN_DIR . '/includes/views/components/header.php' ?>

	<?php if ( $form_sent ) { ?>
        <p class='mgo-title'>Thank you! Your inquiry has been sent.</p>
		<?php include_once MGO_PLUGIN_DIR . '/includes/views/components/request-summary.php' ?>
		<?php
	} else {
		?>
        <p class='mgo-title'>Our supported suppliers</p>
		<?php include_once MGO_PLUGIN_DIR . '/includes/views/components/integration-form.php' ?>
	<?php } ?>

	<?php
	require_once MGO_PLUGIN_DIR . '/includes/views/components/suppliers.php';
	viewSuppliers( $suppliers, $mgo_page, $mgo_size );
	?>

	<?php include MGO_PLUGIN_DIR . '/includes/views/components/footer.php' ?>
</div>