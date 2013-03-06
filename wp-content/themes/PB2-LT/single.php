<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<?php $wp_query->is_single = true; ?>
<?php if (false) { ?>
<div id="nav"><?php previous_post_link('%link','&laquo; Prev'); ?> | <?php pb_random_post("Random"); ?> | <?php next_post_link('%link','Next &raquo;')?></div>
<?php } ?>
<div <?php post_class() ?> id="post-<?php the_ID(); ?>" style="margin-top:.5em;">
<?php if (false) { ?>
<script type="text/javascript" src="http://stampit.jp/js/stamp.js?color=orange&amp;media_id=1&amp;url=<?php the_permalink(); ?>" charset="UTF-8"></script>
<?php } ?>
<div id="entry">  
<h2 class="title"><?php the_title('', ''); ?></h2>
<?php the_content(''); ?>
<div class="clear"></div>
<div class="postdata">
by <a href="http://shot.dogmap.jp/about/" rel="author"><?php the_author('nickname'); ?></a>
 | <a href="<?php the_permalink(); ?>" title="permalink for this photo"><?php the_time('n.j.Y'); ?></a>
 | Category: <?php the_category(', '); ?>
<?php the_tags(' | Tags: ', ', ', ''); ?>
<?php // edit_post_link('Edit',' | ',''); ?>
</div>
<div class="sh_comment">
<?php // if (function_exists('hideshowComments')) { hideshowComments();} else {comments_template();} ?>
</div>
</div>
</div>
<div id="th_container">
<?php // pb_before_after_thumbnails(7); ?>
<?php //pb_thumbnails(6); ?>
<div class="clear"></div>
</div>
<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
</div>
<?php get_footer(); ?>