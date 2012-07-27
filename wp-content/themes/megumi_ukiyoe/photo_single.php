<?php get_header(); ?>
	<p id="logo"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></p>
	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
		<h2 class="post_title"><?php the_title(); ?></h2>
		<div class="entry"><span><?php echo remove_img_content(); ?></span></div>
		<p class="data"><?php megumi_ukiyoe_data_format(); ?></p>
		<p class="cat"><?php printf(__('%s', 'megumi'), get_the_category_list(', ')); ?></p>
	</div>
	<?php endwhile; else: ?>
	<p>
		<?php _e('Sorry, no posts matched your criteria.', 'megumi'); ?>
	</p>
	<?php endif; ?>
	<address><?php megumi_ukiyoe_copyright(); ?></address>
<?php get_footer(); ?>
