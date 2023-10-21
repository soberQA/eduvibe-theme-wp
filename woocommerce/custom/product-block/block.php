<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

if ( ! isset( $block_data ) ) :
	$block_data = array();
endif;

global $post, $product;
$thumb_url = '';
$thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium_large' );

if ( isset( $thumb_src ) && ! empty( $thumb_src ) ) :
    $thumb_url = $thumb_src[0];
endif;

$default_data = array(
    'thumb_url' => $thumb_url
);

$block_data = wp_parse_args( $block_data, $default_data );

echo '<div class="eduvibe-single-product-inner">';
    echo '<div class="eduvibe-single-product-thumb-wrapper">';
    	woocommerce_template_loop_product_link_open();
            echo '<div class="eduvibe-single-product-thumb" style="background-image: url(' . esc_url( $block_data['thumb_url'] ) . ')"></div>';
        woocommerce_template_loop_product_link_close();

        echo '<div class="product-over-info">';
            echo '<ul>';
                if ( class_exists( 'YITH_WCQV' ) ) :
                    echo '<li>';
                        echo '<a href="#" class="button yith-wcqv-button" data-product_id="' . esc_attr( $product->get_id() ) . '">';
                            echo '<span class="eduvibe-product-popup-icon"><i class="ri-search-line"></i></span>';
                            echo '<span class="eduvibe-product-popup-text">Quick View</span>';
                        echo '</a>';
                    echo '</li>';
                endif;

                echo '<li class="add-to-cart">';
                    echo '<span>';
                        woocommerce_template_loop_add_to_cart();
                    echo '</span>';
                echo '</li>';
            echo '</ul>';
        echo '</div>';
    echo '</div>';
    echo '<div class="content">';
        eduvibe_woocommerce_template_loop_product_author();
    	woocommerce_template_loop_product_link_open();
		do_action( 'woocommerce_shop_loop_item_title' );
        woocommerce_template_loop_product_link_close();
    	woocommerce_template_loop_price();
    echo '</div>';
echo '</div>';