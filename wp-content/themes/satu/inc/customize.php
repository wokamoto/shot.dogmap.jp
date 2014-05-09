<?php
/**
 * Customizer function.
 *
 * @since      2.1
 * @author     Satrya <satrya@satrya.me>
 * @copyright  Copyright (c) 2013 - 2014, Satrya
 * @link       http://satrya.me/wordpress-themes/satu/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Customizer custom functions. */
add_action( 'customize_register', 'satu_customizer_functions', 20 );

/* Register custom sections, settings, and controls. */
add_action( 'customize_register', 'satu_customizer_register' );

/* Hook favicon setting into 'wp_head'. */
add_action( 'wp_head', 'satu_favicon_output', 5 );

/* Output settings CSS into the head. */
add_action( 'wp_head', 'satu_customize_css', 11 );

/**
 * Customizer custom functions.
 *
 * @since 2.1
 */
function satu_customizer_functions( $wp_customize ) {

	/* Enable live preview. */
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport     = 'postMessage';

	/* Javascript for live preview purpose. */
	add_action( 'customize_preview_init', 'satu_customizer_script' );

}

/**
 * Register custom sections, settings, and controls.
 *
 * @since 2.1
 */
function satu_customizer_register( $wp_customize ) {

	/* ========== AVATAR SECTION ========== */
	$wp_customize->add_setting( 'satu_show_avatar' , array(
		'default'    => true,
		'capability' => 'edit_theme_options',
		'transport'  => 'postMessage'
	) );

		$wp_customize->add_control( 'satu_show_avatar', array(
			'label'   => __( 'Show Avatar', 'satu' ),
			'type'    => 'checkbox',
			'section' => 'title_tagline',
		) );

	/* ========== FAVICON SECTION ========== */
	$wp_customize->add_section( 'satu_favicon_setting', array(
		'title'    => __( 'Favicon', 'satu' ),
		'priority' => 25,
	) );

		/* Custom favicon setting. */
		$wp_customize->add_setting( 'satu_favicon', array(
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options'
		) );

			/* Custom favicon control. */
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'satu_favicon', array(
				'label'    => esc_html__( 'Custom Favicon', 'satu' ),
				'section'  => 'satu_favicon_setting',
				'settings' => 'satu_favicon'
			) ) );

		/* Custom apple touch favicon setting. */
		$wp_customize->add_setting( 'satu_favicon_touch', array(
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options' 
		) );

			/* Custom apple touch favicon control. */
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'satu_favicon_touch', array(
				'label'    => esc_html__( 'Apple Touch Icon (144x144)', 'satu' ),
				'section'  => 'satu_favicon_setting',
				'settings' => 'satu_favicon_touch'
			) ) );

	/* ========== ACCENT COLOR SECTION ========== */
	$wp_customize->add_setting( 'satu_accent_color' , array(
		'default'    => '#2ecc71',
		'capability' => 'edit_theme_options'
	) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'satu_accent_color', array(
			'label'   => __( 'Accent Color', 'satu' ),
			'section' => 'colors'
		) ) );

	/* ========== BREADCRUMBS AND FOOTER COLOR SECTION ========== */
	$wp_customize->add_setting( 'satu_secondary_color' , array(
		'default'    => '#f5f5f5',
		'capability' => 'edit_theme_options'
	) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'satu_secondary_color', array(
			'label'   => __( 'Breadcrumbs and Footer Background Color', 'satu' ),
			'section' => 'colors'
		) ) );

}

/**
 * Loads theme customizer script.
 *
 * @since 2.1
 */
function satu_customizer_script() {
	wp_enqueue_script( 'satu-customize', trailingslashit( THEME_URI ) . 'js/customize.js', array( 'jquery' ), null, true );
}

/**
 * Favicon output.
 *
 * @since 2.1
 */
function satu_favicon_output() {

	if ( get_theme_mod( 'satu_favicon' ) )
		echo '<link href="' . esc_url( get_theme_mod( 'satu_favicon' ) ) . '" rel="icon">' . "\n";

	if ( get_theme_mod( 'satu_favicon_touch' ) )
		echo '<link href="' . esc_url( get_theme_mod( 'satu_favicon_touch' ) ) . '" rel="apple-touch-icon-precomposed" sizes="144x144">' . "\n";

}

/**
 * Output settings CSS into the head.
 *
 * @since 2.1
 */
function satu_customize_css() {
$accent = get_theme_mod( 'satu_accent_color', '#2ecc71' );
$sec    = get_theme_mod( 'satu_secondary_color', '#f5f5f5' ); ?>

<style type="text/css">
/* Custom Accent Color. */
.menu-primary-container,.entry-wrap a:hover,.pagination .page-numbers:hover,button, input[type="reset"], input[type="submit"], input[type="button"],button:hover, button:focus,input[type="reset"]:hover,input[type="reset"]:focus,input[type="submit"]:hover,input[type="submit"]:focus,input[type="button"]:hover,input[type="button"]:focus, .rslides_nav:hover { background-color: <?php echo $accent; ?>; }
a,a:link,a:visited { color: <?php echo $accent; ?>; }
.pagination .page-numbers:hover { border-color: <?php echo $accent; ?>; }
.menu-primary-items a,a.rslides_nav { color: #fff; }
.after-header,.sidebar-subsidiary { background: <?php echo $sec; ?>; }
.menu-primary-items a:hover {<?php if ( $accent == '#2ecc71' ) { echo 'border-top: 3px solid #27ae60;'; } else { echo 'border-top: 3px solid rgba(0,0,0,.2);'; } ?>}
</style>	

<?php }
?>