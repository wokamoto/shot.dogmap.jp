<?php
// Return early if no widget found.
if ( ! is_active_sidebar( 'footer' ) ) {
	return;
}
?>

<div class="widget-area">
	<div class="container">

		<?php dynamic_sidebar( 'footer' ); ?>

	</div>
</div>
