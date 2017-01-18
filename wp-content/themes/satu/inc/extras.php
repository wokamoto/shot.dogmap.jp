<?php
/**
 * Custom functions that act independently of the theme templates
 * Eventually, some of the functionality here could be replaced by core features
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @since  1.0.0
 * @param  array $classes Classes for the body element.
 * @return array
 */
function satu_body_classes( $classes ) {

	// Adds a class of multi-author to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'multi-author';
	}

	// Adds a class if has custom header
	if ( get_header_image() ) {
		$classes[] = 'has-custom-header';
	}

	// Adds a class to check if post/page has featured image
	if ( is_singular() ) {
		if ( has_post_thumbnail( get_the_ID() ) ) {
			$classes[] = 'has-featured-image';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'satu_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @since  1.0.0
 * @param  array $classes Classes for the post element.
 * @return array
 */
function satu_post_classes( $classes ) {

	// Adds a class if a post hasn't a thumbnail.
	if ( ! has_post_thumbnail() ) {
		$classes[] = 'no-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'satu_post_classes' );

/**
 * Change the excerpt more string.
 *
 * @since  1.0.0
 * @param  string  $more
 * @return string
 */
function satu_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'satu_excerpt_more' );

/**
 * Control excerpt length.
 *
 * @since  1.0.0
 */
function satu_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'satu_excerpt_length', 999 );

/**
 * Extend archive title
 *
 * @since  1.0.0
 */
function satu_extend_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author();
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'satu_extend_archive_title' );

/**
 * Add entry class.
 *
 * @since  1.0.0
 * @return array
 */
function satu_entry_markup( $classes ) {
	$classes[] = 'entry';
	return $classes;
}
add_filter( 'post_class', 'satu_entry_markup' );

/**
 * Customize tag cloud widget
 *
 * @since  1.0.0
 */
function penamoo_customize_tag_cloud( $args ) {
	$args['largest']  = 12;
	$args['smallest'] = 12;
	$args['unit']     = 'px';
	$args['number']   = 20;
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'penamoo_customize_tag_cloud' );
