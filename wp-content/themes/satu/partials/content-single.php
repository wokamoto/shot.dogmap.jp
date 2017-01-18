<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

	<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php satu_posted_on(); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content" itemprop="articleBody">

		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'satu' ),
				'after'  => '</div>',
			) );
		?>

	</div>

	<footer class="entry-footer">

		<?php if ( 'post' == get_post_type() ) : ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( esc_html__( ', ', 'satu' ) );
				if ( $categories_list && satu_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( esc_html__( 'Categories: %s', 'satu' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', esc_html__( ', ', 'satu' ) );
				if ( $tags_list ) :
			?>
				<span class="tag-links">
					<?php printf( esc_html__( 'Tags: %s', 'satu' ), $tags_list ); ?>
				</span>
			<?php endif; ?>

		<?php endif; ?>

	</footer>

</article><!-- #post-## -->
