<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

$eduvibe_event_location = get_post_meta( get_the_ID(), 'eduvibe_simple_event_location', true );
$eduvibe_event_date      = get_post_meta( get_the_ID(), 'eduvibe_simple_event_start_date', true );
$eduvibe_event_time      = get_post_meta( get_the_ID(), 'eduvibe_simple_event_start_time', true );
$eduvibe_event_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'eduvibe-post-thumb' );
if ( isset( $eduvibe_event_thumb_src ) && ! empty( $eduvibe_event_thumb_src ) ) :
    $eduvibe_event_thumb_url = $eduvibe_event_thumb_src[0];
else :
    $eduvibe_event_thumb_url = '';
endif;

echo '<div class="edu-event event-type-list event-list radius-small">';
	echo '<div class="inner">';
		if ( ! empty( $eduvibe_event_thumb_url ) ) :
			echo '<div class="thumbnail">';
				echo '<a href="' . esc_url( get_the_permalink() ) . '">';
					echo '<img src="' . esc_url( $eduvibe_event_thumb_url ) . '" alt="' . __( 'Event Image', 'eduvibe' ) . '">';
				echo '</a>';
			echo '</div>';
		endif;

		echo '<div class="content">';
            echo '<div class="content-left">';
                the_title( '<h5 class="title"><a href="' . esc_url( get_the_permalink() ) . '" class="post-link">', '</a></h5>' );

				if ( $eduvibe_event_date || $eduvibe_event_time || $eduvibe_event_location ) :
					echo '<ul class="event-meta">';
						if ( ! empty( $eduvibe_event_date ) ) :
							echo '<li><i class="icon-calendar-2-line"></i>' . esc_html( $eduvibe_event_date ). '</li>';
						endif;
						if ( ! empty( $eduvibe_event_time ) ) :
							echo '<li><i class="icon-time-line"></i>' . esc_html(  $eduvibe_event_time ) . '</li>';
						endif;
						if ( ! empty( $eduvibe_event_location ) ) :
							echo '<li><i class="icon-map-pin-line"></i>' . esc_html(  $eduvibe_event_location ) . '</li>';
						endif;
					echo '</ul>';
				endif;
			echo '</div>';

			if ( ! empty( $args['button_text'] ) ) :
				echo '<div class="read-more-btn">';
					echo '<a class="edu-btn btn-dark" href="' . esc_url( get_the_permalink() ) . '">' . esc_html( $args['button_text'] ) . '<i class="icon-arrow-right-line-right"></i></a>';
				echo '</div>';
			endif;
		echo '</div>';
	echo '</div>';
echo '</div>';