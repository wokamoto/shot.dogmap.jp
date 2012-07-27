<?php get_header(); ?>
<?php
if (is_author()) {
	/* If this is an author archive */
	echo 'Author Archive';
	$author_id = intval( get_query_var('author') );
	$google_profile = get_the_author_meta( 'google_profile', $author_id );
	if ( $google_profile ) {
		echo ' ( <a href="' . $google_profile . '" rel="me">Google Profile</a> )';
	}
}
?>
<?php query_posts('showposts=1'); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<?php $wp_query->is_single = true; ?>
<?php if (false) { ?>
<div id="nav"><?php previous_post_link('%link','&laquo; Prev'); ?> | <?php pb_random_post("Random"); ?> |</div>
<?php } ?>
<div <?php post_class() ?> id="post-<?php the_ID(); ?>" style="margin-top:.5em;">
<div id="entry">  
<h2 class="title"><?php the_title('', ''); ?></h2>
<?php the_content('Read the rest of this entry &raquo;'); ?>
<div class="clear"></div>
<div class="postdata">by <a href="http://shot.dogmap.jp/about/" rel="author"><?php the_author('nickname'); ?></a> | <a href="<?php the_permalink(); ?>" title="permalink for this photo"><?php the_time('n.j.Y'); ?></a> | Category: <?php the_category(', '); ?><?php the_tags(' | Tags: ', ', ', ''); ?><?php edit_post_link('Edit',' | ',''); ?>
</div>
<div class="sh_comment">
</div>
</div>
</div>
<div id="th_container">
<?php pb_thumbnails(6); ?>
<div class="clear"></div>
</div>	
<?php endwhile;?>
<?php else: ?>
<h2 class="center">Not Found</h2>
<p><?php _e("Sorry, but you are looking for something that isn't here."); ?></p>
<?php endif; ?>
</div>
<?php get_footer(); ?> 