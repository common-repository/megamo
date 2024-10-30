<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}
?>

<div class='wrap mgo-wrap'>
	<?php include MGO_PLUGIN_DIR . '/includes/views/components/header.php' ?>
    <p class='mgo-title'>MgoSync - Dropshipping & Suppliers</p>

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
            <p class='mgo-card-title mgo-fs-nm'>Manage your Suppliers and Products</p>
            <p class='mgo-card-title mgo-secondary mgo-fs-ns'>
                Log in or sign up for a free account to choose new products for your store.
            </p>
            <p></p>
			<?php
			$out = [];

			if ( ! $view_reqs ) {
				$out[] = '<p><a class="mgo-button mgo-center" style="max-width: max-content;"  mgo-disabled>Sign up for a free account</a></p>';
				$out[] = '<p class="mgo-error mgo-ta-c">Not all requirements have been met, please correct the configuration first</p>';
			}else {
				if ( ! $megamoAccess['granted'] ) {
					$out[] = '<p><a class="mgo-button mgo-center" style="max-width: max-content;"  href="' . $registerAtMegamoUrl . '" target="_blank" >Sign up for a free account</a></p>';
				} else {
					$out[] = '<p class=""><a class="mgo-button mgo-center" style="max-width: max-content;"  href="' . $registerAtMegamoUrl . '" >Go to Megamo</a></p>';
				}
			}

			echo implode( "\n", $out );
			?>

        </div>

        <div class='mgo-card mgo-column'>
            <p class="mgo-pa-sl mgo-fs-ns" style="border-left: 3px solid #fe5e08;">
                The MgoSync allows to update your shop with the products offered by a wholesalers selected from our list
                or provided by you.
            </p>

            <p class="mgo-pa-sl mgo-fs-ns" style="border-left: 3px solid #fe5e08;">
                At the beginning, you have the option of adding to your store products from one of our wholesalers:
                DROPEO.<br>
                Dropeo are products of european producers, manufactured in Europe, made with the utmost care.
            </p>

            <p class="mgo-pa-sl mgo-fs-ns" style="border: 0px; border-left: 3px solid #089de3;">
                If you are interested in the offer of our other sellers browse
                <a class="btn btn-outline-primary btn-sm" href="<?php echo $registerAtMegamoUrl; ?>" target="_blank">Supplier
                    List</a>
                or
                <a type="button" class="btn btn-outline-primary btn-sm"
                   href="<?php echo $mgoNewSupplierContactUsUrl; ?>">Contact Us</a> if you want to connect your own.
            </p>

        </div>

    </section>


    <p class='mgo-title'>Our featured suppliers</p>

	<?php
	require_once MGO_PLUGIN_DIR . '/includes/views/components/suppliers.php';
	viewSuppliers( $suppliers, $mgo_page );
	?>

    <p class='mgo-title'>Your own Supplier or Data Feed (eg. XML/CSV)?</p>

    <section class="mgo-settings">
        <div class='mgo-card mgo-column'>
            <p class='mgo-card-title mgo-fs-nm'>No problem!</p>
            <p class='mgo-card-title mgo-secondary mgo-fs-ns'>
                You can bring a new supplier – just provide us with an XML/CSV/JSON feed.
            </p>

			<?php
			$out = [];
			$out[] = '<p><a class="mgo-button mgo-center" style="max-width: max-content;"  href="' . $mgoNewSupplierContactUsUrl . '" >Contact us</a></p>';
			echo implode( "\n", $out );
			?>

        </div>

    </section>

    <p class='mgo-title'>Frequently Asked Questions</p>

    <section id='mgo-faq' class='mgo-card'>
        <p class='mgo-card-title mgo-fs-nm'>
            FAQ
        </p>
        <p class='mgo-card-title mgo-secondary mgo-fs-ns'>
            We’ve cooperated with thousands of stores and each of these cooperations gave rise to different questions.
            <br/>Below you can see answers to the most common inquiries.
        </p>

        <div class='mgo-text-columns mgo-wide mgo-pb-ns'>

            <div class='mgo-question'>
                <p class='mgo-fw-h mgo-mb-sm'>I would like to integrate my store with several wholesalers. Is it
                    possible with Megamo?</p>
                <p>Yes, you can integrate your store with more than one supplier.</p>
            </div>

            <div class='mgo-question'>
                <p class='mgo-fw-h mgo-mb-sm'>Can you integrate my store with a non-listed wholesaler?</p>
                <p>We start cooperation with new wholesalers every week - contact us and we'll take care of
                    everything.</p>
            </div>

            <div class='mgo-question'>
                <p class='mgo-fw-h mgo-mb-sm'>My store already has its product categories, can we use them?</p>
                <p>Yes, the integrator may add products to already existing categories.</p>
            </div>

            <div class='mgo-question'>
                <p class='mgo-fw-h mgo-mb-sm'>Can I set different product margins depending on the category?</p>
                <p>Yes, you can benefit from price rules and easily add/deduct a percentage or amount, or you can round
                    out the final price.</p>
            </div>

            <div class='mgo-question'>
                <p class='mgo-fw-h mgo-mb-sm'>Currently I’m using another integrator but it doesn’t meet my
                    expectations. Can I keep products already added to the store if I decide to choose your
                    services?</p>
                <p>It shouldn’t be problematic in 8 out of 10 cases, however, each situation is different - contact us
                    to check whether it's possible.</p>
            </div>

            <div class='mgo-question'>
                <p class='mgo-fw-h mgo-mb-sm'>Do I need to add all the wholesaler’s products?</p>
                <p>No, you don’t need to. It’s totally fine to select only specific categories or inpidual products.</p>
            </div>

            <div class='mgo-question'>
                <p class='mgo-fw-h mgo-mb-sm'>Keeping SEO in mind, I would like to name and describe products on my own.
                    Is it possible?</p>
                <p>Yes, you can freely modify names and descriptions, our integrator will save all the changes.</p>
            </div>

            <div class='mgo-question'>
                <p class='mgo-fw-h mgo-mb-sm'>Do I have to download and update files manually?</p>
                <p>The integrator regularly downloads files directly from the supplier, you don't have to remember about
                    updating them.</p>
            </div>

            <div class='mgo-question'>
                <p class='mgo-fw-h mgo-mb-sm'>Do I need to have the knowledge of XML / CSV?</p>
                <p>Definitely not, our specialists are real experts in the field.</p>
            </div>

            <div class='mgo-question mgo-secondary'>
                <p class='mgo-fw-h mgo-mb-sm'>I’m a wholesaler and I want to encourage online stores to sell my
                    products. Can you help me with that?</p>
                <p>Of course, we’ve been cooperating with wholesalers and online stores for many years and we do our
                    best to meet the expectations of both parties. Don’t hesitate to contact us!</p>
            </div>

        </div>
    </section>

	<?php include MGO_PLUGIN_DIR . '/includes/views/components/footer.php' ?>
</div>
