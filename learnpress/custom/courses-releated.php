<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
global $post;

$courses_to_show = apply_filters( 'eduvibe_lp_related_course_count', 4 );
$terms           = get_the_terms( $post->ID, 'course_category' );
$term_ids        = array();

if ( $terms ) :
    foreach( $terms as $term ) :
        $term_ids[] = $term->term_id;
    endforeach;
endif;

$args = array(
    'post_type'      => LP_COURSE_CPT,
    'posts_per_page' => $courses_to_show,
    'order'          => 'DESC',
    'post__not_in'   => array( $post->ID ),
    'tax_query'      => array(
        'relation'   => 'AND',
        array(
            'taxonomy' => 'course_category',
            'field'    => 'id',
            'terms'    => $term_ids,
            'operator' => 'IN'
        )
    )
);

$style = eduvibe_get_config( 'lp_related_course_style', 'default' );

if ( 'default' === $style ) :
    $style = eduvibe_get_config( 'lp_course_style', 1 );
endif;

$block_data = array(
    'style' => $style
);

$relates = new WP_Query( $args );
if ( $relates->have_posts() ) :
    echo '<div class="eduvibe-related-course-content-wrapper">';
        $pre_title = eduvibe_get_config( 'lp_related_course_pre_title', __( 'RELATED COURSES', 'eduvibe' ) );
        $heading = eduvibe_get_config( 'lp_related_course_title', __( 'Courses You May Like', 'eduvibe' ) );

        if ( $heading || $pre_title ) :
            echo '<div class="section-title">';
                if ( $pre_title ) :
                    echo '<span class="pre-title">' . esc_html( $pre_title ). '</span>';
                endif;
                if ( $heading ) :
                    echo '<h3 class="title">' . esc_html( $heading ). '</h3>';
                endif;
            echo '</div>';
        endif;
        
        echo '<div class="eduvibe-related-course-items slick-activation-wrapper" data-slidestoshow="3" data-tablet-items="2" data-mobile-items="1" data-small-mobile-items="1" data-autoplay="false" data-loop="true">';
            while ( $relates->have_posts() ) : $relates->the_post();
                learn_press_get_template( 'custom/course-block/blocks.php', compact( 'block_data' ) );
            endwhile;
            wp_reset_postdata();
        echo '</div>';
    echo '</div>';
endif;