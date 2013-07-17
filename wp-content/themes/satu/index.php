<?php
/**
 * Index Template
 * 
 * This is the default template. It is used when a more specific template can't be found to display
 * posts.
 *
 * @package satu
 * @author	Satrya
 * @license	license.txt
 * @since 	1.0
 */

// Loads the header.php template
get_header(); 
?>

 	<?php 
 		// Action hook for placing content before opening #primary
 		do_action( 'satu_content_before' ); 
 	?>
 		
	<div id="primary" class="site-content no-sidebar">
		
		<?php 
			// Action hook for placing content before opening #content
			do_action( 'satu_content_open' ); 
		?>
		
		<div id="content" class="content hfeed" role="main">
			
			<?php 
				// Loads the loop-meta.php template
				get_template_part( 'loop', 'meta' ); 
			?>
			
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php 
						// Loads the content-__.php (where ___ is the post format or post type name)
						get_template_part( 'content', ( post_type_supports( get_post_type(), 'post-formats' ) ? get_post_format() : get_post_type() ) );
					?>

					<?php if ( is_singular() ) { ?>

						<?php
							// Action hook for placing content after singular page
							do_action( 'satu_singular_after' ); 
						?>

						<?php
							// Loads the comments.php template
							comments_template( '/comments.php', true ); 
						?>

					<?php } ?>

				<?php endwhile; ?>

			<?php elseif ( current_user_can( 'edit_posts' ) ) : // check, if current user can edit posts ?>

				<?php 
					// Loads the no-results.php template
					get_template_part( 'no-results' ); 
				?>

			<?php endif; ?>
			
		</div><!-- #content .content .hfeed -->
		
		<?php 
			// Action hook for placing content after closing #content
			do_action( 'satu_content_close' ); 
		?>
		
		<?php 
			// Loads the loop-nav.php template
			get_template_part( 'loop', 'nav' ); 
		?>
		
	</div><!-- #primary .site-content .no-sidebar -->
 		
 	<?php 
 		// Action hook for placing content after closing #primary
 		do_action( 'satu_content_after' ); 
 	?>
 
<?php 
	// Loads the footer.php template
	get_footer(); 
?>