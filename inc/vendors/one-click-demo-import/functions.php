<?php

/**
 * Remove One Click demo importer branding
 */
add_filter( 'pt-ocdi/disable_pt_branding', '__return_false' );

function eduvibe_import_theme_demo_files() {
    return array(
        array(
            'import_file_name'             => __( 'EduVibe LearnPress Demo', 'eduvibe' ),
            'categories'                   => array( 'LearnPress' ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/demo-data/demo-content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/demo-data/widgets.wie',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'lib/demo-data/customizer.dat',
            'local_import_redux'           => array(
                array(
                    'file_path'            => trailingslashit( get_template_directory() ) . 'lib/demo-data/redux_options.json',
                    'option_name'          => 'eduvibe_theme_options'
                )
            ),
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'lib/demo-data/eduvibe_demo.png',
            'import_notice'                => __( 'Import process may take 5-10 minutes depends on your internet speed. If you\'re facing any issues please <a href="https://devsvibe.ticksy.com/" target="_blank">support</a>.', 'eduvibe' ),
            'preview_url'                  => 'https://eduvibe.devsvibe.com/main/'
        )
    );
}
add_filter( 'pt-ocdi/import_files', 'eduvibe_import_theme_demo_files' );


function eduvibe_ocdi_after_import( $selected_import ) {
    $main_menu       = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary-menu' => $main_menu->term_id
        )
    );

    $front_page_id    = get_page_by_title( 'Home 1' );
    $blog_page_id     = get_page_by_title( 'Blog' );
    $shop_page_id     = get_page_by_title( 'Shop' );
    $cart_page_id     = get_page_by_title( 'Cart' );
    $checkout_page_id = get_page_by_title( 'Checkout' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
    update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
    update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
    update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
    update_option( 'woocommerce_enable_myaccount_registration', 'yes' );

    update_option( 'elementor_global_image_lightbox', 0 );
    update_option( 'elementor_disable_color_schemes', 'yes' );
    update_option( 'elementor_disable_typography_schemes', 'yes' );
    update_option( 'elementor_container_width', 1200 );

    $file = trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/settings.json';
    if ( file_exists( $file ) ) :
        eduvibe_ocdi_import_settings($file);
    endif;
}

add_action( 'pt-ocdi/after_import', 'eduvibe_ocdi_after_import' );

function eduvibe_ocdi_import_settings( $file ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
    require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
    $file_obj = new WP_Filesystem_Direct( array() );
    $datas = $file_obj->get_contents($file);
    $datas = json_decode( $datas, true );

    if ( count( array_filter( $datas ) ) < 1 ) :
        return;
    endif;

    if ( ! empty( $datas['page_options'] ) ) :
        eduvibe_ocdi_import_page_options( $datas['page_options'] );
    endif;
}

function eduvibe_ocdi_import_page_options( $datas ) {
    if ( $datas ) :
        foreach ( $datas as $option_name => $page_id ) :
            update_option( $option_name, $page_id );
        endforeach;
    endif;
}