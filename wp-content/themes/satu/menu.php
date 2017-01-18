<?php
// Check if there's a menu assigned to the 'primary' location.
if ( ! has_nav_menu( 'primary' ) ) {
	return;
}
?>

<nav id="site-navigation" class="main-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
	<div class="container">

		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'satu' ); ?></button>

		<?php wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => '',
				'menu_id'        => 'primary-menu',
			)
		); ?>

	</div>
</nav>
