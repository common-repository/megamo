<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}
?>

<section id='mgo-contact-us-form' class='mgo-card mgo-column'>
    <div class='mgo-details mgo-column'>
        <form id='mgo-contact' action='' method='post'>
            <div class='mgo-column'>
                <div class='mgo-row'>
                    <div class='mgo-input-group'>
                        <label for='email'>E-mail:</label>
                        <input type='text' id='email' name='e_mail'
                               value='<?php echo $validator->escapeText( $current_user->user_email ) ?>' readonly>
                    </div>

                    <div class='mgo-input-group'>
                        <label for='domain'>Domain:</label>
                        <input type='text' id='domain' name='domain'
                               value='<?php echo $validator->escapeUrl( get_site_url() ) ?>' readonly>
                    </div>

                </div>

                <div class='mgo-column'>
                    <label for='query'><span class='mgo-error'>* </span>Message content:</label>
    <textarea type='textarea' id='query' name='query' style='padding: 0.5em;' rows='12' required>
    Hello,
    I would like to get more information regarding...

    Regards,
    <?php echo $validator->escapeText( $current_user->display_name ) ?>
    </textarea>
                </div>

                <div class='mgo-row'>
                    <div></div>
                    <div>
                        <input type='checkbox' id='consent' name='consent' required>
                        <label for='consent'>
                            <span class='mgo-error'>* </span>I consent to the processing of the provided data and being
                            contacted by e-mail in order to fulfill my inquiry.
                        </label>
                    </div>
                </div>
            </div>
        </form>

    <input type='submit' class='mgo-button' value='Send the request' form='mgo-contact' style="max-width: max-content;" >
    </div>
</section>