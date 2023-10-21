<?php

defined( 'ABSPATH' ) || exit();

if ( ! isset( $block_data ) ) :
    $block_data = array();
endif;

$thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'eduvibe-post-thumb' );
if ( isset( $thumb_src ) && ! empty( $thumb_src ) ) :
    $thumb_url = $thumb_src[0];
else :
    $thumb_url = LP()->image( 'no-image.png' );
endif;

if ( ! isset( $style ) ) :
    $style = eduvibe_get_config( 'lp_course_style', 1 );
endif;

if ( isset( $_GET['course_preset'] ) ) :
	$style = in_array( $_GET['course_preset'], array( 1, 2, 3, 4, 5, 6 ) ) ? $_GET['course_preset'] : 1;
endif;

$excerpt_length = eduvibe_get_config( 'lp_course_excerpt_length', 22 );
if ( isset( $_GET['excerpt_length'] ) ) :
	$excerpt_length = (int)$_GET['excerpt_length'] ? $_GET['excerpt_length'] : $excerpt_length;
endif;

$course      = \LP_Global::course();
$course_rate = $ratings = $percent = $featured = '';
$is_featured = get_post_meta( get_the_ID(), '_lp_featured', true );

if ( 'yes' === $is_featured ) :
	$featured = __( 'Featured', 'eduvibe' );
endif;

if ( class_exists( 'LP_Addon_Course_Review_Preload' ) ) :
	$course_rate    = learn_press_get_course_rate( get_the_ID() );
	$ratings        = learn_press_get_course_rate_total( get_the_ID() );
	$percent        = ( ! $course_rate ) ? 0 : min( 100, ( round( $course_rate * 2 ) / 2 ) * 20 );
endif;
$features       = get_post_meta( get_the_ID(), 'eduvibe_lp_course_top_features', true );
$duration       = get_post_meta( get_the_ID(), '_lp_duration', true );
$level          = get_post_meta( get_the_ID(), '_lp_level', true);
$duration_time  = absint( $duration );
$discount_price = $course->get_origin_price() != $course->get_price() ? true : false;

$default_data = [
	'thumb_url'      => $thumb_url,
	'style'          => $style,
	'course'         => $course,
	'enrolled'       => $course->get_users_enrolled(),
	'lessons'        => $course->get_curriculum_items( 'lp_lesson' ) ? count( $course->get_curriculum_items( 'lp_lesson' ) ) : 0,
	'level'          => $level ? $level : __( 'All Levels', 'eduvibe'),
	'cat_item'       => eduvibe_category_by_id( get_the_ID(), 'course_category' ),
	'duration'       => get_post_meta( get_the_ID(), '_lp_duration', true ),
	'enable_excerpt' => apply_filters( 'eduvibe_lp_enable_course_excerpt', true ),
	'excerpt_length' => $excerpt_length,
	'excerpt_end'    => apply_filters( 'eduvibe_lp_course_excerpt', '...' ),
	'button_text'    => eduvibe_get_config( 'lp_course_button_text' ) ? eduvibe_get_config( 'lp_course_button_text' ) : __( 'Enroll Now', 'eduvibe' ),
	'duration_time'  => $duration_time,
	'discount'       => $discount_price,
	'rate'           => $course_rate,
	'ratings'        => $ratings,
	'percent'        => $percent,
	'featured'		 => $featured
];

$block_data = wp_parse_args( $block_data, $default_data );
learn_press_get_template( 'custom/course-block/block-' . $block_data['style'] . '.php', compact( 'block_data', 'features' ) );