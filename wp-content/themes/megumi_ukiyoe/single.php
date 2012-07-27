<?php get_header(); ?>
<div id="contents_box">
	<div id="main_content">
		<div id="header">
			<h1><?php bloginfo('description'); ?></h1>
			<p id="logo"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></p>
		</div>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2 class="post_title"><?php the_title(); ?></h2>
			<p class="data"><?php megumi_ukiyoe_data_format(); ?>&nbsp;<?php printf(__('%s', 'megumi'), get_the_category_list(', ')); ?>&nbsp;by&nbsp;<?php the_author(); ?></p>
			<div class="entry">
				<?php the_content('<p class="serif">' . __('Read the rest of this page &raquo;', 'megumi') . '</p>'); ?>
				<?php wp_link_pages(array('before' => '<div class="link_pages_nav"><p><strong>' . __('Pages:', 'megumi') . '</strong> ', 'after' => '</p></div>', 'next_or_number' => 'number')); ?>
			</div>
		<hr />
		<div class="meta">
			<span class="tags"><?php _e('Tags:','megumi'); ?>&nbsp;<?php the_tags(__(' ', 'megumi'), ', ', ''); ?></span>
			<?php edit_post_link(__('Edit', 'megumi'), '<span class="edit">', '</span>'); ?>
		</div>
		</div>
	<div class="navigation">
		<p class="previous_post"><?php previous_post_link('%link','&laquo;&nbsp;%title',TRUE) ?></p>
		<p class="next_post"><?php next_post_link('%link','%title&nbsp;&raquo;',TRUE) ?></p>
		<hr />
	</div>
	<?php comments_template(); ?>
		<?php endwhile; endif; ?>
		<?php edit_post_link(__('Edit this entry.', 'megumi'), '<p>', '</p>'); ?>
		<?php get_sidebar(); ?>
		<div id="footer">
			<address><?php megumi_ukiyoe_copyright(); ?></address>
		</div>
	</div>
</div>
<?php get_footer(); ?>