<?php get_header(); ?>
<div id="contents_box">
	<div id="main_content">
		<div id="header">
			<h1><?php bloginfo('description'); ?></h1>
			<p id="logo"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></p>
		</div>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2 class="page_title"><?php the_title(); ?></h2>
			<div class="entry">
				<?php the_content('<p class="serif">' . __('Read the rest of this page &raquo;', 'megumi') . '</p>'); ?>
				<?php wp_link_pages(array('before' => '<div class="link_pages_nav"><p><strong>' . __('Pages:', 'megumi') . '</strong> ', 'after' => '</p></div>', 'next_or_number' => 'number')); ?>
			</div>
		</div>
		<?php endwhile; endif; ?>
		<?php edit_post_link(__('Edit this entry.', 'megumi'), '<p>', '</p>'); ?>
		<?php get_sidebar(); ?>
		<div id="footer">
			<address><?php megumi_ukiyoe_copyright(); ?></address>
		</div>
	</div>
</div>
<?php get_footer(); ?>