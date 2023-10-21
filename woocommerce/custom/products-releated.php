<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
global $post;

$eduvibe_related_products_to_show  = apply_filters( 'eduvibe_woo_related_product_count', 5 );
$eduvibe_related_products_terms    = get_the_terms( $post->ID, 'product_cat' );
$eduvibe_related_products_term_ids = array();

if ( $eduvibe_related_products_terms ) :
    foreach( $eduvibe_related_products_terms as $term ) :
        $eduvibe_related_products_term_ids[] = $term->term_id;
    endforeach;
endif;

$eduvibe_related_products_args = array(
    'post_type'      => 'product',
    'posts_per_page' => $eduvibe_related_products_to_show,
    'post__not_in'   => array( $post->ID ),
    'tax_query'      => array(
        'relation'   => 'AND',
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'id',
            'terms'    => $eduvibe_related_products_term_ids,
            'operator' => 'IN'
        )
    )
);

$eduvibe_related_products = new WP_Query( $eduvibe_related_products_args );
if ( $eduvibe_related_products->have_posts() ) :
    $subtitle = eduvibe_get_config( 'woo_related_products_subtitle', __( 'SIMILAR ITEMS', 'eduvibe' ) );
    $title = eduvibe_get_config( 'woo_related_products_title', __( 'Related Products', 'eduvibe' ) );

    if ( $title || $subtitle ) :
        echo '<div class="section-title text-center eduvibe-mb--50">';
            if ( $subtitle ) :
                echo '<span class="pre-title">' . esc_html( $subtitle ) . '</span>';
            endif;
            if ( $title ) :
                echo '<h3 class="title">' . esc_html( $title ) . '</h3>';
            endif;
        echo '</div>';
    endif;

    echo '<div class="eduvibe-related-product-items owl-carousel owl-theme" data-slidestoshow="4" data-tablet-items="2" data-mobile-items="2" data-small-mobile-items="1" data-autoplay="true" data-loop="true">';
        while ( $eduvibe_related_products->have_posts() ) : $eduvibe_related_products->the_post();
            echo '<div class="eduvibe-single-product-item">';
                wc_get_template( 'custom/product-block/block.php' );
            echo '</div>';
        endwhile;
        wp_reset_postdata();
    echo '</div>';
endif;