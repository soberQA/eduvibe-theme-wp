<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
echo '<div class="eduvibe-single-course course-style-' . esc_attr( $block_data['style'] ) . ' radius-small">';
    echo '<div class="inner">';
        echo '<div class="thumbnail">';
            echo '<a class="course-thumb" href="' . esc_url( get_the_permalink() ) . '">';
                echo '<img class="w-100" src="' . esc_url( $block_data['thumb_url'] ) . '" alt="' . esc_attr( eduvibe_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '">';
            echo '</a>';

            echo '<div class="top-position status-group left-top">';
                if ( $block_data['discount'] ) :
                    echo '<span class="eduvibe-status status-01 bg-secondary-color">';
                        echo eduvibe_lp_course_sale_offer_in_percentage();
                    echo '</span>';
                endif;
                echo '<span class="eduvibe-status status-01 bg-primary-color capitalize">' . esc_html( $block_data['level'] ) . '</span>';
            echo '</div>';
            
            if ( class_exists( 'LP_Addon_Wishlist' ) ) :
                echo '<div class="wishlist-top-right">';
                    eduvibe_lp_wishlist_icon( get_the_ID() );
                echo '</div>';
            endif;
        echo '</div>';

        echo '<div class="content">';
            echo '<div class="course-price-wrapper">';
                LP()->template( 'course' )->courses_loop_item_price();
            echo '</div>';

            echo eduvibe_get_title();

            echo '<ul class="edu-meta meta-01">';
                echo '<li>';
                    echo '<i class="icon-time-line"></i>';
                    echo esc_html( $block_data['duration'] );
                echo '</li>';

                echo '<li>';
                    echo '<i class="icon-group-line"></i>';
                    echo esc_html( $block_data['enrolled'] );
                    _e( ' Students', 'eduvibe' );
                echo '</li>';
            echo '</ul>';

            echo '<div class="card-bottom">';
                echo '<div class="read-more-btn">';
                    echo '<a class="btn-transparent" href="' . esc_url( get_the_permalink() ) . '">' . esc_html( $block_data['button_text'] ) . '<i class="icon-arrow-right-line-right"></i></a>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';