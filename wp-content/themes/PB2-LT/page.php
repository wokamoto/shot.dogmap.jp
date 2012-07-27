<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div id="page_entry">
<h2 class="page_title" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
<?php the_content(); ?>
<?php edit_post_link('Edit', '<p>', '</p>'); ?>
<?php endwhile; endif; ?>
</div>
</div>
<?php get_footer(); ?>