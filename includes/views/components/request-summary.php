<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}
?>

<section id='mgo-request-summary' class='mgo-card mgo-column'>
    <p class='mgo-card-title'>Our team member will contact you soon!</p>

    <a href='<?php echo admin_url( 'admin.php?page=mgo_dashboard', 'https' ); ?>' class='mgo-button' style='max-width: max-content;'>
        Go to Dashboard</a>

	<?php include_once 'request-details.php' ?>
</section>