<?php
/**
 * Handles the setup and usage of the WordPress custom headers feature.
 *
 * @since      2.1
 * @author     Satrya <satrya@satrya.me>
 * @copyright  Copyright (c) 2013 - 2014, Satrya
 * @link       http://satrya.me/wordpress-themes/satu/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Call late so child themes can override. */
add_action( 'after_setup_theme', 'satu_custom_header_setup', 15 );

/**
 * Adds support for the WordPress 'custom-header' theme feature and registers custom headers.
 *
 * @since 2.1
 */
function satu_custom_header_setup() {

	add_theme_support(
		'custom-header',
		array(
			'width'                  => 200,
			'height'                 => 80,
			'flex-width'             => true,
			'flex-height'            => true,
			'default-text-color'     => '2ecc71',
			'header-text'            => true,
			'uploads'                => true,
			'wp-head-callback'       => 'satu_custom_header_wp_head',
			'admin-head-callback'    => 'satu_custom_header_admin_head',
			'admin-preview-callback' => 'satu_custom_header_admin_preview',
		)
	);

	/* Load the stylesheet for the custom header screen. */
	add_action( 'admin_print_styles-appearance_page_custom-header', 'satu_enqueue_admin_custom_header_styles' );

}

/**
 * Enqueues the styles for the "Appearance > Custom Header" screen in the admin.
 *
 * @since 2.1
 */
function satu_enqueue_admin_custom_header_styles() {

	wp_enqueue_style( 'satu-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700|Roboto+Condensed:400,700|Volkhov', null, null, 'all' );

}

/**
 * Callback function for outputting the custom header CSS to `wp_head`.
 *
 * @since 2.1
 */
function satu_custom_header_wp_head() {

	if ( !display_header_text() )
		return;

	$hex = get_header_textcolor();

	if ( empty( $hex ) )
		return;

	$style = "body.custom-header #site-title a { color: #{$hex}; }";

	echo "\n" . '<style type="text/css" id="custom-header-css">' . trim( $style ) . '</style>' . "\n";
}

/**
 * Callback for the admin preview output on the "Appearance > Custom Header" screen.
 *
 * @since 2.1
 */
function satu_custom_header_admin_preview() { ?>

	<div id="headimg">

		<?php
		$color = get_header_textcolor();
		if ( $color && $color != 'blank' )
			$style = ' style="color:#' . $color . '"';
		else
			$style = ' style="display:none"';
		?>

		<?php if ( get_header_image() ) { ?>
			<img src="<?php echo esc_url( get_header_image() ); ?>" alt="" />
		<?php } else { ?>
			<?php echo get_avatar( is_email( get_option( 'admin_email' ) ), 100, 'mystery', esc_attr( get_bloginfo( 'name' ) ) ); ?>
		<?php } ?>

		<?php if ( display_header_text() ) { ?>
			<h1 class="displaying-header-text">
				<a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			</h1>
			<div id="description" class="displaying-header-text"><?php bloginfo( 'description' ); ?></div>
		<?php } ?>

	</div>

<?php }

/**
 * Callback function for outputting the custom header CSS to `admin_head` on "Appearance > Custom Header".
 *
 * @since 2.1
 */
function satu_custom_header_admin_head() {
?>
	<style type="text/css" id="satu-admin-header-css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg {
		text-align: center;
		background: #faf9f8;
		padding: 40px 0;
	}
	#headimg h1 {
		font-family: 'Roboto Condensed', sans-serif;
		font-weight: 700;
		margin: 0;
	}
	#headimg h1 a {
		font-size: 32px;
		line-height: 36px;
		text-decoration: none;
	}
	#description {
		font-family: 'Roboto Condensed', sans-serif;
		font-size: 14px;
		line-height: 23px;
	}
	<?php if ( get_header_textcolor() != HEADER_TEXTCOLOR ) { ?>
		#site-title a {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php } ?>
	#headimg img {
		max-width: 200px;
		height: auto;
		width: 100%;
	}
	#headimg .avatar {
		-webkit-border-radius: 100px;
		-moz-border-radius: 100px;
		border-radius: 100px;
		max-width: 100px;
	}
	</style>
<?php
}
