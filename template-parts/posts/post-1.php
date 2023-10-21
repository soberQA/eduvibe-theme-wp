<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

$eduvibe_post_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'eduvibe-post-thumb' );
if ( isset( $eduvibe_post_thumb_src ) && ! empty( $eduvibe_post_thumb_src ) ) :
    $eduvibe_post_thumb_url = $eduvibe_post_thumb_src[0];
else :
    $eduvibe_post_thumb_url = '';
endif;

$blog_post_desktop_cols = 12/eduvibe_get_config( 'blog_post_columns', 2 );

if ( isset( $_GET['column'] ) && $_GET['column'] == 3 ) :
	$blog_post_desktop_cols = 4;
endif;
?>
<div id="post-<?php the_ID(); ?>" <?php post_class( 'eduvibe-post-one-single-grid eduvibe-col-lg-' . esc_attr( $blog_post_desktop_cols ) . ' eduvibe-col-md-6 eduvibe-col-sm-12' ); ?>>
    <?php
    echo '<div class="edu-blog eduvibe-blog-post-1 radius-small">';
        echo '<div class="inner">';
            if ( $eduvibe_post_thumb_url ) :
                echo '<div class="thumbnail">';
                    echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                        echo '<img src="' . esc_url( $eduvibe_post_thumb_url ). '" alt="' . esc_attr( eduvibe_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '" >';
                    echo '</a>';
                echo '</div>';
            endif;

            echo '<div class="content">';
                echo '<div class="status-group">';
                    echo '<span class="eduvibe-status status-05">';
                        echo '<i class="icon-price-tag-3-line"></i>';
                        echo eduvibe_category_by_id( get_the_ID() );
                    echo '</span>';
                echo '</div>';

                echo eduvibe_get_title();

                echo '<div class="blog-card-bottom">';
                    echo '<ul class="eduvibe-blog-meta">';
                        echo '<li><i class="icon-calendar-2-line"></i>' . esc_html( get_the_date( 'd M, Y' ) ) . '</li>';
                    echo '</ul>';

                    echo '<div class="read-more-btn">';
                        echo '<a class="btn-transparent" href="' . esc_url( get_the_permalink() ) . '">';
                            echo __( 'Read More', 'eduvibe' ) . ' <i class="icon-arrow-right-line-right"></i>';
                        echo '</a>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';
