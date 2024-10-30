<?php

namespace Megamo;

require_once MGO_PLUGIN_DIR . '/includes/validators/class-wp-validator.php';

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

function viewRequirements() {

	$validator = WPValidator::getInstance();

	?>
    <table class='striped widefat mgo-br-s'>
        <thead>
        <tr>
            <th>Test type</th>
            <th>Status</th>
            <th>Result</th>
            <th>Suggestion</th>
        </tr>
        </thead>

        <tbody>
		<?php
		$requirements = Requirements::getInstance();
		foreach ( $requirements->getRequirementsList() as $requirement ) {
			$status = $requirement->getRequirementStatus();
			echo '<tr>';
			foreach ( $requirement->getRequirementData() as $cell ) {
				echo ( $status ? '<td class="mgo-success">' : '<td class="mgo-error">' ) . $validator->escapeText( $cell ) . '</td>';
			}
			echo '</tr>';
		}
		?>
        </tbody>
    </table>
	<?php
}
