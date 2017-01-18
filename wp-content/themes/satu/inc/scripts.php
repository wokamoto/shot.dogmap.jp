<?php
/**
 * Enqueue scripts and styles.
 */

/**
 * Loads the theme styles & scripts.
 *
 * @since 1.0.0
 * @link  http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @link  http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 */
function satu_enqueue() {

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'satu-fonts', satu_fonts_url(), array(), null );

	// if is not a child theme and WP_DEBUG and/or SCRIPT_DEBUG turned on, load the unminified styles & script.
	if ( ! is_child_theme() && WP_DEBUG || SCRIPT_DEBUG ) {

		// Load main stylesheet
		wp_enqueue_style( 'satu-style', get_stylesheet_uri(), array( 'dashicons' ) );

		// Load custom js plugins.
		wp_enqueue_script( 'satu-plugins', trailingslashit( get_template_directory_uri() ) . 'assets/js/plugins.min.js', array( 'jquery' ), null, true );

		// Load custom js methods.
		wp_enqueue_script( 'satu-main', trailingslashit( get_template_directory_uri() ) . 'assets/js/main.js', array( 'jquery' ), null, true );

		// Load js function for responsive navigation.
		wp_enqueue_script( 'satu-mobile-nav', trailingslashit( get_template_directory_uri() ) . 'assets/js/navigation.js', array(), null, true );

	} else {

		// Load main stylesheet
		wp_enqueue_style( 'satu-style', trailingslashit( get_template_directory_uri() ) . 'style.min.css', array( 'dashicons' ) );

		// Load custom js plugins.
		wp_enqueue_script( 'satu-scripts', trailingslashit( get_template_directory_uri() ) . 'assets/js/satu.min.js', array( 'jquery' ), null, true );

		// Load js function for responsive navigation.
		wp_enqueue_script( 'satu-mobile-nav', trailingslashit( get_template_directory_uri() ) . 'assets/js/navigation.js', array(), null, true );

	}

	// If child theme is active, load the stylesheet.
	if ( is_child_theme() ) {
		wp_enqueue_style( 'satu-child-style', get_stylesheet_uri() );
	}

	// Load comment-reply script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Loads HTML5 Shiv
	wp_enqueue_script( 'standard-html5', trailingslashit( get_template_directory_uri() ) . 'assets/js/html5shiv.min.js', array( 'jquery' ), null, false );
	wp_script_add_data( 'standard-html5', 'conditional', 'lte IE 9' );

}
add_action( 'wp_enqueue_scripts', 'satu_enqueue' );

/**
 * Display the custom header.
 *
 * @since  1.0.0
 */
function satu_custom_header() {

	// Get the featured image
	$featured = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

	if ( is_singular() ) {
		$image = $featured[0];
	} else {
		$image = get_header_image();
	}

	// Display the custom header via inline CSS.
	if ( $image ) :
		$header_css = '
			.site-header {
				background-image: url("' . esc_url( $image ) . '");
			}
			.site-header::after {
				content: "";
				display: block;
				width: 100%;
				height: 100%;
				background-color: rgba(45, 62, 80, .65);
				position: absolute;
				top: 0;
				left: 0;
				z-index: 0;
			}';
	endif;

	if ( ! empty( $header_css ) ) :
		wp_add_inline_style( 'satu-style', $header_css );
	endif;

}
add_action( 'wp_enqueue_scripts', 'satu_custom_header' );
