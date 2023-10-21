<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
echo '<div class="eduvibe-single-course course-style-' . esc_attr( $block_data['style'] ) . ' radius-small">';
    echo '<div class="inner">';
        echo '<div class="thumbnail">';
            echo '<a class="course-thumb" href="' . esc_url( get_the_permalink() ) . '">';
                echo '<img class="w-100" src="' . esc_url( $block_data['thumb_url'] ) . '" alt="' . esc_attr( eduvibe_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '">';
            echo '</a>';

            if ( class_exists( 'LP_Addon_Wishlist' ) ) :
                echo '<div class="wishlist-top-right">';
                    eduvibe_lp_wishlist_icon( get_the_ID() );
                echo '</div>';
            endif;

            if ( $block_data['featured'] ) :
                echo '<div class="top-position status-group left-top">';
                    echo '<span class="eduvibe-status status-04">' . esc_html( $block_data['featured'] ) . '</span>';
                echo '</div>';
            endif;
        echo '</div>';

        echo '<div class="content">';
            echo '<div class="card-top">';
                echo '<div class="author-meta">';
                    echo '<div class="author-thumb">';
                        echo get_avatar( get_the_author_meta( 'ID' ), 40 );
                        echo '<span class="author-title">';
                            the_author();
                        echo '</span>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';

            echo '<ul class="edu-meta meta-03">';
                echo '<li class="meta-lessons">';
                    echo '<i class="icon-file-list-4-line"></i>';
                    echo esc_html( $block_data['lessons'] );
                    _e( ' Lessons', 'eduvibe' );
                echo '</li>';

                echo '<li class="meta-clock capitalize">';
                    echo '<i class="icon-time-line"></i>';
                    echo esc_html( $block_data['duration'] );
                echo '</li>';

                echo '<li class="meta-user">';
                    echo '<i class="icon-group-line"></i>';
                    echo esc_html( $block_data['enrolled'] );
                echo '</li>';
            echo '</ul>';

            echo eduvibe_get_title();
            
            echo '<div class="card-bottom">';
                echo '<div class="course-price-wrapper">';
                    LP()->template( 'course' )->courses_loop_item_price();
                echo '</div>';
                echo '<div class="edu-rating rating-default">';
                    if ( class_exists( 'LP_Addon_Course_Review_Preload' ) ) :
                        echo '<div class="edu-rating rating-default">';
                            eduvibe_lp_course_ratings( true );
                        echo '</div>';
                    endif;
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';