<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
echo '<div class="eduvibe-single-course course-style-' . esc_attr( $block_data['style'] ) . ' radius-small">';
    echo '<div class="inner">';
        echo '<div class="thumbnail">';
            echo '<a class="course-thumb" href="' . esc_url( get_the_permalink() ) . '">';
                echo '<img class="w-100" src="' . esc_url( $block_data['thumb_url'] ) . '" alt="' . esc_attr( eduvibe_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '">';
            echo '</a>';

            if ( $block_data['cat_item'] ) :
                echo '<div class="top-position status-group left-top">';
                    echo '<span class="eduvibe-status status-01 bg-primary-color">' . wp_kses_post( $block_data['cat_item'] ) . '</span>';
                echo '</div>';
            endif;
        echo '</div>';

        echo '<div class="content">';
            echo '<ul class="edu-meta meta-04">';
                echo '<li>';
                    echo '<i class="icon-file-list-3-line"></i>';
                    echo esc_html( $block_data['lessons'] );
                    _e( ' Lessons', 'eduvibe' );
                echo '</li>';
                
                echo '<li>';
                    echo '<i class="icon-time-line"></i>';
                    echo esc_html( $block_data['duration'] );
                echo '</li>';
            echo '</ul>';

            echo eduvibe_get_title();
            
            if ( true === $block_data['enable_excerpt'] ) :
                echo '<div class="card-bottom">';
                    echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $block_data['excerpt_length'] ), esc_html( $block_data['excerpt_end'] ) ) );
                echo '</div>';
            endif;
        echo '</div>';
    echo '</div>';
echo '</div>';