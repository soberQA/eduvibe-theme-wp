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
            
            if ( $block_data['cat_item'] ) :
                echo '<div class="top-position status-group left-bottom">';
                    echo '<span class="eduvibe-status status-03">' . wp_kses_post( $block_data['cat_item'] ) . '</span>';
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
                echo '<ul class="edu-meta meta-02">';
                    echo '<li>';
                        echo '<i class="icon-file-list-3-line"></i>';
                        echo esc_html( $block_data['lessons'] );
                        _e( ' Lessons', 'eduvibe' );
                    echo '</li>';
                echo '</ul>';
            echo '</div>';

            echo eduvibe_get_title();

            echo '<div class="card-bottom">';
                echo '<div class="course-price-wrapper">';
                    LP()->template( 'course' )->courses_loop_item_price();
                echo '</div>';

                if ( class_exists( 'LP_Addon_Course_Review_Preload' ) ) :
                    echo '<div class="edu-rating rating-default">';
                        eduvibe_lp_course_ratings( true );
                    echo '</div>';
                endif;

            echo '</div>';
        echo '</div>';
    echo '</div>';

    echo '<div class="card-hover-action">';
        echo '<div class="hover-content">';
            echo '<div class="content-top">';
                if ( $block_data['cat_item'] ) :
                    echo '<div class="top-status-bar">';
                        echo '<span class="eduvibe-status status-03">' . wp_kses_post( $block_data['cat_item'] ) . '</span>';
                    echo '</div>';
                endif;

                if ( class_exists( 'LP_Addon_Wishlist' ) ) :
                    echo '<div class="top-wishlist-bar">';
                        eduvibe_lp_wishlist_icon( get_the_ID() );
                    echo '</div>';
                endif;
            echo '</div>';

            echo eduvibe_get_title();

            if ( true === $block_data['enable_excerpt'] ) :
                echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $block_data['excerpt_length'] ), esc_html( $block_data['excerpt_end'] ) ) );
            endif;
            
            echo '<div class="course-price-wrapper">';
                LP()->template( 'course' )->courses_loop_item_price();
            echo '</div>';

            echo '<div class="hover-bottom-content">';
                echo '<div class="author-meta">';
                    echo '<div class="author-thumb">';
                        echo get_avatar( get_the_author_meta( 'ID' ), 40 );
                        echo '<span class="author-title">';
                            the_author();
                        echo '</span>';
                    echo '</div>';
                echo '</div>';

                echo '<ul class="edu-meta meta-02">';
                    echo '<li>';
                        echo '<i class="icon-file-list-3-line"></i>';
                        echo esc_html( $block_data['lessons'] );
                        _e( ' Lessons', 'eduvibe' );
                    echo '</li>';
                echo '</ul>';
            echo '</div>';
            
            echo '<div class="read-more-btn">';
                echo '<a class="edu-btn btn-medium btn-white" href="' . esc_url( get_the_permalink() ) . '">' . esc_html( $block_data['button_text'] ) . '<i class="icon-arrow-right-line-right"></i></a>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';