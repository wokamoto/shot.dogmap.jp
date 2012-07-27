<?php /* 
Template Name: Archives
*/ ?>  
<?php get_header(); ?>      
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<!-- page content begins -->
		<div id="page_entry">
<!-- Left Column -->			
			<div class="left_column">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Column 1') ) : ?>
				<h2 class="page_title">Monthly Archive</h2>
					<ul>
					<?php wp_get_archives('type=monthly&show_post_count=1'); ?> 
					</ul>
<?php endif; ?>		
			</div>
			
<!-- Right Column -->			
			<div class="right_column">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Column 2') ) : ?>
				<h2 class="page_title">Category Archive</h2>
					<ul>
					<?php wp_list_categories('show_count=1&title_li='); ?>
					</ul>
<?php endif; ?>					
			</div>
			<div class="clear"></div>
			
		<?php endwhile; endif; ?>

		</div>	<!-- div#page_entry close -->				
	</div> <!-- div#content close -->

<?php get_footer(); ?> 