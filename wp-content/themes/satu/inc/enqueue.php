<?php
/**
 * Enqueue scripts and styles for theme usage.
 *
 * @since      2.0
 * @author     Satrya <satrya@satrya.me>
 * @copyright  Copyright (c) 2013 - 2014, Satrya
 * @link       http://satrya.me/wordpress-themes/satu/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Enqueue styles & scripts. */
add_action( 'wp_enqueue_scripts', 'satu_enqueue_scripts' );

/* Loads HTML5 Shiv. */
add_action( 'wp_head', 'satu_html5_script', 1 );

/**
 * Enqueue styles & scripts
 *
 * @since 1.0
 */
function satu_enqueue_scripts() {

	/* Load dashicons. */
	wp_enqueue_style( 'dashicons' );

	/* Load custom google fonts. */
	wp_enqueue_style( 'satu-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700|Roboto+Condensed:400,700|Volkhov', null, null, 'all' );

	wp_enqueue_script( 'satu-plugins', trailingslashit( THEME_URI ) . 'js/plugins.js', array( 'jquery' ), null, true );
	
	wp_enqueue_script( 'satu-methods', trailingslashit( THEME_URI ) . 'js/methods.js', array( 'jquery' ), null, true );

}

/**
 * Loads HTML5 Shiv.
 * 
 * @since 1.7
 */
function satu_html5_script() {
?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/respond.js"></script>
<![endif]-->
<?php
}
?>