<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EduVibe
 */
$blog_layout                = apply_filters( 'eduvibe_archive_sidebar_layout', eduvibe_get_config( 'blog_archive_layout', 'right-sidebar' ) );
$author_redirect_to_courses = apply_filters( 'eduvibe_ld_author_redirect_to_course', true );
if ( isset( $_GET['ldauthor'] ) ) :
	$ldauthor = $_GET['ldauthor'];
else :
	$ldauthor = false;
endif;
		
get_header();

echo '<div id="primary" class="eduvibe-' . get_post_type() . '-archive-wrapper content-area ' . esc_attr( apply_filters( 'eduvibe_content_area_class', 'eduvibe-col-lg-8' ) ) . '">';
	echo '<main id="main" class="site-main">';

		if ( 'sfwd-courses' === get_post_type() ) :
			get_template_part( 'template-parts/archive/content', 'sfwd-courses' );
		else :
			get_template_part( 'template-parts/content', 'blog' );
		endif;

	echo '</main>';
echo '</div>';

if ( 'no-sidebar' !== $blog_layout ) :
	if ( ( true != $author_redirect_to_courses ) || ( true == $author_redirect_to_courses && 'true' != $ldauthor ) ) :
		get_sidebar();
	endif;
endif;
get_footer();