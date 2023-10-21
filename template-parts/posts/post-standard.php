<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

$eduvibe_post_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
if ( isset( $eduvibe_post_thumb_src ) && ! empty( $eduvibe_post_thumb_src ) ) :
    $eduvibe_post_thumb_url = $eduvibe_post_thumb_src[0];
else :
    $eduvibe_post_thumb_url = '';
endif;

$excerpt_length = eduvibe_get_config( 'blog_post_excerpt_length', 42 );
if ( isset( $_GET['excerpt_length'] ) ) :
	$excerpt_length = (int)$_GET['excerpt_length'] ? $_GET['excerpt_length'] : $excerpt_length;
endif;

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'eduvibe_post_standard_classes', 'eduvibe-post-one-single-grid eduvibe-col-lg-12 eduvibe-blog-post-standard' ) ); ?>>
    <?php
    echo '<div class="edu-blog radius-small">';
        echo '<div class="inner">';
            if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
                echo '<div class="thumbnail">';
                    echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                        echo '<img src="' . esc_url( $eduvibe_post_thumb_url ). '" alt="' . esc_attr( eduvibe_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '" >';
                    echo '</a>';

                    if ( eduvibe_category_by_id( get_the_ID() ) ) :
                        echo '<div class="top-position status-group left-top">';
                            echo '<span class="eduvibe-status status-01 bg-primary-color">' . wp_kses_post( eduvibe_category_by_id( get_the_ID(), 'category' ) ) . '</span>';
                        echo '</div>';
                    endif;
                echo '</div>';
            endif;

            echo '<div class="content">';
                echo '<ul class="eduvibe-blog-meta">';
                    echo '<li>';
                        echo '<i class="icon-eye-line"></i>';
                        echo eduvibe_post_estimated_reading_time() . ' '. __( 'Read', 'eduvibe' );
                    echo '</li>';

                    echo '<li>';
                        echo '<i class="icon-discuss-line"></i>';
                        printf( // WPCS: XSS OK.
                            /* translators: 1: comment count number, 2: title. */
                            esc_html( _nx( '%1$s Comment', '%1$s Comments', get_comments_number(), 'comments title', 'eduvibe' ) ),
                            number_format_i18n( get_comments_number() ),
                            '<span>' . get_the_title() . '</span>'
                        );
                    echo '</li>';

                    echo '<li>';
                        echo '<i class="icon-calendar-2-line"></i>';
                        echo esc_html( get_the_date( 'd M, Y' ) );
                    echo '</li>';
                echo '</ul>';

                echo eduvibe_get_title();

                echo '<div class="card-bottom">';
                    echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $excerpt_length ), '...' ) );
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';