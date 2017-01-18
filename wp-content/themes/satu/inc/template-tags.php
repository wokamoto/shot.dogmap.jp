<?php
/**
 * Custom template tags for this theme.
 * Eventually, some of the functionality here could be replaced by core features.
 */

if ( ! function_exists( 'satu_page_title' ) ) :
/**
 * Site title.
 *
 * @since 1.0.0
 */
function satu_page_title() {

	if ( is_singular() ) {
		echo '<h1 class="post-title page-title" itemprop="headline">' . esc_attr( get_the_title() ) . '</h1>';
	} elseif ( is_archive() ) {
		echo '<h1 class="archive-title page-title" itemprop="headline">' . get_the_archive_title() . '</h1>';
	} elseif ( is_search() ) {
		echo '<h1 class="page-title">' . sprintf( esc_html__( 'Search Results for: %s', 'satu' ), '<span class="result">' . get_search_query() . '</span>' ) . '</h1>';
	} elseif ( is_404() ) {
		echo '<h1 class="page-title">' . esc_html__( 'Oops! That page can&rsquo;t be found.', 'satu' ) . '</h1>';
	} else {
		echo '<h1 class="site-title"><a href="' . esc_url( get_home_url() ) . '" itemprop="url" rel="home"><span itemprop="headline">' . esc_attr( get_bloginfo( 'name' ) ) . '</span></a></h1>';
	}

}
endif;

if ( ! function_exists( 'satu_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function satu_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'satu' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'satu' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function satu_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'satu_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'satu_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so satu_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so satu_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in satu_categorized_blog.
 */
function satu_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'satu_categories' );
}
add_action( 'edit_category', 'satu_category_transient_flusher' );
add_action( 'save_post',     'satu_category_transient_flusher' );
