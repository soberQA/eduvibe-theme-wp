<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
global $post;
$eduvibe_related_posts_to_show  = eduvibe_get_config( 'blog_single_number_of_related_posts', 4 );
$eduvibe_related_posts_terms    = get_the_terms( $post->ID, 'category' );
$eduvibe_related_posts_term_ids = array();

if ( $eduvibe_related_posts_terms ) :
    foreach( $eduvibe_related_posts_terms as $term ) :
        $eduvibe_related_posts_term_ids[] = $term->term_id;
    endforeach;
endif;

$eduvibe_related_posts_args = array(
    'post_type'      => 'post',
    'posts_per_page' => $eduvibe_related_posts_to_show,
    'post__not_in'   => array( $post->ID ),
    'tax_query'      => array(
        'relation'   => 'AND',
        array(
            'taxonomy' => 'category',
            'field'    => 'id',
            'terms'    => $eduvibe_related_posts_term_ids,
            'operator' => 'IN'
        )
    )
);

$eduvibe_related_posts = new WP_Query( $eduvibe_related_posts_args );
if ( $eduvibe_related_posts->have_posts() ) :
    echo '<div class="eduvibe-related-posts-wrapper eduvibe-blog-post-archive-style-1">';
        $related_products_heading = eduvibe_get_config( 'blog_single_related_posts_title', __( 'Related Posts', 'eduvibe' ) );
        if ( $related_products_heading ) :
            echo '<h3 class="eduvibe-related-product-title">' . esc_html( $related_products_heading ) . '</h2>';
        endif;

        echo '<div class="eduvibe-related-product-items owl-carousel owl-theme" data-slidestoshow="2" data-tablet-items="2" data-mobile-items="1" data-small-mobile-items="1" data-autoplay="true" data-loop="true">';
            while ( $eduvibe_related_posts->have_posts() ) : $eduvibe_related_posts->the_post();
                $eduvibe_post_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'eduvibe-post-thumb' );
                if ( isset( $eduvibe_post_thumb_src ) && ! empty( $eduvibe_post_thumb_src ) ) :
                    $eduvibe_post_thumb_url = $eduvibe_post_thumb_src[0];
                else :
                    $eduvibe_post_thumb_url = '';
                endif;

                echo '<div class="eduvibe-single-blog" style="background-image: url(' . esc_url( $eduvibe_post_thumb_url ) . ')">';
                    echo '<div class="blog-content">';
                        echo '<ul class="blog-meta date">';
                            echo '<li><i class="flaticon-hour"></i>' . esc_html( get_the_date( get_option( 'date_format' ) ) ) . '</li>';
                        echo '</ul>';
                        the_title( '<h4 class="title"><a href="' . esc_url( get_the_permalink() ) . '" class="post-link">', '</a></h4>' );
                    echo '</div>';
                echo '</div>';
            endwhile;
            wp_reset_postdata();
        echo '</div>';
    echo '</div>';
endif;