<?php
/**
 * Template for displaying content of single course.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */

get_header();

if ( ! isset( $block_data ) ) :
    $block_data = array();
endif;

if ( ! isset( $style ) ) :
    $style = eduvibe_get_config( 'lp_course_style', 1 );
endif;

$default_data = array(
	'style' => $style
);

$block_data = wp_parse_args( $block_data, $default_data );

$eduvibe_course_container = array();

if ( ! isset( $column ) ) :
    $column = apply_filters( 'eduvibe_course_archive_grid_column', array( 'eduvibe-col-lg-4 eduvibe-col-md-6 eduvibe-col-sm-12' ) );
endif;

$eduvibe_course_container = array_merge( $eduvibe_course_container, $column );

$args = array( 
    'post_type' => LP_COURSE_CPT,
    'order' => 'DESC',
    'paged' => get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1,
    'posts_per_page' => LP()->settings->get( 'learn_press_archive_course_limit' ) 
);

$args = apply_filters( 'eduvibe_lp_course_archive_args', $args );

$query = new WP_Query( $args );

eduvibe_lp_course_header_top_bar( $query );

if ( $query->have_posts() ) :
    echo '<div class="eduvibe-row eduvibe-course-archive">';
        while ( $query->have_posts() ) : $query->the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'eduvibe_lp_course_loop_classes', $eduvibe_course_container ) ); ?>>
                <?php
                    learn_press_get_template( 'custom/course-block/blocks.php', compact( 'block_data' ) );
                ?>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    echo '</div>';
	
	$GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;
    eduvibe_numeric_pagination();
else :
    _e( 'No Course Found.', 'eduvibe' );
endif;

get_footer();