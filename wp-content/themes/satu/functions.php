<?php
/**
 * Theme functions file
 *
 * Contains all of the Theme's setup functions, custom functions,
 * custom hooks and Theme settings.
 * 
 * @since      1.0
 * @author     Satrya <satrya@satrya.me>
 * @copyright  Copyright (c) 2013 - 2014, Satrya
 * @link       http://satrya.me/wordpress-themes/satu/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
 
/* Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

/* Load custom header file. */
require_once( trailingslashit( get_template_directory() ) . 'inc/custom-header.php' );

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'satu_theme_setup' );

/* Load additional libraries a little later. */
add_action( 'after_setup_theme', 'satu_load_libraries', 15 );

/**
 * Theme setup function. This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since 1.0
 */
function satu_theme_setup() {
	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-template-hierarchy' );
	add_theme_support( 'hybrid-core-scripts' );
	add_theme_support( 'hybrid-core-media-grabber' );
	add_theme_support( 
		'hybrid-core-menus', 
		array( 'primary' ) 
	);
	add_theme_support(
		'hybrid-core-sidebars',
		array( 'subsidiary' )
	);
	add_theme_support(
		'hybrid-core-styles',
		array( 'gallery', 'parent', 'style' )
	);
	add_theme_support(
		'hybrid-core-theme-settings',
		array( 'footer' )
	);

	/* Add theme support for framework extensions. */
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'cleaner-caption' );
	add_theme_support( 'post-stylesheets' );

	/* Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );

	/* Editor styles. */
	add_editor_style( 'editor-style.css' );

	/* Add support for custom backgrounds */
	add_theme_support( 
		'custom-background',
		array(
			'default-color' => 'faf9f8',
		)
	);

	/* Add post format support. */
	add_theme_support( 
		'post-formats',
		array( 'aside', 'audio', 'image', 'gallery', 'link', 'quote', 'video' ) 
	);

	/* Set content width. */
	hybrid_set_content_width( 630 );

	/* Add custom image sizes. */
	add_action( 'init', 'satu_add_image_sizes' );
	/* Add custom image sizes custom name. */
	add_filter( 'image_size_names_choose', 'satu_custom_name_image_sizes' );

	/** 
	 * Fix disqus issue.
	 *
	 * @since 1.7
	 */
	if( function_exists( 'dsq_comments_template' ) ) :
		remove_filter( 'comments_template', 'dsq_comments_template' );
		add_filter( 'comments_template', 'dsq_comments_template', 11 );
	endif;

}

/**
 * Loads some additional functions.
 *
 * @since 1.5
 */
function satu_load_libraries() {

	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Loads additional functions file. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/theme-functions.php' );

	/* Loads custom template tags. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/templates.php' );

	/* Loads enqueue scripts for theme usage. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/enqueue.php' );

	/* Loads customizer functions. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/customize.php' );

}

/**
 * Adds custom image sizes.
 *
 * @since 1.0
 */
function satu_add_image_sizes() {
	add_image_size( 'satu-small-thumb', 45, 45  , true );
	add_image_size( 'satu-featured'   , 690, 280, true );
	add_image_size( 'satu-attachment' , 690, 500, true );
}

/**
 * Adds custom image sizes custom name.
 *
 * @since 1.0
 */
function satu_custom_name_image_sizes( $sizes ) {
    $sizes['satu-small-thumb'] = __( 'Small Thumbnail', 'satu' );
    $sizes['satu-featured']    = __( 'Featured'       , 'satu' );
    $sizes['satu-attachment']  = __( 'Attachment'     , 'satu' );
 
    return $sizes;
}

/**
 * Site title.
 * 
 * @since 1.0
 */
function satu_site_title() {

	$avatar = get_theme_mod( 'satu_show_avatar', true );

	if ( get_header_image() ) {
		echo '<div class="site-logo">' . "\n";
			echo '<a href="' . esc_url( get_home_url() ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home">' . "\n";
				echo '<img class="logo" src="' . esc_url( get_header_image() ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
			echo '</a>' . "\n";
		echo '</div>' . "\n";
	} elseif ( $avatar ) {
		echo get_avatar( is_email( get_option( 'admin_email' ) ), 100, 'mystery', esc_attr( get_bloginfo( 'name' ) ) );
	}

	if ( display_header_text() ) {
		hybrid_site_title();
		hybrid_site_description();
	}

}

/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since     2.1
 * @copyright Twenty Thirteen
 */
function satu_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Get the [gallery] shortcode from the post content and display it on index page. It require
 * gallery ids [gallery ids=1,2,3,4] to display it as thumbnail slideshow. If no ids exist it
 * just display it as standard [gallery] markup.
 *
 * If no [gallery] shortcode found in the post content, get the attached images to the post and 
 * display it as slideshow.
 * 
 * @since  2.1
 * @access public
 * @uses   get_post_gallery() to get the gallery in the post content.
 * @uses   wp_get_attachment_image() to get the HTML image.
 * @uses   get_children() to get the attached images if no [gallery] found in the post content.
 * @return string
 */
function satu_get_format_gallery() {
	global $post;

	/* Don't display it on single post. */
	if ( is_singular() )
		return;

	/* Set up a default, empty $html variable. */
	$html = '';

	/* Check the [gallery] shortcode in post content. */
	$gallery = get_post_gallery( $post->ID, false );

	/* Check if the [gallery] exist. */
	if ( $gallery ) {

		/* Check if the gallery ids exist. */
		if ( isset( $gallery['ids'] ) ) {

			/* Get the gallery ids and convert it into array. */
			$ids = explode( ',', $gallery['ids'] );

			/* Display the gallery in a cool slideshow on index page. */
			$html = '<ul class="rslides">';
				foreach( $ids as $id ) {
					$html .= '<li>';
					$html .= wp_get_attachment_image( $id, 'satu-featured' );
					$html .= '</li>';
				}
			$html .= '</ul>';

		} else {

			/* If gallery ids not exist, display the standard gallery markup. */
			$html = get_post_gallery( $post->ID );

		}

	/* If no [gallery] in post content, get attached images to the post. */
	} else {

		/* Set up default arguments. */
		$defaults = array( 
			'order'          => 'ASC',
			'post_type'      => 'attachment',
			'post_parent'    => $post->ID,
			'post_mime_type' => 'image',
			'numberposts'    => -1
		);

		/* Retrieves attachments from the post. */
		$attachments = get_children( apply_filters( 'satu_gallery_format_args', $defaults ) );

		/* Check if attachments exist. */
		if ( $attachments ) {

			/* Display the attachment images in a cool slideshow on index page. */
			$html = '<ul class="rslides">';
				foreach ( $attachments as $attachment ) {
					$html .= '<li>';
					$html .= wp_get_attachment_image( $attachment->ID, 'satu-featured' );
					$html .= '</li>';
				}
			$html .= '</ul>';

		}

	}

	/* Return the gallery images. */
	return $html;

}
?>