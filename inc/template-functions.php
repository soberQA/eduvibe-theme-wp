<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package EduVibe
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function eduvibe_body_classes( $classes ) {
	$preloader     = eduvibe_get_config( 'preloader', true );
	$sticky_header = eduvibe_get_config( 'sticky_header', true );
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) :
		$classes[] = 'group-blog';
	endif;

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) :
		$classes[] = 'hfeed';
	endif;

	if ( $preloader ) :
		$classes[] = 'eduvibe-site-preloader-loading';
	endif;

	if ( $preloader ) :
		$classes[] = 'eduvibe-site-preloader-loading';
	endif;

	if ( $sticky_header ) :
		$classes[] = 'eduvibe-sticky-header-enable';
	endif;

	return $classes;
}
add_filter( 'body_class', 'eduvibe_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function eduvibe_pingback_header() {
	if ( is_singular() && pings_open() ) :
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	endif;
}
add_action( 'wp_head', 'eduvibe_pingback_header' );
