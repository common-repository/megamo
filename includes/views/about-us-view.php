<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}
?>

<div class='wrap mgo-wrap'>
	<?php include MGO_PLUGIN_DIR . '/includes/views/components/header.php' ?>

    <p class='mgo-title'>What is Megamo?</p>

    <section class='mgo-row'>
        <div class='mgo-card mgo-column'>
            <p class='mgo-card-title'>"A laundry machine and a vacuum cleaner in one"</p>
            <p class='mgo-fs-ns mgo-fw-h'>An automatic integrator is such a machine for your store like a laundry
                machine and a vacuum cleaner in one for your house</p>
            <p>An integrator does the hard but very important work every day - it takes care of the prices and stocks to
                be updated all the time. You can edit these parameters manually when the amount is small, but major
                savings will be seen with the product offer under 100 products.</p>
        </div>

        <div class='mgo-card mgo-column'>
            <p class='mgo-card-title'>What is the aim of this module?</p>
            <p class='mgo-fs-ns mgo-fw-h'>Integration with a wholesaler - you obtain a prepared solution</p>
            <p>The Integrator allows to update a shop with the products offered by a wholesaler as well as their regular
                updates. You do not require to be familiar with PHP, XML or CSV - you obtain a ready solution which is
                an installed integrator, its configuration is is in line with your requirements.</p>
        </div>

        <div class='mgo-card mgo-column'>
            <p class='mgo-card-title'>We help you save time</p>
            <p class='mgo-ta-j'>Adding about <b>1000 products</b> to your offer manually takes as many as <b>160
                    hours</b> - which equals 8 hours of work a day, 5 days a week, for a whole month.</p>
            <div class='mgo-segment mgo-secondary' style='flex:1;'>
                <p class='mgo-center mgo-ta-c' style='font-size:min(max(1.33rem,1vw),2rem);'>
                    Your time is priceless when you unwind, and when you work, it’s worth as much as you can earn.
                </p>
            </div>
        </div>

        <div>
            <img src='<?php echo MGO_PLUGIN_URL . '/assets/images/png/background-hex.png' ?>' alt='megamo background'
                 class='mgo-center'>
        </div>
    </section>

    <section class='mgo-card mgo-column'>
        <p class='mgo-card-title'>Cooperation with the finest companies</p>

        <p>Select the driving force for your online store and check out offered dropshipping wholesalers.</p>

        <div class='mgo-row mgo-narrow'>

            <div class='mgo-column'>
                <p class='mgo-fs-ls mgo-fw-h mgo-ta-c'>
                    1749
                </p>
                partenered shops
            </div>

            <div class='mgo-column'>
                <p class='mgo-fs-ls mgo-fw-h mgo-ta-c'>
                    273
                </p>
                suppliers integrated
            </div>

            <div class='mgo-column'>
                <p class='mgo-fs-ls mgo-fw-h mgo-ta-c'>
                    900k
                </p>
                products updated monthly
            </div>

            <div class='mgo-column'>
                <p class='mgo-fs-ls mgo-fw-h mgo-ta-c'>
                    10+ years
                </p>
                of experience
            </div>
        </div>
    </section>

    <section class='mgo-row mgo-wide'>
        <iframe class='mgo-embed-video' src='https://www.youtube.com/embed/ha6scTTl40g' title='Megamo integrator'
                frameborder='0' allow='accelerometer; autoplay; gyroscope;' allowfullscreen>
        </iframe>

        <div class='mgo-card'>
            <p class='mgo-card-title'>How does it work?</p>
            <img src='<?php echo MGO_PLUGIN_URL . '/assets/images/webp/how-it-works.webp' ?>' alt='megamo how it works'>
        </div>
    </section>

	<?php include MGO_PLUGIN_DIR . '/includes/views/components/footer.php' ?>
</div>