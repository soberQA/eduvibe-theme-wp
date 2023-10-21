<?php
defined( 'ABSPATH' ) || exit();

/**
 * The template for displaying event archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EduVibe
 */

get_header();

if ( ! isset( $block_data ) ) :
    $block_data = array();
endif;

if ( ! isset( $style ) ) :
    $style = eduvibe_get_config( 'simple_event_style', 1 );
endif;

if ( isset( $_GET['event_preset'] ) ) :
	$style = in_array( $_GET['event_preset'], array( 1, 'list' ) ) ? $_GET['event_preset'] : 1;
endif;

$active_white_bg = eduvibe_get_config( 'simple_event_active_white_bg', false );
$wrapper = array( 'eduvibe-event-wrapper eduvibe-row' );
$column = apply_filters( 'eduvibe_event_archive_grid_column', array( 'eduvibe-col-lg-4 eduvibe-col-md-6 eduvibe-col-sm-12' ) );

if ( isset( $_GET['bg_white_active'] ) || $active_white_bg ) :
	$wrapper = array_merge( $wrapper, array( 'active-white-bg' ) );
endif;

if ( $style == 'list' ) :
	$column = array( 'eduvibe-col-lg-12' );
endif;

if ( isset( $_GET['column'] ) ) :
	if ( $_GET['column'] == 2 ) :
		$column = array( 'eduvibe-col-lg-6 eduvibe-col-md-6 eduvibe-col-sm-12' );
	endif;
endif;

if ( isset( $_GET['event_preset'] ) && $_GET['event_preset'] == 'list' ) :
	$column = array( 'eduvibe-col-lg-12' );
endif;

if ( isset( $_GET['event_thumb'] ) ) :
	$thumb_size = $_GET['event_thumb'];
else :
	$thumb_size = 'eduvibe-post-thumb';
endif;

$thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $thumb_size );
if ( isset( $thumb_src ) && ! empty( $thumb_src ) ) :
    $thumb_url = $thumb_src[0];
else :
    $thumb_url = get_template_directory_uri() . '/assets/images/no-image-found.png';
endif;

if ( ! isset( $button_text ) ) :
	if ( isset( $_GET['button_text'] ) ) :
		$button_text = $_GET['button_text'];
	else :
		$button_text = eduvibe_get_config( 'simple_event_button_text', __( 'Book A Seat', 'eduvibe' ) );
	endif;
endif;

$default_data = array(
	'style'          => $style,
	'thumb_url'      => $thumb_url,
	'day'            => get_post_meta( get_the_ID(), 'eduvibe_simple_event_day', true ),
	'time'           => get_post_meta( get_the_ID(), 'eduvibe_simple_event_time', true ),
	'location'       => get_post_meta( get_the_ID(), 'eduvibe_simple_event_location', true ),
	'button_text'    => $button_text
);

$args = wp_parse_args( $block_data, $default_data );

if ( have_posts() ) :
	echo '<div class="' . esc_attr( implode( ' ',$wrapper ) ).'">';
		while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'eduvibe_event_loop_classes', $column ) ); ?>>
				<?php get_template_part( 'template-parts/events/custom/event-' . $args['style'], '', $args ); ?>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
	echo '</div>';
	eduvibe_numeric_pagination();
else :
	get_template_part( 'template-parts/content', 'none' );
endif;
get_footer();