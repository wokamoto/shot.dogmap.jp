<?php
/*
Template Name: Extra
*/
?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div id="page_entry">
<div class="left_column">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Column 5') ) : ?>
<?php endif; ?>
</div>
<div class="right_column">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Column 6') ) : ?>
<?php endif; ?>
</div>
<div class="clear"></div>
<?php endwhile; endif; ?>
</div>
</div>
<?php get_footer(); ?> 