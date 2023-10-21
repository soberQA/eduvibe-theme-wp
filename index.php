<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EduVibe
 */

get_header();

if ( ! isset( $eduvibe_blog_post_style ) ) :
    $eduvibe_blog_post_style = eduvibe_get_config( 'blog_post_style', 'standard' );
endif;

if ( isset( $_GET['post_preset'] ) ) :
	$eduvibe_blog_post_style = in_array( $_GET['post_preset'], array( 1, 2, 3, 'standard' ) ) ? $_GET['post_preset'] : $eduvibe_blog_post_style;
endif;

$blog_layout = eduvibe_get_config( 'blog_archive_layout', 'right-sidebar' );

echo '<div id="primary" class="content-area ' . esc_attr( apply_filters( 'eduvibe_content_area_class', 'eduvibe-col-lg-8' ) ) . '">';
	echo '<main id="main" class="site-main">';

		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;
			echo '<div class="eduvibe-row eduvibe-blog-post-archive-style-' . esc_attr( $eduvibe_blog_post_style ) . '">';
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();
					/*
					* Include the Post-Type-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Type name) and that will be used instead.
					*/
					get_template_part( 'template-parts/posts/post', $eduvibe_blog_post_style );
				endwhile;
				wp_reset_postdata();
			echo '</div>';

			if ( function_exists( 'eduvibe_numeric_pagination' ) ) :
				eduvibe_numeric_pagination();
			else :
				the_posts_navigation();
			endif;

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;

	echo '</main>';
echo '</div>';

if ( 'no-sidebar' !== $blog_layout ) :
	get_sidebar();
endif;
get_footer();