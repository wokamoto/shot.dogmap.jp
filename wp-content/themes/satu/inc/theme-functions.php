<?php
/**
 * Theme additional functions file.
 * 
 * @since      1.0
 * @author     Satrya <satrya@satrya.me>
 * @copyright  Copyright (c) 2013 - 2014, Satrya
 * @link       http://satrya.me/wordpress-themes/satu/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Remove automatically post format image add image to content. */
add_action( 'wp_loaded', 'satu_remove_image_in_content', 2 );

/* Replace standard excerpt more. */
add_filter( 'excerpt_more', 'satu_auto_excerpt_more' );

/* Change excerpt text length. */
add_filter( 'excerpt_length', 'satu_excerpt_length' );

/* Add classes to the comments pagination. */
add_filter( 'previous_comments_link_attributes', 'satu_previous_comments_link_attributes' );
add_filter( 'next_comments_link_attributes', 'satu_next_comments_link_attributes' );

/* Removes default styles set by WordPress recent comments widget. */
add_action( 'widgets_init', 'satu_remove_recent_comments_style' );

/* Filter size of the gravatar on comments. */
add_filter( "{$prefix}_list_comments_args", 'satu_comments_args' );

/* Remove the "Theme Settings" submenu. */
add_action( 'admin_menu', 'satu_remove_theme_settings_submenu', 11 );

/* Default footer settings */
add_filter( "{$prefix}_default_theme_settings", 'satu_default_footer_settings' );

/**
 * Remove automatically add image to the post content
 * when choosing post format image.
 *
 * @since 1.8
 */
function satu_remove_image_in_content() {
	remove_filter( 'the_content', 'hybrid_image_content' );
}

/**
 * Replaces "[...]" with ...
 *
 * @since 1.0
 */
function satu_auto_excerpt_more( $more ) {
	return '&hellip;';
}

/**
 * Sets the post excerpt length to 40 words.
 *
 * @since 1.0
 */
function satu_excerpt_length( $length ) {
	return 40;
}

/**
 * Adds 'class="prev" to the previous comments link.
 *
 * @since 1.0
 */
function satu_previous_comments_link_attributes( $attributes ) {
	return $attributes . ' class="prev"';
}

/**
 * Adds 'class="next" to the next comments link.
 *
 * @since 1.0
 */
function satu_next_comments_link_attributes( $attributes ) {
	return $attributes . ' class="next"';
}

/**
 * Removes default styles set by WordPress recent comments widget.
 *
 * @since 1.0
 */
function satu_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}

/**
 * Filter size of the gravatar on comments.
 * 
 * @since 1.0
 */
function satu_comments_args( $args ) {
	$args['avatar_size'] = 60;
	return $args;
}

/**
 * Remove the "Theme Settings" submenu.
 *
 * @since 2.0
 */
function satu_remove_theme_settings_submenu() {
	remove_submenu_page( 'themes.php', 'theme-settings' );
}

/**
 * Default footer settings
 *
 * @since 2.0
 */
function satu_default_footer_settings( $settings ) {
    
    $settings['footer_insert'] = '<p class="credit">' . __( 'Copyright &copy; [the-year] [site-link]. Powered by [wp-link] and [theme-link]', 'satu' ) . '</p>';
    
    return $settings;
}
?>