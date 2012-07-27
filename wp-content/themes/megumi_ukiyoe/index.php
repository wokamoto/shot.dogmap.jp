<?php get_header(); ?>
<div id="contents_box">
	<div id="main_content">
		<div id="header">
			<h1><?php bloginfo('description'); ?></h1>
			<p id="logo"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></p>
		</div>
		<?php if (have_posts()) : ?>
		<div id="photo_list">
		<?php while (have_posts()) : the_post(); ?>
<?php
				$post_thumbnail = ( function_exists('get_the_post_thumbnail') ? get_the_post_thumbnail() : '' );
				$post_thumbnail = ( !empty($post_thumbnail) ? $post_thumbnail : get_img('thumbnail') );
?>
			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<?php echo $post_thumbnail; ?>
				<p class="data"><?php _e('Data:&nbsp;','megumi'); ?><?php megumi_ukiyoe_data_format(); ?></p>
				<h3 class="post_title"><?php _e('Title:&nbsp;','megumi'); ?><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'megumi'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h3>
			</div>
		<?php endwhile; ?>
		</div>
		<?php wp_pagenav(); ?>
		<?php endif; ?>
		<?php get_sidebar(); ?>
		<div id="footer">
			<address><?php megumi_ukiyoe_copyright(); ?></address>
		</div>
	</div>
</div>
<?php get_footer(); ?>