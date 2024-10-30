<?php

namespace Megamo;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

require_once MGO_PLUGIN_DIR . '/includes/validators/class-wp-validator.php';

function viewSuppliers( $suppliers, $page = "", $page_size = "" ) {
	$validator = WPValidator::getInstance();

	if ( is_array( $suppliers ) && count( $suppliers ) > 0 ) {
		$supplier_offset = 0;

		$page_size = ( ctype_digit( $page_size ) && $page_size >= 10 && $page_size <= 50 )
			? $page_size
			: 20;

		$suppl_count = count( $suppliers );
		$page_count  = ceil( $suppl_count / $page_size );

		$page = ctype_digit( $page )
			? $page
			: 1;

		$current_site = admin_url( 'admin.php?page=' . $validator->sanitizeText( $_GET['page'] ) );

		// page control
		if ( $page <= 1 ) {
			$page            = 1;
			$supplier_offset = 0;
		} else if ( $page > $page_count ) {
			$page            = $page_count;
			$supplier_offset = ( $page - 1 ) * $page_size;
		} else {
			$supplier_offset = ( $page - 1 ) * $page_size;
		}

		if ( $page_size < $suppl_count ) {
			// nice controls if available
			$start = file_exists( MGO_PLUGIN_DIR . '/assets/images/svg/start.svg' )
				? file_get_contents( MGO_PLUGIN_DIR . '/assets/images/svg/start.svg' )
				: '<<';

			$previous = file_exists( MGO_PLUGIN_DIR . '/assets/images/svg/previous.svg' )
				? file_get_contents( MGO_PLUGIN_DIR . '/assets/images/svg/previous.svg' )
				: '<';

			$next = file_exists( MGO_PLUGIN_DIR . '/assets/images/svg/next.svg' )
				? file_get_contents( MGO_PLUGIN_DIR . '/assets/images/svg/next.svg' )
				: '>';

			$end = file_exists( MGO_PLUGIN_DIR . '/assets/images/svg/end.svg' )
				? file_get_contents( MGO_PLUGIN_DIR . '/assets/images/svg/end.svg' )
				: '>>';
			?>
            <div class='mgo-controls'>
                <a id='mgo-start' class='mgo-button'
                   href='<?php echo $validator->escapeUrl( $current_site . '&mgopage=' . 1 . '&mgosize=' . $page_size ) ?>' <?php echo $page > 2 ? '' : 'mgo-disabled' ?>>
					<?php echo $validator->escapeSvg( $start ) ?>
                </a>

                <a id='mgo-previous' class='mgo-button'
                   href='<?php echo $validator->escapeUrl( $current_site . '&mgopage=' . max( $page - 1, 1 ) . '&mgosize=' . $page_size ) ?>' <?php echo $page > 1 ? '' : 'mgo-disabled' ?>>
					<?php echo $validator->escapeSvg( $previous ) ?>
                </a>

                <div id='mgo-current' class='mgo-card mgo-secondary mgo-ta-c'>Current page: <span
                            style='display:inline-block'><?php echo $validator->escapeText( $page . ' / ' . $page_count ) ?></span>
                </div>

                <a id='mgo-next' class='mgo-button'
                   href='<?php echo $validator->escapeUrl( $current_site . '&mgopage=' . min( $page + 1, $page_count ) . '&mgosize=' . $page_size ) ?>' <?php echo $page < $page_count ? '' : 'mgo-disabled' ?>>
					<?php echo $validator->escapeSvg( $next ) ?>
                </a>

                <a id='mgo-end' class='mgo-button'
                   href='<?php echo $validator->escapeUrl( $current_site . '&mgopage=' . $page_count . '&mgosize=' . $page_size ) ?>' <?php echo $page < $page_count - 1 ? '' : 'mgo-disabled' ?>>
					<?php echo $validator->escapeSvg( $end ) ?>
                </a>
            </div>
			<?php
		}

		echo '<section class="mgo-suppliers">';

		foreach ( array_slice( $suppliers, $supplier_offset, $page_size ) as $supplier_data ) {
			?>
            <div class='mgo-supplier mgo-card mgo-column'>
                <div class='mgo-card-title'>
                    <a href='<?php echo $validator->escapeUrl( $supplier_data['catalog'] ) ?>' target='_blank'>
						<?php echo $validator->escapeText( $supplier_data['name'] ) ?>
                    </a>
                </div>

				<?php echo $supplier_data['category'] ? '<div class="mgo-segment">Category:<p class="mgo-ta-j mgo-fw-h mgo-fs-ns">' . $validator->escapeText( $supplier_data['category'] ) . '</p></div>' : '' ?>

                <div class='mgo-supplier-content'>

                    <div class='mgo-supplier-right mgo-column'>
                        <a class='mgo-mv-a' href='<?php echo $validator->escapeUrl( $supplier_data['catalog'] ) ?>'
                           target='_blank'>
                            <img src='<?php echo $validator->escapeUrl( $supplier_data['image'] ) ?>' loading='lazy'>
                        </a>

                    </div>

                    <div class='mgo-supplier-left mgo-segment mgo-secondary mgo-column'>
						<?php
						echo $supplier_data['description']
							? '<div><b>Description: </b><p class="mgo-ta-j">' . $validator->escapeText( $supplier_data['description'] ) . '</p></div>'
							: '';

						echo $supplier_data['website']
							? '<div><b>Website: </b><a href=' . $validator->escapeUrl( $supplier_data['website'] ) . ' target="_blank"><p class="mgo-ta-j">' . $validator->escapeUrl( $supplier_data['website'] ) . '</p></a></div>'
							: '';

						echo $supplier_data['products']
							? '<div><b>Products quantity:</b><p class="mgo-ta-j">' . $validator->escapeText( $supplier_data['products'] ) . '</p></div>'
							: '';
						?>
                    </div>
                </div>
            </div>
			<?php
		}

		echo '</section>';
	} else {
		?>
        <section class='mgo-suppliers'>
            <div class='mgo-segment'>
                <span class='mgo-segment-title mgo-ma-a'>No item has been found.</span>
            </div>
        </section>
		<?php
	}
}
