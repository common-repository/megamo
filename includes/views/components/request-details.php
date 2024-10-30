<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}
?>

<details class='mgo-details mgo-column'>

    <summary class='mgo-button' style='max-width: max-content;'>Details of your request</summary>

    <div class='mgo-segment mgo-secondary mgo-column'>
		<?php
		foreach ( $request as $key => $value ) {
			if ( $value ) {
				echo '<p>' . $validator->escapeText( $key ) . '</p>';
				echo '<div class="mgo-segment">' . $validator->escapeText( $value ) . '</div>';
			}
		}
		?>
    </div>

</details>