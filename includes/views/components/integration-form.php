<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}
?>

<section id='mgo-new-integration-form' class='mgo-card mgo-column'>
<!--    <p class='mgo-card-title'>Did not found what you were looking for?</p>-->

    <div class='mgo-details mgo-column'>
        <div class='mgo-segment mgo-secondary mgo-column'>
            <p class='mgo-segment-title'>No supplier? <span class='mgo-orange'>No problem!</span></p>

            <p class='mgo-fs-ns mgo-center mgo-ta-c '>Just provide us with an XML/CSV/JSON file or API documentation. We will
                analyse this file and if it is technically correct we can integrate it.</p>
        </div>


        <div class='mgo-form mgo-wide mgo-segment mgo-secondary mgo-column'>


            <p class='mgo-error'>Please fill out the form below.</p>

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
I would like to integrate a new supplier...

Regards,
<?php echo $validator->escapeText( $current_user->display_name ) ?>
</textarea>
                    </div>

                    <div class='mgo-row'>
                        <div class='mgo-input-group'>
                            <label for='suppl_name'>Supplier name:</label>
                            <input type='text' id='suppl_name' name='supplier_name' placeholder='Supplier XYZ'>
                        </div>

                        <div class='mgo-input-group'>
                            <label for='suppl_website'>Supplier website:</label>
                            <input type='text' id='suppl_website' name='supplier_website'
                                   placeholder='https://supplier-xyz.com/'>
                        </div>
                    </div>

                    <div class='mgo-row'>
                        <div class='mgo-input-group'>
                            <label for='file_url'>File (or API documentation) URL:</label>
                            <input type='text' id='file_url' name='file_url'
                                   placeholder='https://domain.com/.../file.xml'>
                        </div>
                    </div>

                    <div class='mgo-row'>
                        <div></div>
                        <div class='mgo-input-group'>
                            <input type='checkbox' id='consent' name='consent' required>
                            <label for='consent'>
                                <span class='mgo-error'>* </span>I consent to the processing of the provided data and
                                being contacted by e-mail in order to fulfill my inquiry.
                            </label>
                        </div>
                    </div>
                </div>
            </form>

            <input type='submit' class='mgo-button' value='Send the request' form='mgo-contact' style="max-width: max-content;" >
        </div>
    </div>
</section>