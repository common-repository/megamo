<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}
?>

	<?php
if ( isset( $settingsCTA ) && $settingsCTA ) {

	$mgoSettingsUrl = admin_url( 'admin.php?page=mgo_settings' );

	$out   = [];
	$out[] = "<div class='mgo-card mgo-row mgo-error-box' style='align-items: center;'>";
	$out[] = "<p class='mgo-fs-ns'><span class=''>WARNING!</span> Some settings are missing, the integrator may not work properly.</p>";
	$out[] = "<a class='mgo-button ' style='max-width: max-content;'  href='{$mgoSettingsUrl}' >Fix the settings</a>";

	$out[] = "</div>";

	echo implode( "\n", $out );
}
?>