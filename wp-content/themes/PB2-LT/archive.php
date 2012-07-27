<?php get_header(); ?>

<div id="arc_entry">
<?php if (have_posts()) : ?>
<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>				
<h2 class="page_title">Archive for the '<?php echo single_cat_title(); ?>' Category</h2>
<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
<h2 class="page_title">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
<h2 class="page_title">Archive for <?php the_time('F jS, Y'); ?></h2>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<h2 class="page_title">Archive for <?php the_time('m/Y'); ?></h2>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<h2 class="page_title">Archive for <?php the_time('Y'); ?></h2>
<?php /* If this is a search */ } elseif (is_search()) { ?>
<h2 class="page_title">Search Results</h2>
<?php /* If this is an author archive */ } elseif (is_author()) { ?>
<h2 class="page_title">Author Archive</h2>
<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
<h2 class="page_title">Blog Archives</h2>
<?php } ?>

</div>
<div id="arcth_container">
<?php while (have_posts()) : the_post(); ?>	
<?php the_date('','<h2>','</h2>'); ?>
<div class="thumbnails alignleft" >
<?php
kougabu_get_images(array(
	'before' => '' ,
	'after' => '' ,
	'post_id' => get_the_ID() ,
	'max_width' => 80 ,
	'max_height' => 80
));
?></div>
<p style="text-align:left;"><?php the_title(); echo strip_tags(get_the_content('')); ?><br /></p>
<div class="clear"></div>
<?php endwhile; ?>
</div>
<div class="navigation">
<div class="alignleft"><?php next_posts_link('&laquo; older') ?></div>
<div class="alignright"><?php previous_posts_link('newer &raquo;') ?></div>
<div class="clear"></div>
</div>

<?php else : ?>
<div class="center">Not Found</div>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
<?php endif; ?>
</div>
<?php get_footer(); ?>