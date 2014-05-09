var $ = jQuery.noConflict();
$(document).ready(function(){

	/**
	 * Shows a live preview of changing the site title and site description.
	 */
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '#site-title a' ).html( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '#site-description' ).html( to );
		} );
	} );

	/**
	 * Show/hide avatar
	 */
	wp.customize( 'satu_show_avatar', function( value ) {
		value.bind( function( to ) {
			$( '.site-branding .avatar' ).toggle( to );
		} );
	} );

	/**
	 * Custom header text
	 */
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				jQuery( '#site-title, #site-description' ).css( 'display', 'none' );
				jQuery( 'body' ).removeClass( 'display-header-text' );
			} else {
				jQuery( 'body' ).addClass( 'display-header-text' );
				jQuery( '#site-title, #site-description' ).css( 'display', 'block' );
				jQuery( '#site-title a' ).css( 'color', to );
			}
		} );
	} );

});