<?php
/**
 * Theme template tags
 * 
 * @package satu
 * @author	Satrya
 * @license	license.txt
 * @since 	1.5
 *
 */

/**
 * Display breadcrumbs & search form after header.
 * 
 * @since 1.0
 */
function satu_content_after_header() { ?>
	
	<div class="after-header">
		<div class="container">

			<?php if ( current_theme_supports( 'breadcrumb-trail' ) ) breadcrumb_trail( array( 'before' => __( 'You are here:', 'satu' ) ) ); ?>

		</div><!-- .container -->
	</div><!-- .after-header -->

<?php 
}
add_action( 'satu_header_after', 'satu_content_after_header', 1 );

/**
 * Author Box.
 * For Satu 1.6
 * 
 * @since 1.0
 */
function satu_author_box() {

	if ( get_the_author_meta( 'description' ) ) : ?>

		<aside class="post-author">
			<h4 class="title"><?php _e( 'About the author', 'satu' ); ?></h4>
			<div class="author-box">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'satu_author_bio_avatar_size', 80 ) ); ?>
				<div class="author-desc">
					<a class="author-name" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo esc_attr( get_the_author() ); ?></a> 
					<p><?php echo stripslashes( get_the_author_meta( 'description' ) ); ?></p>
				</div>
			</div>
		</aside>

<?php endif;
}
// add_action( 'satu_entry_after', 'satu_author_box', 1 );

/**
 * Loads sidebar subsidiary
 * 
 * @since 1.5
 */
function satu_loads_sidebar_subsidiary() {
	get_sidebar( 'subsidiary' ); // Loads the sidebar-subsidiary.php template
}
add_action( 'satu_main_after', 'satu_loads_sidebar_subsidiary', 1 );
?>