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
		<?php if ( $show_new_supplier_form ) { ?>

            <p class='mgo-title'>MgoSync - Your own Supplier or Data Feed (eg. XML/CSV)?</p>
			<?php include_once MGO_PLUGIN_DIR . '/includes/views/components/integration-form.php' ?>

		<?php } ?>

		<?php if ( $show_help_form ) { ?>

            <p class='mgo-title'>Do you have questions or doubts? We are there to help!</p>
			<?php include_once MGO_PLUGIN_DIR . '/includes/views/components/contact-form.php' ?>

		<?php } ?>
	<?php } ?>

	<?php include MGO_PLUGIN_DIR . '/includes/views/components/footer.php' ?>
</div>