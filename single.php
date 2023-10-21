<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package EduVibe
 */

get_header();
$single_layout = apply_filters( 'eduvibe_single_sidebar_layout', eduvibe_get_config( 'blog_single_layout', 'right-sidebar' ) );
echo '<div id="primary" class="content-area ' . esc_attr( apply_filters( 'eduvibe_content_area_class', 'eduvibe-col-lg-8' ) ) . '">';
	echo '<main id="main" class="site-main">';
		if ( 'sfwd-courses' === get_post_type() ) :
			get_template_part( 'template-parts/single/content', 'sfwd-courses' );
		elseif ( 'simple_team' === get_post_type() ) :
			get_template_part( 'template-parts/single/content', 'simple_team' );
		else :
			get_template_part( 'template-parts/single', 'post' );
		endif;
	echo '</main>';
echo '</div>';
if ( 'no-sidebar' !== $single_layout && 'simple_team' !== get_post_type() ) :
	get_sidebar();
endif;

get_footer();