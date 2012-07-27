<?php
/*
Template Name: Tags
*/
?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div id="page_entry">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Column 3') ) : ?>
<div id="tag_cloud">
<h2 class="page_title" id="post-<?php the_ID(); ?>">Tags</h2>
<?php wp_tag_cloud('smallest=9&largest=20&unit=px'); ?>
</div>
<?php endif; ?>
<?php the_content(); ?>
<?php edit_post_link('Edit', '<p>', '</p>'); ?>
<?php endwhile; endif; ?>
</div>
</div>
<?php get_footer(); ?> 