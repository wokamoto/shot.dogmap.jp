<?php
/*
Template Name: Links
*/
?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div id="page_entry">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Column 4') ) : ?>
<h2 class="page_title" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
<ul><?php wp_list_bookmarks(); ?></ul>
<?php endif; ?>		
<?php the_content(); ?>
<?php edit_post_link('Edit', '<p>', '</p>'); ?>
<?php endwhile; endif; ?>
</div>	
</div>
<?php get_footer(); ?>