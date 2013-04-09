<?php
/**
 * Trackback Comment Template
 *
 * The trackback comment template displays an individual trackback comment.
 *
 * @package satu
 * @author	Satrya
 * @license	license.txt
 * @since 	1.0
 */

	global $post, $comment;
?>

	<li id="comment-<?php comment_ID(); ?>" class="<?php hybrid_comment_class(); ?>">

		<?php 
			// Action hook for placing content before opening .comment-wrap
			do_action( 'satu_comment_before' ); 
		?>

		<div class="comment-wrap">

			<?php 
				// Action hook for placing content before the comment content
				do_action( 'satu_comment_open' ); 
			?>

			<?php echo apply_atomic_shortcode( 'comment_meta', '<div class="comment-meta">[comment-author] [comment-published before="- "] [comment-permalink before="- "] [comment-reply-link before="- "] [comment-edit-link before="- "]</div>' ); ?>

			<?php 
				// Action hook for placing content after the comment content
				do_action( 'satu_comment_close' ); 
			?>

		</div><!-- .comment-wrap -->

		<?php 
			// Action hook for placing content after closing .comment-wrap
			do_action( 'satu_comment_after' ); 
		?>

	<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>