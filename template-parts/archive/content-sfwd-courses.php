<?php
/**
 * Template part for displaying sfwd-courses content in archive.php.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EduVibe
 * @since   1.0.0
 */
defined( 'ABSPATH' ) || exit();

if ( ! isset( $block_data ) ) :
    $block_data = array();
endif;

if ( ! isset( $style ) ) :
    $style = eduvibe_get_config( 'ld_course_style', 1 );
endif;

if ( isset( $_GET['course_preset'] ) ) :
    $style = in_array( $_GET['course_preset'], array( 1, 2, 3, 4, 5 ) ) ? $_GET['course_preset'] : 1;
endif;

$default_data = array(
    'style' => $style
);

$eduvibe_course_container = array();

if ( ! isset( $column ) ) :
    $column = apply_filters( 'eduvibe_course_archive_grid_column', array( 'eduvibe-col-lg-4 eduvibe-col-md-6 eduvibe-col-sm-12' ) );
endif;

$eduvibe_course_container = array_merge( $eduvibe_course_container, $column );

$args = wp_parse_args( $block_data, $default_data );
if ( have_posts() ) :
	echo '<div class="eduvibe-lms-courses-grid eduvibe-row">   ';
        while ( have_posts() ) : the_post(); 
            ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'eduvibe_course_loop_classes', $eduvibe_course_container ) ); ?>>
                <?php //get_template_part( 'learndash/custom/course-block/blocks', '', $args );
            echo '</div>';
        endwhile;
	echo '</div>';
else :
	get_template_part( 'template-parts/content', 'none' );
endif;
