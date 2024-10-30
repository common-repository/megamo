<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}
?>

<div class='wrap mgo-wrap'>

	<?php include MGO_PLUGIN_DIR . '/includes/views/components/header.php' ?>

    <p class='mgo-title'>MgoSync - Settings</p>

	<?php if ( ! $view_reqs ) { ?>
        <section class='mgo-card mgo-column'>
            <p class='mgo-card-title'>Some MgoSync requirements have not been met!</p>
            <p>Please check the following table to see what changes need to be made:</p>
            <div style='overflow-x:auto;'>
				<?php
				require_once MGO_PLUGIN_DIR . '/includes/views/components/requirements.php';
				viewRequirements();
				?>
            </div>
        </section>
	<?php } ?>


    <section class="mgo-settings">
        <div class='mgo-card mgo-column'>
            <p class='mgo-card-title mgo-fs-nm'>Step 1: Connect to Megamo Dropshipping</p>
            <p class='mgo-card-title mgo-secondary mgo-fs-ns'>
                Log in or sign up for a free account to choose a supplier and products to your store.
            </p>

			<?php
			$out = [];

			if ( ! $view_reqs ) {
				$out[] = '<p><a class="mgo-button mgo-center" style="max-width: max-content;"  mgo-disabled>Connect to Megamo</a></p>';
				$out[] = '<p class="mgo-error mgo-ta-c">Not all requirements have been met, please correct the configuration first</p>';
			}else {
				if ( ! $megamoAccess['granted'] ) {
					$out[] = '<p><a class="mgo-button mgo-center" style="max-width: max-content;"  href="' . $registerAtMegamoUrl . '" target="_blank" >Connect to Megamo</a></p>';
				} else {
					$out[] = '<p class="mgo-success ">Connection already established. Thank you!</p>';
					$out[] = '<p class=""><a class="mgo-button mgo-center" style="max-width: max-content;"  href="' . $registerAtMegamoUrl . '" >Reconnect</a></p>';
				}
			}

			echo implode( "\n", $out );
			?>

        </div>


        <div class='mgo-card mgo-column'>
            <p class='mgo-card-title mgo-fs-nm'>Step 2: Grant access to your WooCommerce Store</p>
            <p class='mgo-card-title mgo-secondary mgo-fs-ns'>
                Grant access so that the Integrator can automatically add products to your store.
            </p>
			<?php
			$out = [];

			if ( ! $view_reqs ) {
				$out[] = '<p><a class="mgo-button mgo-center" style="max-width: max-content;"  mgo-disabled>Grant Access</a></p>';
				$out[] = '<p class="mgo-error mgo-ta-c">Not all requirements have been met, please correct the configuration first</p>';
			}else {
				if ( ! $wooApiAccess['granted'] ) {
					$out[] = '<p><a class="mgo-button mgo-center" style="max-width: max-content;"  href="' . $grantAccessToWooUrl . '" >Grant Access</a></p>';
				} else {
					$out[] = '<p class="mgo-success ">Access already granted (' . $wooApiAccess['grantedBy'] . '). Thank you!</p>';
					$out[] = '<p class=""><a class="mgo-button mgo-center" style="max-width: max-content;"  href="' . $grantAccessToWooUrl . '" >Renew</a></p>';
				}
			}

			echo implode( "\n", $out );
			?>

        </div>
    </section>

	<?php if ( ! $megamoAccess['granted'] ) { ?>

        <p class='mgo-title'>Any troubles?</p>
        <section class="mgo-settings">
            <div class='mgo-card mgo-column'>
                <p><a class="mgo-button " style="max-width: max-content;" href="<?php echo $mgoContactUsUrl; ?>">Contact
                        Us!</a></p>
            </div>
        </section>

	<?php } ?>

</div>
