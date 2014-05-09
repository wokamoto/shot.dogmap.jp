<?php
/**
 * Theme template
 * 
 * @since      1.5
 * @author     Satrya <satrya@satrya.me>
 * @copyright  Copyright (c) 2013 - 2014, Satrya
 * @link       http://satrya.me/wordpress-themes/satu/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Display breadcrumbs. */
add_action( 'satu_header_after', 'satu_content_after_header', 1 );

/* Loads subsidiary sidebar. */
add_action( 'satu_main_after', 'satu_loads_sidebar_subsidiary', 1 );

/* Loads primary menu. */
add_action( 'satu_header_open', 'satu_loads_menu_primary', 1 );

/* Add toggle button for mobile menu. */
add_action( 'satu_header_open', 'satu_toggle_button', 1 );

/**
 * Display breadcrumbs & search form after header.
 * 
 * @since 1.0
 */
function satu_content_after_header() { ?>
	
	<div class="after-header">
		<div class="container">

			<?php 
			if ( current_theme_supports( 'breadcrumb-trail' ) ) 
				breadcrumb_trail( 
					array( 
						'before' => __( 'You are here:', 'satu' ),
						'show_browse' => false
					) 
				); 
			?>

		</div><!-- .container -->
	</div><!-- .after-header -->

<?php 
}

/**
 * Loads sidebar subsidiary.
 * 
 * @since 1.5
 */
function satu_loads_sidebar_subsidiary() {
	get_sidebar( 'subsidiary' ); // Loads the sidebar-subsidiary.php template
}

/**
 * Loads primary menu.
 * 
 * @since 2.1
 */
function satu_loads_menu_primary() {
	get_template_part( 'menu', 'primary' );
}

/**
 * Add toggle button for mobile menu.
 * 
 * @since 2.1
 */
function satu_toggle_button() {
	echo '<label class="open-mobile-menu" for="mobile-menu" onclick><div class="dashicons dashicons-menu"></div></label>';
}
?>