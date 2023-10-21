<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

$eduvibe_event_location = get_post_meta( get_the_ID(), 'eduvibe_simple_event_location', true );
$eduvibe_event_date      = get_post_meta( get_the_ID(), 'eduvibe_simple_event_start_date', true );
$eduvibe_event_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'eduvibe-post-thumb' );
if ( isset( $eduvibe_event_thumb_src ) && ! empty( $eduvibe_event_thumb_src ) ) :
    $eduvibe_event_thumb_url = $eduvibe_event_thumb_src[0];
else :
    $eduvibe_event_thumb_url = '';
endif;

echo '<div class="edu-event event-type-1 event-grid radius-small">';
    echo '<div class="inner">';
        if ( ! empty( $eduvibe_event_thumb_url ) ) :
            echo '<div class="thumbnail">';
                echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                    echo '<img src="' . esc_url( $eduvibe_event_thumb_url ) . '" alt="' . __( 'Event Image', 'eduvibe' ) . '">';
                echo '</a>';

                if ( ! empty( $eduvibe_event_date ) ) :
                    echo '<div class="top-position status-group left-top">';
                        echo '<span class="eduvibe-status">' . esc_html( $eduvibe_event_date ). '</span>';
                    echo '</div>';
                endif;
            echo '</div>';
        endif;

        echo '<div class="content">';

            if ( ! empty( $eduvibe_event_location ) ) :
                echo '<ul class="event-meta">';
                    echo '<li><i class="icon-map-pin-line"></i>' . esc_html(  $eduvibe_event_location ) . '</li>';
                echo '</ul>';
            endif;
            
            the_title( '<h5 class="title"><a href="' . esc_url( get_the_permalink() ) . '" class="post-link">', '</a></h5>' );

            if ( ! empty( $args['button_text'] ) ) :
                echo '<div class="read-more-btn">';
                    echo '<a class="btn-transparent" href="' . esc_url( get_the_permalink() ) . '">' . esc_html( $args['button_text'] ) . '<i class="icon-arrow-right-line-right"></i></a>';
                echo '</div>';
            endif;
        echo '</div>';
    echo '</div>';
echo '</div>';