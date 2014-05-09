<?php
/**
 * Primary menu template.
 * 
 * @since      2.1
 * @author     Satrya <satrya@satrya.me>
 * @copyright  Copyright (c) 2013 - 2014, Satrya
 * @link       http://satrya.me/wordpress-themes/satu/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

if ( has_nav_menu( 'primary' ) ) : ?>

	<input id="mobile-menu" type="checkbox">
	<nav class="menu-primary-container" role="navigation">

		<div class="container">

			<label class="close-mobile-menu" for="mobile-menu" onclick><div class="dashicons dashicons-dismiss"></div> <?php _e( 'Close Menu', 'satu' ); ?></label>

			<?php 
				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'container_class' => 'menu-primary-wrap',
						'menu_id'         => '',
						'menu_class'      => 'menu-primary-items',
						'fallback_cb'     => ''
					)
				);
			?>

		</div><!-- .container -->

	</nav><!-- .menu-primary-container -->

<?php endif; ?>