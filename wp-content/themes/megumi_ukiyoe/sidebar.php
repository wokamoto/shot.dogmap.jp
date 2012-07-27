<div id="side_content">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) { ?>
	<div class="widgets">
	<h2><?php _e('Pages', 'kubrick'); ?></h2>
	<ul id="page_nav">
		<li><a href="<?php echo get_option('home'); ?>/"><?php _e('HOME','megumi'); ?></a></li>
		<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
	</ul>
	</div>
	<div class="widgets">
	<h2><?php _e('Categorys', 'kubrick'); ?></h2>
	<ul id="cat_nav">
		<?php wp_list_categories('orderby=ID&hide_empty=0&title_li='); ?>
	</ul>
	</div>
	<div class="widgets">
	<h2><?php _e('Archives', 'kubrick'); ?></h2>
	<ul>
	<?php wp_get_archives('type=monthly'); ?>
	</ul>
	</div>
	<?php } ?>
</div>