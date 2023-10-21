<?php

/**
 * return the value of meta options
 * 
 * @since 1.0.0
 */
function eduvibe_get_config( $name, $default = '' ) {
	global $eduvibe_options;
    if ( isset( $eduvibe_options[$name] ) ) :
        return $eduvibe_options[$name];
    endif;
    return $default;
}

/**
 * check if LearnPress is active/deactive
 *
 * return boolean
 * 
 * @since 1.0.0
 */
function eduvibe_is_learnpress_activated() {
	return class_exists( 'LearnPress' ) ? true : false; 
}

/**
 * check if LearnDash is active/deactive
 *
 * return boolean
 * 
 * @since 1.0.0
 */
function eduvibe_is_learndash_activated() {
	return class_exists( 'SFWD_LMS' ) ? true : false;
}

/**
 * check if Tutor LMS is active/deactive
 *
 * return boolean
 * 
 * @since 1.0.0
 */
function eduvibe_is_tutor_lms_activated() {
	return function_exists( 'tutor' ) ? true : false;
}

/**
 * check if WooCommerce is active/deactive
 *
 * return boolean
 * 
 * @since 1.0.0
 */
function eduvibe_is_woocommerce_activated() {
	return class_exists( 'WooCommerce' ) ? true : false;
}

/**
 * return all the header items from eduvibe_header post type 
 * and theme default headers
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'eduvibe_get_header_layouts' ) ) :
	function eduvibe_get_header_layouts() {
		$headers = apply_filters( 'eduvibe_theme_header_types', array(
			'theme-default-header' => 'Theme Default Header',
			'theme-header-1' => 'Theme Header 1',
			'theme-header-2' => 'Theme Header 2',
			'theme-header-3' => 'Theme Header 3'
		) );

		$args    = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'eduvibe_header',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		$posts = get_posts( $args );
		foreach ( $posts as $post ) :
			$headers[$post->post_name] = $post->post_title;
		endforeach;
		return $headers;
	}
endif;

/**
 * return elementor header
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'eduvibe_get_header_config' ) ) :
	function eduvibe_get_header_config() {
		global $post;
		if ( is_page() && is_object( $post ) && isset( $post->ID ) ) :
			$header = get_post_meta( $post->ID, 'eduvibe_page_header_type', true );
			if ( empty( $header ) || $header == 'global' ) :
				return eduvibe_get_config( 'header_type' );
			endif;
			return $header;
		endif;
		return eduvibe_get_config( 'header_type' );
	}
	add_filter( 'eduvibe_get_header_layout', 'eduvibe_get_header_config' );
endif;

/**
 * print Elementor Header
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'eduvibe_display_header_builder' ) ) :
		function eduvibe_display_header_builder( $header_slug ) {
			$args = array(
				'name'        => $header_slug,
				'post_type'   => 'eduvibe_header',
				'post_status' => 'publish',
				'numberposts' => 1
			);
			$posts         = get_posts( $args );
			$sticky_header = eduvibe_get_config( 'sticky_header', true );
			foreach ( $posts as $post ) :
				$classes        = array( 'eduvibe-elementor-header-wrapper' );
				$classes[]      = $post->post_name . '-' . $post->ID;
				$bg_color       = '';

				echo '<header class="' . esc_attr( implode( ' ', $classes ) ) . '">';
					echo '<div class="eduvibe-header-container"' . trim( $bg_color ) . '>';
						if ( $sticky_header ) :
							echo '<div class="eduvibe-sticky-header-wrapper">';
						else :
							echo '<div class="eduvibe-non-sticky-header-wrapper">';
						endif;
							echo apply_filters( 'eduvibe_generate_post_builder', do_shortcode( $post->post_content ), $post, $post->ID );
						echo '</div>';
					echo '</div>';
				echo '</header>';

			endforeach;
		}
endif;

/**
 * return all the footer items from eduvibe_footer post type 
 * and theme default footers
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'eduvibe_get_footer_layouts' ) ) :
	function eduvibe_get_footer_layouts() {
		$footers = apply_filters( 'eduvibe_theme_footer_types', array(
			'theme-default-footer' => 'Theme Default Footer'
		) );

		$args = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'eduvibe_footer',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		$posts = get_posts( $args );
		foreach ( $posts as $post ) :
			$footers[$post->post_name] = $post->post_title;
		endforeach;
		return $footers;
	}
endif;

/**
 * return elementor footer
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'eduvibe_get_footer_config' ) ) :
	function eduvibe_get_footer_config() {
		global $post;
		if ( is_page() && is_object( $post ) && isset( $post->ID ) ) :
			$footer = get_post_meta( $post->ID, 'eduvibe_page_footer_type', true );
			if ( empty( $footer ) || $footer == 'global' ) :
				return eduvibe_get_config( 'footer_type' );
			endif;
			return $footer;
		endif;
		return eduvibe_get_config( 'footer_type' );
	}
	add_filter( 'eduvibe_get_footer_layout', 'eduvibe_get_footer_config' );
endif;

/**
 * print Elementor Header
 * 
 * @since 1.0.0
 */
function eduvibe_display_footer_builder( $footer_slug ) {
	$args = array(
		'name'        => $footer_slug,
		'post_type'   => 'eduvibe_footer',
		'post_status' => 'publish',
		'numberposts' => 1
	);

	$posts = get_posts($args);
	foreach ( $posts as $post ) :
		$classes = array( 'eduvibe-footer footer-builder-wrapper' );
		$classes[] = $post->post_name;

		echo '<footer id="eduvibe-footer" class="' . esc_attr( implode( ' ', $classes ) ) . '">';
			echo '<div class="eduvibe-footer-inner">';
				echo apply_filters( 'eduvibe_generate_post_builder', do_shortcode( $post->post_content ), $post, $post->ID);
			echo '</div>';
		echo '</footer>';
	endforeach;
}


/**
 * return category/single category with link
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'eduvibe_category_by_id' ) ) :
	function eduvibe_category_by_id( $post_id = null, $taxonomy = 'category', $single = true ) {
		$terms = get_the_terms( $post_id, $taxonomy );
		$cat = '';
		$cat_with_link = '';

		if ( is_array( $terms ) ) :
			foreach ( $terms as $tkey => $term ) :
				$cat .= $term->slug . ' ';
				$cat_with_link .= sprintf( '<a href="%s">%s</a>', esc_url( get_category_link( $term->term_id ) ), esc_html( $term->name ) );
				if ( $single ) :
					break;
				endif;
			endforeach;
		endif;
		return $cat_with_link;
	}
endif;

/**
 * get instructor lists from specific role type
 */
if ( ! function_exists( 'eduvibe_get_all_instructors' ) ) :
    function eduvibe_get_all_instructors( $user_role = 'lp_teacher' ) {
		$instructors = array();
		$user_role   = $user_role;
		$users       = get_users( 
            array( 
                'role__in' => array( 
                    $user_role
                ) 
            ) 
        );
        
        if ( is_array( $users ) && ! empty( $users ) && ! is_wp_error( $users ) ) :
            $instructors = ['' => ''];
            foreach ( $users as $user ) :
                if ( isset( $user ) ) :
                    $instructors[ $user->ID ] = $user->display_name.' [ID: '.$user->ID.']';
                endif;
            endforeach;
        else :
            $instructors[0] = __( 'No Instructor found',  'eduvibe' );
        endif;

        return $instructors;
    }
endif;

/**
 * Get Social icons for instructors
 */
if ( ! function_exists( 'eduvibe_user_social_icons' ) ) :
	function eduvibe_user_social_icons( $user_id, $link_tab = '_blank' ) {
		$facebook = $twitter = $linkedin = $pinterest = '';

		if ( ! $user_id ) :
			$user_id = get_current_user_id();
		endif;

		$facebook  = get_the_author_meta( 'eduvibe_facebook', $user_id );
		$twitter   = get_the_author_meta( 'eduvibe_twitter', $user_id );
		$linkedin  = get_the_author_meta( 'eduvibe_linkedin', $user_id );
		$pinterest   = get_the_author_meta( 'eduvibe_pinterest', $user_id );

		$facebook ? printf( '<a href="%s" target="' . esc_attr( $link_tab ) . '"><i class="icon-Fb"></i></a>', esc_url( $facebook ) ) : '';
		$linkedin ? printf( '<a href="%s" target="' . esc_attr( $link_tab ) . '"><i class="icon-linkedin"></i></a>', esc_url( $linkedin ) ) : '';
		$pinterest ? printf( '<a href="%s" target="' . esc_attr( $link_tab ) . '"><i class="icon-Pinterest"></i></a>', esc_url( $pinterest ) ) : '';
		$twitter ? printf( '<a href="%s" target="' . esc_attr( $link_tab ) . '"><i class="icon-Twitter"></i></a>', esc_url( $twitter ) ) : ''; 
	}
endif;

/**
 * Get title
 */
if ( ! function_exists( 'eduvibe_get_title' ) ) :
	function eduvibe_get_title() {
		$title = get_the_title();
		$class = 'title';

		if ( 0 === mb_strlen( $title ) ) :
			$title = '&nbsp;';
			$class = 'title empty-title';
		endif;

		if ( ! empty( $title ) ) :
			return '<h4 class="' . esc_attr( $class ). '"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( $title ) . '</a></h4>';
		endif;

		return '';
	}
endif;

/**
 * Theme main header
 */
add_action( 'eduvibe_main_header', 'eduvibe_header_setup' );
if ( ! function_exists( 'eduvibe_header_setup' ) ) :
	function eduvibe_header_setup() {
		$default_headers = array( 
			'theme-default-header',
			'theme-header-1',
			'theme-header-2',
			'theme-header-3'
		);
		$header = apply_filters( 'eduvibe_get_header_layout', eduvibe_get_config( 'header_type', 'theme-default-header' ) );
		$sticky_header = eduvibe_get_config( 'sticky_header', true );
		$classes[] = 'site-header';
		$classes[] = $header;

		if ( $sticky_header ) :
			$classes[] = 'header-get-sticky';
		endif;

		if ( 'none' !== $header ) :
			if ( in_array( $header, $default_headers ) || empty( $header ) ) :
				echo '<header id="masthead" class="' . esc_attr( implode( ' ', $classes ) ) . '">';
					echo '<div class="eduvibe-header-area eduvibe-navbar eduvibe-navbar-expand-lg">';
						if ( 'theme-default-header' === $header ) :
							eduvibe_theme_default_header();
						elseif ( 'theme-header-1' === $header ) :
							eduvibe_theme_header_1();
						elseif ( 'theme-header-2' === $header ) :
							eduvibe_theme_header_2();
						elseif ( 'theme-header-3' === $header ) :
							eduvibe_theme_header_3();
						else :
							eduvibe_theme_default_header();
						endif;
					echo '</div>';
				echo '</header>'; //#masthead
				
				// search modal popup
				eduvibe_search_modal_popup();

				// responsive menu
				eduvibe_responsive_menu_setup();
			else :
				eduvibe_display_header_builder( $header );
			endif;
		endif;

	}
endif;

/**
 * Theme default header
 */
if ( ! function_exists( 'eduvibe_theme_default_header' ) ) :
	function eduvibe_theme_default_header(){
		echo '<div class="' . esc_attr( apply_filters( 'eduvibe_theme_default_header_container_class', 'eduvibe-container' ) ) . '">';
			echo '<div class="eduvibe-row">';
				echo '<div class="eduvibe-col-xl-3 eduvibe-col-sm-8 eduvibe-col-10">';
					echo '<div class="site-branding site-logo-info">';
						eduvibe_logo_setup();
					echo '</div>';
				echo '</div>';

				echo '<div class="eduvibe-col-xl-9 eduvibe-col-sm-4 eduvibe-col-2">';
					echo '<div class="eduvibe-default-header-nav">';
						eduvibe_menu_setup();
						
						echo '<div class="quote-icon eduvibe-theme-nav-responsive hamburger-icon">';
							echo '<div class="eduvibe-mobile-hamburger-menu">';
								echo '<a href="javascript:void(0);">';
									echo '<i class="ri-menu-line"></i>';
								echo '</a>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Theme header 1
 */
if ( ! function_exists( 'eduvibe_theme_header_1' ) ) :
	function eduvibe_theme_header_1(){
		echo '<div class="' . esc_attr( apply_filters( 'eduvibe_theme_header_1_container_class', 'eduvibe-container' ) ) . '">';
			echo '<div class="eduvibe-row eduvibe-align-items-center">';

				echo '<div class="eduvibe-col-lg-6 eduvibe-col-xl-2 eduvibe-col-md-6 eduvibe-col-6">';
					echo '<div class="site-branding site-logo-info">';
						eduvibe_logo_setup();
					echo '</div>';
				echo '</div>';

				echo '<div class="eduvibe-theme-header-1-nav eduvibe-col-lg-8 eduvibe-d-none eduvibe-d-xl-block">';
					eduvibe_menu_setup();
				echo '</div>';

				echo '<div class="eduvibe-col-lg-6 eduvibe-col-xl-2 eduvibe-col-md-6 eduvibe-col-6">';
					echo '<div class="header-right d-flex eduvibe-justify-content-end">';
						echo '<div class="header-quote">';
							echo '<div class="quote-icon quote-search">';
								echo '<button class="search-trigger"><i class="ri-search-line"></i></button>';
							echo '</div>';

							eduvibe_header_user_login_option();

							echo '<div class="quote-icon eduvibe-theme-nav-responsive hamburger-icon">';
								echo '<div class="eduvibe-mobile-hamburger-menu">';
									echo '<a href="javascript:void(0);">';
										echo '<i class="ri-menu-line"></i>';
									echo '</a>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Theme header 2
 */
if ( ! function_exists( 'eduvibe_theme_header_2' ) ) :
	function eduvibe_theme_header_2(){
		echo '<div class="' . esc_attr( apply_filters( 'eduvibe_theme_header_2_container_class', 'eduvibe-container-fluid' ) ) . '">';
			echo '<div class="eduvibe-row eduvibe-align-items-center">';
				echo '<div class="eduvibe-col-lg-4 eduvibe-col-xl-3 eduvibe-col-md-6 eduvibe-col-6">';
					echo '<div class="site-branding site-logo-info">';
						eduvibe_logo_setup();
					echo '</div>';
				echo '</div>';

				echo '<div class="eduvibe-theme-header-1-nav eduvibe-col-lg-6 eduvibe-d-none eduvibe-d-xl-block">';
					eduvibe_menu_setup();
				echo '</div>';

				echo '<div class="eduvibe-col-lg-8 eduvibe-col-xl-3 eduvibe-col-md-6 eduvibe-col-6">';
					echo '<div class="header-right d-flex eduvibe-justify-content-end">';
						echo '<div class="header-quote">';
							echo '<div class="quote-icon quote-search">';
								echo '<button class="search-trigger"><i class="ri-search-line"></i></button>';
							echo '</div>';

							eduvibe_header_user_login_option( true );

							echo '<div class="quote-icon eduvibe-theme-nav-responsive hamburger-icon">';
								echo '<div class="eduvibe-mobile-hamburger-menu">';
									echo '<a href="javascript:void(0);">';
										echo '<i class="ri-menu-line"></i>';
									echo '</a>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Theme header 3
 */
if ( ! function_exists( 'eduvibe_theme_header_3' ) ) :
	function eduvibe_theme_header_3(){
		echo '<div class="' . esc_attr( apply_filters( 'eduvibe_theme_header_3_container_class', 'eduvibe-container-fluid' ) ) . '">';
			echo '<div class="eduvibe-row eduvibe-align-items-center">';
				echo '<div class="eduvibe-col-lg-4 eduvibe-col-xl-3 eduvibe-col-md-6 eduvibe-col-6">';
					echo '<div class="site-branding site-logo-info">';
						eduvibe_logo_setup();
					echo '</div>';
				echo '</div>';

				echo '<div class="eduvibe-theme-header-1-nav eduvibe-col-lg-6 eduvibe-d-none eduvibe-d-xl-block">';
					eduvibe_menu_setup();
				echo '</div>';

				echo '<div class="eduvibe-col-lg-8 eduvibe-col-xl-3 eduvibe-col-md-6 eduvibe-col-6">';
					echo '<div class="header-right d-flex eduvibe-justify-content-end">';
						echo '<div class="header-quote">';
							eduvibe_header_user_login_option( true );

							echo '<div class="quote-icon eduvibe-theme-nav-responsive hamburger-icon">';
								echo '<div class="eduvibe-mobile-hamburger-menu">';
									echo '<a href="javascript:void(0);">';
										echo '<i class="ri-menu-line"></i>';
									echo '</a>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Logo Setup
 */
if ( ! function_exists( 'eduvibe_logo_setup' ) ) :
    function eduvibe_logo_setup(){
		echo '<div class="logo-wrapper" itemscope itemtype="http://schema.org/Brand">';
			if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) :
				the_custom_logo();
			else :
				echo '<a href="' . esc_url( home_url( '/' ) ) . '">';
					echo '<img src="' . esc_url( get_template_directory_uri().'/assets/images/logo.png' ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
				echo '</a>';
			endif;
		echo '</div>';
    }
endif;

/**
 * Menu Setup
 */
if ( ! function_exists( 'eduvibe_menu_setup' ) ) :
    function eduvibe_menu_setup(){
        if ( has_nav_menu( 'primary-menu' ) ) :
			echo '<nav id="site-navigation" class="main-navigation eduvibe-theme-nav eduvibe-navbar-collapse">';
				echo '<div class="eduvibe-navbar-primary-menu">';
					do_action( 'eduvibe_before_main_menu' );
					wp_nav_menu( array(
						'theme_location' => 'primary-menu',
						'depth'          => 4,
						'container'      => 'div',
						'container_class'=> 'primary-menu-container-class',
						'container_id'   => 'primary-menu-container-id',
						'menu_class'     => 'eduvibe-default-header-navbar eduvibe-navbar-nav eduvibe-navbar-right',
						'menu_id'        => 'primary-menu-custom-id',
						'fallback_cb'    => 'wp_bootstrap_navwalker::fallback',
						'walker'         => new EduVibe\Navwalker\WP_Bootstrap_Navwalker()							
					) );
					do_action( 'eduvibe_after_main_menu' );
				echo '</div>';
			echo '</nav>';//#site-navigation
		endif;
    }
endif;

/**
 * Responsive Menu Setup
 */
if ( ! function_exists( 'eduvibe_responsive_menu_setup' ) ) :
    function eduvibe_responsive_menu_setup(){
        if ( has_nav_menu( 'primary-menu' ) ) :
			echo '<div class="eduvibe-mobile-menu">';
				echo '<div class="eduvibe-mobile-menu-overlay"></div>';

				echo '<div class="eduvibe-mobile-menu-nav-wrapper">';
					echo '<div class="responsive-header-top">';
						echo '<div class="responsive-header-logo">';
							eduvibe_logo_setup();
						echo '</div>';
						
						echo '<div class="eduvibe-mobile-menu-close">';
							echo '<a href="javascript:void(0);">';
								echo '<i class="ri-close-line"></i>';
							echo '</a>';
						echo '</div>';
					echo '</div>';

					wp_nav_menu( array(
						'theme_location'  => 'primary-menu',
						'depth'           => 4,
						'container'       => 'ul',
						'menu_id'         => 'eduvibe-mobile-menu-item',
						'menu_class'      => 'eduvibe-mobile-menu-item'						
					) );
				echo '</div>';
			echo '</div>';
		endif;
    }
endif;

/**
 * change default logo class
 */
add_filter( 'get_custom_logo', 'eduvibe_logo_class' );
if ( ! function_exists( 'eduvibe_logo_class' ) ) :
	function eduvibe_logo_class( $html ) {
	    $html = str_replace( 'custom-logo-link', 'navbar-brand', $html );
	    $html = str_replace( 'custom-logo', 'img-responsive', $html );
	    return $html;
	}
endif;

/**
 * Header Search Modal PopUp
 */
if ( ! function_exists( 'eduvibe_search_modal_popup' ) ) :
	function eduvibe_search_modal_popup() {
		echo '<div class="edu-search-popup">';
            echo '<div class="close-button">';
				echo '<button class="close-trigger"><i class="ri-close-line"></i></button>';
            echo '</div>';

            echo '<div class="inner">';
				echo '<form action="' . esc_url( home_url( '/' ) ) .'" class="search-form" method="get">';
					echo '<input type="text" class="eduvibe-search-popup-field" name="s" value="' . esc_attr( get_search_query() ) . '" placeholder="' . esc_attr__( 'Search Here...', 'eduvibe') . '">';
                    echo '<button class="submit-button"><i class="icon-search-line"></i></button>';
				echo '</form>';
            echo '</div>';
        echo '</div>';
	}
endif;

/**
 * Header User Login/Register
 */
if ( ! function_exists( 'eduvibe_header_user_login_option' ) ) :
	function eduvibe_header_user_login_option( $icon_with_text = false ) {
		$header_button_text = eduvibe_get_config( 'custom_header_button_text' );
		$header_button_url = eduvibe_get_config( 'custom_header_button_url', '#' );
		echo '<div class="quote-icon quote-user">';
			if ( $header_button_text ) :
				echo '<a class="header-login-register button-text-with-icon custom-text" href="' . esc_url( $header_button_url ) . '" target="_blank">' . wp_kses_post( $header_button_text ). '</a>';
			else :
				if ( $icon_with_text ) :
					echo '<a class="header-login-register button-text-with-icon" href="' . esc_url( wp_login_url( get_permalink() ) ) . '" target="_blank"><i class="ri-user-line"></i><span class="button-text">' . __( 'Login / Register', 'eduvibe' ). '</span></a>';
				else :
					echo '<a class="header-login-register" href="' . esc_url( wp_login_url( get_permalink() ) ) . '" target="_blank"><i class="ri-user-line"></i></a>';
				endif;
			endif;
		echo '</div>';
	}
endif;

/**
 * Header User Login/Register( alter )
 */
if ( ! function_exists( 'eduvibe_header_user_login_option_alter' ) ) :
	function eduvibe_header_user_login_option_alter( $icon_with_text = false ) {
		echo '<div class="quote-icon quote-user">';
			if ( is_user_logged_in() ) :
				$user_id = get_current_user_id();
				$user    = get_userdata( $user_id );
				if ( function_exists( 'learn_press_get_page_link' ) ) :
					$profile_url = learn_press_get_page_link( 'profile' );
					echo '<a href="' . esc_url( $profile_url ) . '">';
						echo get_avatar( $user_id, 100 );
					echo '</a>';
				else :
					echo get_avatar( $user_id, 100 );
				endif;
			else :
				if ( $icon_with_text ) :
					echo '<a class="header-login-register button-text-with-icon" href="' . esc_url( wp_login_url( get_permalink() ) ) . '" target="_blank"><i class="ri-user-line"></i><span class="button-text">' . __( 'Login / Register', 'eduvibe' ) . '</span></a>';
				else :
					echo '<a class="header-login-register" href="' . esc_url( wp_login_url( get_permalink() ) ) . '" target="_blank"><i class="ri-user-line"></i></a>';
				endif;
			endif;
		echo '</div>';
	}
endif;


/**
 * theme after header
 * page title & breadcrumb
 */
add_action( 'eduvibe_after_header', 'eduvibe_breadcrumb_display' );
if ( ! function_exists( 'eduvibe_breadcrumb_display' ) ) :
	function eduvibe_breadcrumb_display() {
		global $post;
		$breadcrumb = '';
		$has_bg_image = '';
		$show = true;
		$style = array();

		if ( is_page() && is_object( $post ) ) :
			$breadcrumb_visibility      = get_post_meta( get_the_ID(), 'eduvibe_page_breadcrumb', true );
			$breadcrumb_show_framework = eduvibe_get_config( 'show_page_breadcrumb', true );
			if ( 'disable' !== $breadcrumb_visibility ) :
				if ( ( 'enable' === $breadcrumb_visibility ) || ( isset( $breadcrumb_show_framework ) && ! empty( $breadcrumb_show_framework ) ) ) :
					$default_breadcrumb_at_page = eduvibe_get_config( 'show_default_breadcrumb_at_page', true );
					$bg_meta_image      = get_post_meta( get_the_ID(), 'eduvibe_page_breadcrumb_image', true );
					$bg_meta_color      = get_post_meta( get_the_ID(), 'eduvibe_page_breadcrumb_color', true );
					$bg_framework_image = eduvibe_get_config( 'page_breadcrumb_image' );
					$bg_framework_color = eduvibe_get_config( 'page_breadcrumb_color' );

					if ( $bg_meta_color ) :
						$style[] = 'background-color:' . $bg_meta_color;
					elseif ( $bg_framework_color ) :
						$style[] = 'background-color:' . $bg_framework_color;
					endif;

					if ( $bg_meta_image ) : 
						$style[] = 'background-image:url(\''.esc_url( $bg_meta_image ).'\' )';
						$has_bg_image = 'eduvibe-breadcrumb-has-bg'; 
					elseif ( $default_breadcrumb_at_page && empty( $bg_meta_color ) ) : 
						eduvibe_default_breadcrumb();
						return;
					elseif ( ( isset( $bg_framework_image['url'] ) && ! empty( $bg_framework_image['url'] ) ) && empty( $bg_meta_color ) ) :
						$style[] = 'background-image:url(\''.esc_url( $bg_framework_image['url'] ).'\' )';
						$has_bg_image = 'eduvibe-breadcrumb-has-bg';
					endif;

				else :
					return '';
				endif;
			else :
				return '';
			endif;

	    elseif ( is_singular( 'simple_event' ) || is_post_type_archive( 'simple_event' ) || is_tax( 'simple_event_category' ) || is_tax( 'simple_event_tags' ) ) :

			$show = eduvibe_get_config( 'show_event_breadcrumb', true );
			if ( ! $show ) :
				return ''; 
			endif;

			$default_breadcrumb_at_event = eduvibe_get_config( 'show_default_breadcrumb_at_event', true );
			if ( $default_breadcrumb_at_event ) :
				eduvibe_default_breadcrumb();
				return;
			endif;

			$breadcrumb_img   = eduvibe_get_config( 'event_breadcrumb_image' );
			$breadcrumb_color = eduvibe_get_config( 'event_breadcrumb_color' );
	        if ( $breadcrumb_color ) :
	            $style[] = 'background-color:' . esc_attr( $breadcrumb_color );
	        endif;
	        if ( isset( $breadcrumb_img['url'] ) && ! empty( $breadcrumb_img['url'] ) ) :
	            $style[] = 'background-image:url(\'' . esc_url( $breadcrumb_img['url'] ) . '\' )';
	            $has_bg_image = 'eduvibe-breadcrumb-has-bg';
	        endif;

	    elseif ( eduvibe_is_lms_courses() ) :
			$show = eduvibe_get_config( 'show_course_breadcrumb', true );
			if ( ! $show ) :
				return ''; 
			endif;

			$default_breadcrumb_at_course = eduvibe_get_config( 'show_default_breadcrumb_at_course', true );
			if ( $default_breadcrumb_at_course ) :
				eduvibe_default_breadcrumb();
				return;
			endif;

			$breadcrumb_img   = eduvibe_get_config( 'course_breadcrumb_image' );
			$breadcrumb_color = eduvibe_get_config( 'course_breadcrumb_color' );

	        if ( $breadcrumb_color ) :
	            $style[] = 'background-color:' . esc_attr( $breadcrumb_color );
	        endif;
	        if ( isset( $breadcrumb_img['url'] ) && ! empty( $breadcrumb_img['url'] ) ) :
	            $style[] = 'background-image:url(\'' . esc_url( $breadcrumb_img['url'] ) . '\' )';
	            $has_bg_image = 'eduvibe-breadcrumb-has-bg';
	        endif;

	    elseif ( eduvibe_is_woocommerce_activated() && is_woocommerce() ) :
			$show = eduvibe_get_config( 'show_shop_breadcrumb', true );
			if ( ! $show ) :
				return '';
			endif;

			$default_breadcrumb_at_shop = eduvibe_get_config( 'show_default_breadcrumb_at_shop', true );
			if ( $default_breadcrumb_at_shop ) :
				eduvibe_default_breadcrumb();
				return;
			endif;

			$breadcrumb_img = eduvibe_get_config( 'shop_breadcrumb_image' );
	        $breadcrumb_color = eduvibe_get_config( 'shop_breadcrumb_color' );
	        if ( $breadcrumb_color ) :
	            $style[] = 'background-color:' . esc_attr( $breadcrumb_color );
	        endif;
	        if ( isset( $breadcrumb_img['url'] ) && ! empty( $breadcrumb_img['url'] ) ) :
	            $style[] = 'background-image:url(\'' . esc_url( $breadcrumb_img['url'] ) . '\' )';
	            $has_bg_image = 'eduvibe-breadcrumb-has-bg';
	        endif;
		
		elseif ( is_singular( 'post' ) || is_search() || eduvibe_is_blog() ) :
			$show = eduvibe_get_config( 'show_blog_breadcrumb', true );
			if ( ! $show ) :
				return '';
			endif;

			$default_breadcrumb_at_blog = eduvibe_get_config( 'show_default_breadcrumb_at_blog', true );
			if ( $default_breadcrumb_at_blog ) :
				eduvibe_default_breadcrumb();
				return;
			endif;
			
			$breadcrumb_img   = eduvibe_get_config( 'blog_breadcrumb_image' );
			$breadcrumb_color = eduvibe_get_config( 'blog_breadcrumb_color' );

	        if ( $breadcrumb_color ) :
	            $style[] = 'background-color:' . esc_attr( $breadcrumb_color );
	        endif;
	        if ( isset( $breadcrumb_img['url'] ) && ! empty( $breadcrumb_img['url'] ) ) :
	            $style[] = 'background-image:url(\'' . esc_url( $breadcrumb_img['url'] ) . '\' )';
	            $has_bg_image = 'eduvibe-breadcrumb-has-bg';
	        endif;
		endif;

		$title = eduvibe_get_page_title();
		$extra_style = ! empty( $style )? ' style="' . implode( "; ", $style ) . '"' : "";

		echo '<div class="eduvibe-page-title-area '. esc_attr( $has_bg_image ) .'"' . $extra_style .'>';
			echo '<div class="' . esc_attr( apply_filters( 'eduvibe_breadcrumb_container_class', 'eduvibe-container' ) ) . '">';
				echo '<div class="eduvibe-page-title">';
					echo '<h1 class="entry-title">';
						echo wp_kses_post( $title ); 
					echo '</h1>';
				echo '</div>';
				echo '<div class="eduvibe-breadcrumb-wrapper">';
					do_action( 'eduvibe_breadcrumb' );
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Default breadcrumb
 */
if ( ! function_exists( 'eduvibe_default_breadcrumb' ) ) :
	function eduvibe_default_breadcrumb() {
		$title = eduvibe_get_page_title();
		echo '<div class="eduvibe-page-title-area eduvibe-breadcrumb-has-bg eduvibe-default-breadcrumb">';
			echo '<div class="' . esc_attr( apply_filters( 'eduvibe_default_breadcrumb_container_class', 'eduvibe-container eduvibe-animated-shape' ) ) . '">';
				echo '<div class="eduvibe-page-title">';
					echo '<h1 class="entry-title">';
						echo wp_kses_post( $title ); 
					echo '</h1>';
				echo '</div>';
				echo '<div class="eduvibe-breadcrumb-wrapper">';
					do_action( 'eduvibe_breadcrumb' );
				echo '</div>';

				echo '<div class="shape-dot-wrapper shape-wrapper eduvibe-d-xl-block eduvibe-d-none">';
					echo '<div class="shape-image shape-image-1">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/shape-11-07.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</div>';
					echo '<div class="shape-image shape-image-2">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/shape-01-02.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</div>';
					echo '<div class="shape-image shape-image-3">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/shape-03.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</div>';
					echo '<div class="shape-image shape-image-4">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/shape-13-12.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</div>';
					echo '<div class="shape-image shape-image-5">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/shape-36.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</div>';
					echo '<div class="shape-image shape-image-6">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/shape-05-07.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Setup breadcrumb
 */
add_action( 'eduvibe_breadcrumb', 'eduvibe_breadcrumb_setup', 10 );

if ( ! function_exists( 'eduvibe_breadcrumb_setup' ) ) :
	function eduvibe_breadcrumb_setup() {
		eduvibe_breadcrumb_default();
	}
endif;

/**
 * page title
 */
if ( ! function_exists( 'eduvibe_get_page_title' ) ) :
	function eduvibe_get_page_title() {
		global $post;
		$title = get_the_title();

		if ( is_home() ) :
			$title = apply_filters( 'eduvibe_blog_page_title', __( 'Blog', 'eduvibe' ) );
		elseif ( is_singular( 'post' ) ) :
			$title = get_the_title();
		elseif ( is_archive() ) :
			$title = get_the_archive_title();
		elseif ( is_day() ) :
			$title = get_the_time( get_option( 'date_format' ) );
		elseif ( is_month() ) :
			$title = get_the_time( 'F Y' );
		elseif ( is_year() ) :
			$title = get_the_time( 'Y' );
		elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() && ! is_author() && ! is_search() ) :
			$post_type = get_post_type_object( get_post_type() );
			if ( is_object( $post_type ) ) :
				$title = $post_type->labels->singular_name;
			endif;
		elseif ( is_attachment() ) :
			$title = get_the_title();
		elseif ( is_page() && ! $post->post_parent ) :
			$title = get_the_title();
		elseif ( is_page() && $post->post_parent ) :
			$title = get_the_title();
		elseif ( is_search() ) :
			if ( eduvibe_is_search_has_results() ) :
				$title = __( 'Search results for', 'eduvibe' );
			else :
				$title = __( 'Nothing Found', 'eduvibe' );
			endif;
		elseif ( is_tag() ) :
			$title = __( 'Posts tagged "', 'eduvibe' ). single_tag_title( '', false ) . '"';
		elseif ( is_author() ) :
			global $author;
			$userdata = get_userdata( $author );
			$title = $userdata->display_name;
		elseif ( is_404() ) :
			$title = __( '404: Error Not Found', 'eduvibe' );
		elseif ( is_singular( 'lp_course' ) ) :
			$title = get_the_title();
		elseif ( ( function_exists( 'eduvibe_is_lp_courses' ) && eduvibe_is_lp_courses() ) ) :
			$title = esc_html( get_the_title( learn_press_get_page_id( 'courses' ) ) );
		endif;
		return $title;
	}
endif;


/**
 * Setup breadcrumb
 */
if ( ! function_exists( 'eduvibe_breadcrumb_default' ) ) :
	function eduvibe_breadcrumb_default( $word = '' ) {
	 	echo '<nav class="eduvibe-breadcrumb">';
			echo '<ul class="breadcrumb">';
				if ( ! is_home() ) :
					echo '<li><a href="' . esc_url( get_home_url( '/' ) ) . '">' . __( 'Home', 'eduvibe' ) . '</a></li>';

					if ( is_category() || is_single() ) :
						echo '<li>';
						$category	 = get_the_category();
						$post		 = get_queried_object();
						$postType	 = get_post_type_object( get_post_type( $post ) );
						
						if ( ! empty( $category ) ) :
							echo esc_html( $category[ 0 ]->cat_name ) . '</li>';
						elseif ( defined( 'LP_COURSE_CPT' ) && is_category() ) :
							single_cat_title() . '</li>';
						elseif ( $postType ) :
							echo esc_html( $postType->labels->singular_name ) . '</li>';
						endif;

						if ( is_single() ) :
							echo  '<li>';
								echo esc_html( $word ) != '' ? wp_trim_words( get_the_title(), $word ) : get_the_title();
							echo '</li>';
						endif;
					elseif ( is_page() ) :
						echo '<li>';
							echo esc_html( $word ) != '' ? wp_trim_words( get_the_title(), $word ) : get_the_title();
						echo '</li>';
					endif;
				endif;

				if ( function_exists( 'tutor' ) ) :
					$course_post_type = tutor()->course_post_type;
					
					if ( $course_post_type === 'courses' && is_post_type_archive( 'courses' ) ) :
						echo '<li>' . __( ' Courses', 'eduvibe' ) . '</li>';	
					endif;
				endif;

				if ( is_post_type_archive( 'simple_event' ) ) :
				  	echo '<li>' . __( ' Events', 'eduvibe' ) . '</li>';	
				endif;

				if ( is_post_type_archive( 'simple_team' ) ) :
				  	echo '<li>' . __( ' Team', 'eduvibe' ) . '</li>';	
				endif;

				if ( is_post_type_archive( 'product' ) ) :
				  	echo '<li>' . __( ' Products', 'eduvibe' ) . '</li>';	
				endif;

				if ( is_tag() ) :
					echo '<li>'; 
						echo sprintf( __( 'Posts tagged "%s"', 'eduvibe' ), single_tag_title( '', false ) );
					echo '</li>';
				elseif ( is_day() ) :
					echo '<li>' . __( 'Blogs for', 'eduvibe' ) . ' ';
						the_time( 'F jS, Y' );
					echo '</li>';
				elseif ( is_month() ) :
					echo'<li>' . __( 'Blogs for', 'eduvibe' ) . ' ';
						the_time( 'F, Y' );
					echo'</li>';
				elseif ( is_year() ) :
					echo'<li>' . __( 'Blogs for', 'eduvibe' ) . ' ';
						the_time( 'Y' );
					echo'</li>';
				elseif ( is_author() ) :
					global $author;
					$userdata = get_userdata( $author );
					echo'<li>';
						echo __( 'Articles posted by ', 'eduvibe' ) . $userdata->display_name;
					echo'</li>';
				elseif ( isset( $_GET[ 'paged' ] ) && !empty( $_GET[ 'paged' ] ) ) :
					echo '<li>' . __( 'Blogs', 'eduvibe' ) . '</li>';
				elseif ( is_search() ) :
					echo '<li>' . sprintf( __( 'Search results for "%s"', 'eduvibe' ), get_search_query() ) . '</li>';
				elseif ( is_404() ) :
					echo '<li>' . __( '404: Error Not Found', 'eduvibe' ) . '</li>';
				elseif ( is_home() ) :
					echo '<li>' . __( 'Blog Page', 'eduvibe') . '</li>';
				elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() && ! is_author() && ! is_search() ) :
					$post_type = get_post_type_object( get_post_type() );
					if ( is_object( $post_type ) ) :
						echo '<li>' . $post_type->labels->singular_name . '</li>';
					endif;
				endif;
			echo '</ul>';
		echo '</nav>';
	}
endif;

/**
 * is Search has result
 */
if ( ! function_exists( 'eduvibe_is_search_has_results' ) ) :
	function eduvibe_is_search_has_results() {
	    return 0 != $GLOBALS['wp_query']->found_posts;
	}
endif;

/**
 * Register Google fonts.
 *
 * @return string Google fonts URL for the theme.
 */
if ( ! function_exists( 'eduvibe_main_fonts_url' ) ) :
	function eduvibe_main_fonts_url() {
	    $fonts_url = '';
	    $fonts     = array();
	    $subsets   = '';
	    if ( 'off' !== esc_html_x( 'on', 'Urbanist font: on or off', 'eduvibe' ) ) :
	        $fonts[] = 'Urbanist:300,400,500,600,700,800';
	    endif;

	    if ( $fonts ) :
	        $fonts_url = add_query_arg( array(
	            'family' => urlencode( implode( '|', $fonts ) ),
	            'subset' => urlencode( $subsets ),
	        ), 'https://fonts.googleapis.com/css' );
	    endif;
	    return $fonts_url;
	}
endif;

// Enqueue Google Fonts styles
add_action( 'wp_enqueue_scripts', 'eduvibe_google_fonts_adding' );
if ( ! function_exists( 'eduvibe_google_fonts_adding' ) ) :
	function eduvibe_google_fonts_adding() {
	    wp_enqueue_style( 'eduvibe-main-fonts', eduvibe_main_fonts_url(), array(), EDUVIBE_THEME_VERSION );
	}
endif;


/**
 * Excerpt more
 * @since 1.0.0
 */

if ( ! function_exists( 'eduvibe_excerpt_more' ) ) :
	function eduvibe_excerpt_more( $more ) {
	    return '&#8230;';
	}
endif;
add_filter( 'excerpt_more', 'eduvibe_excerpt_more' );


/**
 * EduVibe Post Archive Support For Theme Option
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'eduvibe_has_archive_theme_option_support' ) ) :
	function eduvibe_has_archive_theme_option_support () {
		$supported = [
			'lp_course',
			'simple_event',
			'product'
		];
		return $supported;
	}
endif;

/**
 * is Blog
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'eduvibe_is_blog' ) ) :
	function eduvibe_is_blog () {
		global $post;
		$posttype = get_post_type( $post );
		return ( ( ( is_archive() ) || ( is_author() ) || ( is_category() ) || ( is_home() ) || ( is_single() ) || ( is_tag() ) || ( is_search() ) ) && ( ! in_array( $posttype, eduvibe_has_archive_theme_option_support() ) ) ) ? true : false ;
	}
endif;

/**
 * Page Layout setup
 *
 * @since 1.0.0
 */
add_filter( 'eduvibe_container_class', 'eduvibe_page_layout_setup' );
if ( ! function_exists( 'eduvibe_page_layout_setup' ) ) :
	function eduvibe_page_layout_setup( $class ) {
		if ( is_page() ) :
			$page_layout = get_post_meta( get_the_ID(), 'eduvibe_page_layout_type', true );
			if ( 'full-width' === $page_layout ) :
            	$class = ' eduvibe-fullwidth-page-container';
            else :
            	$class = ' eduvibe-page-container eduvibe-container';
            endif;
		endif;

		if ( is_singular( 'elementor_library' ) ) :
			$class = ' eduvibe-elementor-fullwidth-page-container';
		endif;

		return $class;
	}
endif;


/**
 * Before Content
 *
 * @since 1.0.0
 */
add_action( 'eduvibe_before_content', 'eduvibe_before_main_content' );
if ( ! function_exists( 'eduvibe_before_main_content' ) ) :
	function eduvibe_before_main_content(){
		$layout_type = '';

		if ( true === eduvibe_is_blog() ) :
			$layout_type = ' eduvibe-row';
		endif;

		if ( is_post_type_archive( 'zoom-meetings' ) ) :
			$layout_type = ' eduvibe-blog-post-archive-style-1 eduvibe-row';
		endif;

		if ( is_page() ) :
			$page_layout = get_post_meta( get_the_ID(), 'eduvibe_page_layout_type', true );
			if ( 'full-width' === $page_layout ) :
            	$layout_type = ' eduvibe-fullwidth-page-row';
            else :
            	$layout_type = ' eduvibe-row';
            endif;
		endif;

		if ( is_404() ) :
			$layout_type = ' eduvibe-row eduvibe-justify-content-center';
		endif;

		if ( is_search() ) :
			$layout_type = ' eduvibe-row';
		endif;
		
		if ( is_singular( 'elementor_library' ) ) :
			$layout_type = '';
		endif;

		if ( function_exists( 'tml_get_action' ) ) :
			if ( tml_get_action() ) :
				$layout_type = ' eduvibe-row eduvibe-justify-content-center';
			endif;
		endif;

		echo '<div class="eduvibe-main-content-inner' . esc_attr( apply_filters( 'eduvibe_main_content_inner', $layout_type ) ) . '">';
	}
endif;


/**
 * After Content
 *
 * @since 1.0.0
 */
add_action( 'eduvibe_after_content', 'eduvibe_after_main_content' );
if ( ! function_exists( 'eduvibe_after_main_content' ) ) :
	function eduvibe_after_main_content(){
		echo '</div>';
	}
endif;


/**
 * Content area class
 *
 * @since 1.0.0
 */
add_filter( 'eduvibe_content_area_class', 'eduvibe_content_wrapper_class' );
if ( ! function_exists( 'eduvibe_content_wrapper_class' ) ) :
	function eduvibe_content_wrapper_class ( $class ) {
		if ( eduvibe_is_blog() ) :
			$blog_layout = eduvibe_get_config( 'blog_archive_layout', 'right-sidebar' );
			$blog_sidebar = eduvibe_get_config( 'blog_archive_sidebar_name', 'blog-sidebar' );
			if ( isset( $_GET['sidebar_disable'] ) ) :
				$blog_sidebar = 'no-sidebar';
			endif;

			if ( ! is_active_sidebar( $blog_sidebar ) ) :
				$class = 'eduvibe-col-lg-12';
			elseif ( 'right-sidebar' === $blog_layout ) :
				$class = 'eduvibe-col-lg-8';
			elseif ( 'left-sidebar' === $blog_layout ) :
				$class = 'eduvibe-col-lg-8 eduvibe-order-2';
			elseif ( 'no-sidebar' === $blog_layout ) :
				$class = 'eduvibe-col-lg-12';
			endif;
		endif;

		if ( is_single() ) :
			$single_layout = eduvibe_get_config( 'blog_single_layout', 'right-sidebar' );
			$single_sidebar = eduvibe_get_config( 'blog_single_sidebar_name', 'blog-sidebar' );
			if ( ! is_active_sidebar( $single_sidebar ) ) :
				$class = 'eduvibe-col-lg-12';
			elseif ( 'right-sidebar' === $single_layout ) :
				$class = 'eduvibe-col-lg-8';
			elseif ( 'left-sidebar' === $single_layout ) :
				$class = 'eduvibe-col-lg-8 eduvibe-order-2';
			elseif ( 'no-sidebar' === $single_layout ) :
				$class = 'eduvibe-col-lg-12';
			endif;
		endif;

		if ( is_single() && 'simple_team' === get_post_type() ) :
			$class = 'eduvibe-col-lg-12';
		endif;

		if ( is_page() ) :
			$content_type = get_post_meta( get_the_ID(), 'eduvibe_page_content_type', true );
			$page_layout  = get_post_meta( get_the_ID(), 'eduvibe_page_layout_type', true );
			$page_sidebar  = get_post_meta( get_the_ID(), 'eduvibe_page_sidebar_name', true );
			if ( isset( $page_layout ) && ! empty( $page_layout ) ) :
				if ( 'full-width' === $page_layout ) :
					$class = 'eduvibe-col-lg-12';
				else :
					if ( ! is_active_sidebar( $page_sidebar ) ) :
						$class = 'eduvibe-col-lg-12';
					elseif ( 'right-sidebar' === $content_type ) :
						$class = 'eduvibe-col-lg-8';
					elseif ( 'left-sidebar' === $content_type ) :
						$class = 'eduvibe-col-lg-8 eduvibe-order-2';
					elseif ( 'no-sidebar' === $content_type ) :
						$class = 'eduvibe-col-lg-12';
					endif;
				endif;
			else : 
				$class = 'eduvibe-col-lg-12';
			endif;
		endif;

		return $class;
	}
endif;


/**
 * Widget area class
 *
 * @since 1.0.0
 */
add_filter( 'eduvibe_widget_area_class', 'eduvibe_widget_wrapper_class' );
if ( ! function_exists( 'eduvibe_widget_wrapper_class' ) ) :
	function eduvibe_widget_wrapper_class ( $class ) {
		if ( eduvibe_is_blog() ) :
			$blog_layout = eduvibe_get_config( 'blog_archive_layout', 'right-sidebar' );
			if ( 'right-sidebar' === $blog_layout ) :
				$class = 'eduvibe-col-lg-4';
			elseif ( 'left-sidebar' === $blog_layout ) :
				$class = 'eduvibe-col-lg-4 eduvibe-order-1';
			elseif ( 'no-sidebar' === $blog_layout ) :
				$class = '';
			endif;
		endif;

		if ( is_single() ) :
			$single_layout = eduvibe_get_config( 'blog_single_layout', 'right-sidebar' );
			if ( 'right-sidebar' === $single_layout ) :
				$class = 'eduvibe-col-lg-4';
			elseif ( 'left-sidebar' === $single_layout ) :
				$class = 'eduvibe-col-lg-4 eduvibe-order-1';
			elseif ( 'no-sidebar' === $single_layout ) :
				$class = '';
			endif;
		endif;

		if ( is_page() ) :
			$content_type = get_post_meta( get_the_ID(), 'eduvibe_page_content_type', true );
			if ( 'right-sidebar' === $content_type ) :
				$class = 'eduvibe-col-lg-4';
			elseif ( 'left-sidebar' === $content_type ) :
				$class = 'eduvibe-col-lg-4 eduvibe-order-1';
			elseif ( 'no-sidebar' === $content_type ) :
				$class = '';
			endif;
		endif;
		
		return $class;
	}
endif;

/**
 * Sidebar Name
 *
 * @since 1.0.0
 */
add_filter( 'eduvibe_get_sidebar', 'eduvibe_sidebar_name' );
if ( ! function_exists( 'eduvibe_sidebar_name' ) ) :
	function eduvibe_sidebar_name ( $sidebar_layout ) {
		if ( eduvibe_is_blog() ) :
			$sidebar_layout = eduvibe_get_config( 'blog_archive_sidebar_name', 'blog-sidebar' );
		endif;
		if ( is_single() ) :
			$sidebar_layout = eduvibe_get_config( 'blog_single_sidebar_name', 'blog-sidebar' );
		endif;
		if ( is_page() ) :
			$sidebar_layout  = get_post_meta( get_the_ID(), 'eduvibe_page_sidebar_name', true );
		endif;
		return $sidebar_layout;
	}
endif;

/**
 *  page footer wrapper class
 *  action located at content-page.php
 *
 * @since 1.0.0
 */
add_action( 'eduvibe_page_footer_wrapper_class', 'eduvibe_page_footer_wrapper_class_setup' );
if ( ! function_exists( 'eduvibe_page_footer_wrapper_class_setup' ) ) :
	function eduvibe_page_footer_wrapper_class_setup(){
		$class = '';		
		if ( is_page() ) :
			$content_type = 'boxed';

			if ( $content_type && $content_type == 'boxed' ) :
				$class = '';
			else :
				$class = ' eduvibe-container';
			endif;
		endif;

		echo esc_attr( $class );
	}
endif;



/**
 *  Author bio
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'eduvibe_author_bio' ) ) :
	function eduvibe_author_bio() {
		$description 	= get_the_author_meta( 'description' );
		$user_url	 	= get_the_author_meta( 'user_url' );

		if ( ! empty( $description ) ) :
			echo '<div class="eduvibe-author-bio">';
				echo '<div class="eduvibe-author-thumb">';
				    echo '<a href="' . esc_url( $user_url ) . '">' . get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'eduvibe_author_thumb_size', 500 ) ) . '</a>';
				echo '</div>';

				echo '<div class="eduvibe-author-details">';
				    echo '<h5>' . esc_html( get_the_author() ) . '</h5>';

					echo '<div class="eduvibe-author-info">';
				    	echo wpautop( wp_kses_post( $description ) );
					echo '</div>';

					echo '<div class="eduvibe-author-social-info">';
						eduvibe_user_social_icons( get_the_author_meta( 'ID' ) );
					echo '</div>';
				echo '</div>';
			echo '</div>';	    
		endif;
	}
endif;



/**
 * Link Pages Bootstrap
 * @author toscha
 * @link http://wordpress.stackexchange.com/questions/14406/how-to-style-current-page-number-wp-link-pages
 * @param  array $args
 * @return void
 * Modification of wp_link_pages() with an extra element to highlight the current page.
 */

if ( ! function_exists( 'eduvibe_link_pages' ) ):
	function eduvibe_link_pages( $args = array () ) {
	    $defaults = array(
			'before'         => '<nav class="eduvibe-paignation ddd"><ul class="eduvibe-custom-pagination">',
			'after'          => '</ul></nav>',
			'before_link'    => '<li>',
			'after_link'     => '</li>',
			'current_before' => '<li class="active">',
			'current_after'  => '</li>',
			'link_before'    => '',
			'link_after'     => '',
			'pagelink'       => '%',
			'echo'           => 1
	    );
	    $r = wp_parse_args( $args, $defaults );
	    $r = apply_filters( 'wp_link_pages_args', $r );
	    extract( $r, EXTR_SKIP );

	    global $page, $numpages, $multipage, $more, $pagenow;
	    if ( ! $multipage ) :
	        return;
	    endif;

	    $output = $before;
	    for ( $i = 1; $i < ( $numpages + 1 ); $i++ ) :
	        $j       = str_replace( '%', $i, $pagelink );
	        $output .= ' ';
	        if ( $i != $page || ( ! $more && 1 == $page ) ) :
	            $output .= "{$before_link}" . _wp_link_page( $i ) . "{$link_before}{$j}{$link_after}</a>{$after_link}";
	        else :
	            $output .= "{$current_before}{$link_before}<span>{$j}</span>{$link_after}{$current_after}";
	        endif;
	    endfor;
	    print wp_kses_post( $output ) . wp_kses_post( $after );
	}
endif;


/**
 * WordPress Bootstrap pagination
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'eduvibe_numeric_pagination' ) ) :
    function eduvibe_numeric_pagination( $args = array() ) {
        
        $defaults = array(
            'range'           => 4,
            'custom_query'    => FALSE,
            'previous_string' => '<span class="eduvibe-pagination-icon ri-arrow-drop-left-line"></span>',
            'next_string'     => '<span class="eduvibe-pagination-icon ri-arrow-drop-right-line"></span>',
            'before_output'   => '<nav class="eduvibe-pagination-wrapper"><ul class="page-numbers">',
            'after_output'    => '</ul></nav>'
        );
        
        $args = wp_parse_args( 
            $args, 
            apply_filters( 'wp_bootstrap_pagination_defaults', $defaults )
        );
        
        $args['range'] = (int) $args['range'] - 1;
        if ( !$args['custom_query'] )
            $args['custom_query'] = $GLOBALS['wp_query'];
        $count = (int) $args['custom_query']->max_num_pages;
        $page  = intval( get_query_var( 'paged' ) );
        $ceil  = ceil( $args['range'] / 2 );
        
        if ( $count <= 1 )
            return FALSE;
        
        if ( !$page )
            $page = 1;
        
        if ( $count > $args['range'] ) :
            if ( $page <= $args['range'] ) :
                $min = 1;
                $max = $args['range'] + 1;
            elseif ( $page >= ($count - $ceil) ) :
                $min = $count - $args['range'];
                $max = $count;
            elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) :
                $min = $page - $ceil;
                $max = $page + $ceil;
            endif;
        else :
            $min = 1;
            $max = $count;
        endif;
        
        $echo = '';
        $previous = intval($page) - 1;
        $previous = esc_attr( get_pagenum_link($previous) );
        
        if ( $previous && (1 != $page) )
        	$echo .= sprintf ( '<li><a class="page-numbers" href="%s" title="%s">%s</a></li>', esc_url( $previous ), __( 'previous', 'eduvibe' ), $args['previous_string'] );
        
        if ( ! empty( $min ) && ! empty( $max ) ) :
            for( $i = $min; $i <= $max; $i++ ) :
                if ( $page == $i ) :
                    $echo .= sprintf ( '<li class="active"><span class="page-numbers current">%s</span></li>', esc_html( (int)$i ) );
                else :
                    $echo .= sprintf( '<li><a class="page-numbers" href="%s">%2d</a></li>', esc_attr( get_pagenum_link($i) ), $i );
                endif;
            endfor;
        endif;
        
        $next = intval($page) + 1;
        $next = esc_attr( get_pagenum_link( $next ) );
        if ($next && ($count != $page) )
        	$echo .= sprintf ( '<li><a class="page-numbers" href="%s" title="%s">%s</a></li>', esc_url( $next ), __( 'next', 'eduvibe' ), $args['next_string'] );
        
        if ( isset($echo) )
            echo wp_kses_post( $args['before_output'] ) . $echo . wp_kses_post( $args['after_output'] );
    }
endif;

/**
 * Pagination RTL support
 *
 * @since 1.0.0
 */

add_filter( 'wp_bootstrap_pagination_defaults', 'eduvibe_pagination_rtl_support' );

if ( ! function_exists( 'eduvibe_pagination_rtl_support' ) ) :
	function eduvibe_pagination_rtl_support($args) {
	  	if ( is_rtl() ) :
		   $args['next_string']   = '<span class="eduvibe-pagination-icon ri-arrow-drop-left-line"></span>';
		   $args['previous_string']  = '<span class="eduvibe-pagination-icon ri-arrow-drop-right-line"></span>';
		endif;
		return $args;
	}
endif;


/**
 * Comment list walker
 * A custom WordPress comment walker class to implement the Bootstrap 3 Media object in wordpress comment list.
 * @package     WP Bootstrap Comment Walker
 * @version     1.0.0
 * @author      Edi Amin <to.ediamin@gmail.com>
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link        https://github.com/ediamin/wp-bootstrap-comment-walker
 */

if ( ! class_exists( 'EduVibe_Comment_Walker' ) ) :
	class EduVibe_Comment_Walker extends Walker_Comment {
		/**
		 * Output a comment in the HTML5 format.
		 *
		 * @access protected
		 * @since 1.0.0
		 *
		 * @see wp_list_comments()
		 *
		 * @param object $comment Comment to display.
		 * @param int    $depth   Depth of comment.
		 * @param array  $args    An array of arguments.
		 */
		protected function html5_comment( $comment, $depth, $args ) {
			$tag       = ( 'div' === $args['style'] ) ? 'div' : 'li';
			$commenter = wp_get_current_commenter();
		    if ( $commenter['comment_author_email'] ) :
		        $moderation_note = __( 'Your comment is awaiting moderation.', 'eduvibe' );
		    else :
		        $moderation_note = __( 'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.', 'eduvibe' );
		    endif;
			?>		
			<<?php echo esc_attr($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent eduvibe-media eduvibe-comment-item' : 'eduvibe-media eduvibe-comment-item' ); ?>>

			<article id="comment-<?php comment_ID(); ?>" class="eduvibe-single-comment <?php echo esc_attr( get_avatar($comment) ? 'eduvibe-comment-has-avatar' : 'eduvibe-comment-no-avatar' ); ?>">
				<div class="eduvibe-comment-each-item">
					<?php if ( get_avatar( $comment ) && 0 != $args['avatar_size'] ): ?>
						<div class="eduvibe-comment-avatar">
							<a href="<?php echo esc_url( esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ); ?>" class="eduvibe-media-object">
								<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="eduvibe-media-body">
						<div class="eduvibe-comment-header">
							<h4 class="eduvibe-media-heading">
								<?php echo get_comment_author_link(); ?>
							</h4>
							<span class="comment-metadata">
								<a class="eduvibe-comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
									<time datetime="<?php esc_attr( comment_time( 'c' ) ); ?>">
										<?php 
											printf(
												esc_html__( '%1$s at %2$s', 'eduvibe' ), get_comment_date(), get_comment_time()
											);

											edit_comment_link( esc_html__( '(Edit)', 'eduvibe' ), '  ', '' );
										?>
									</time>
								</a>
							</span>
						</div>						

						<?php if ( '0' == $comment->comment_approved ) : ?>
							<p class="comment-awaiting-moderation label label-info"><?php echo esc_html( $moderation_note ); ?></p>
						<?php endif; ?>

						<div class="comment-content">
							<?php comment_text(); ?>
						</div>
						<div class="eduvibe-comment-bottom-part">
							<?php 
								echo get_comment_reply_link(
									array(
										'depth'      => $depth,
										'max_depth'  => $args['max_depth'],
										'reply_text' => sprintf( '<i class="fas fa-reply-all"></i> %s', __( 'Reply', 'eduvibe' ) )
									),
									$comment->comment_ID,
									$comment->comment_post_ID
								);
							?>
						</div>	
					</div>	
				</div>
			</article>	
			<?php
		}	
	}
endif;

/**
 * Custom list of comments for the theme.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'eduvibe_comments_template' ) ) :
	function eduvibe_comments_template() {
		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$args     = array(
			'class_form'         => 'eduvibe-comment-form form media-body',
			'class_submit'       => 'eduvibe-comment-btn',
			'title_reply_before' => '<h3 class="eduvibe-title">',
			'title_reply'		 => __( 'Leave a Reply', 'eduvibe' ),
			'label_submit'		 => __( 'Post A Comment', 'eduvibe' ),
			'title_reply_after'  => '</h3>',
			'must_log_in'        => '<p class="must-log-in">' .
									sprintf(
										wp_kses(
											/* translators: %s is Link to login */
											__( 'You must be <a href="%s">logged in</a> to post a comment.', 'eduvibe' ), array(
												'a' => array(
													'href' => array()
												)
											)
										), esc_url( wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) )
									) . '</p>',
			'fields'             => 
			apply_filters(
				'comment_form_default_fields', array(

					'author' => '<div class="eduvibe-row"><div class="eduvibe-col-md-6 "><div class="form-group eduvibe-comment-field label-floating is-empty"><input id="author" name="author" class="form-control" type="text"' . $aria_req . ' placeholder="' . __( 'Name', 'eduvibe' ) . ( $req ? '*' : '' ) . '" /></div></div>',

					'email'  => '<div class="eduvibe-col-md-6"><div class="form-group eduvibe-comment-field label-floating is-empty"><input id="email" name="email" class="form-control" type="email"' . $aria_req . ' placeholder="' . __( 'Email', 'eduvibe' ) . ( $req ? '*' : '' ) . '" /></div></div>',

					'url'    => '<div class="eduvibe-col-lg-12"><div class="form-group eduvibe-comment-field label-floating is-empty"><input id="url" name="url" class="form-control" type="url"' . $aria_req . ' placeholder="' . __( 'Website', 'eduvibe' ) .'" /></div></div> </div>',
				)
			),
			'comment_field'      => '<div class="form-group eduvibe-comment-field label-floating is-empty"><textarea rows="8" id="comment" name="comment" class="form-control" cols="20" aria-required="true"  placeholder="' . __( 'Comment', 'eduvibe' ) .'"></textarea></div>'
		);

		return $args;
	}
endif;

/**
 * Move Comment Field & Cookie Consent to Bottom
 *
 * @since 1.0.0
 */
function eduvibe_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    $cookies_field = $fields['cookies'];
    unset( $fields['comment'] );
    unset( $fields['cookies'] );
    $fields['comment'] = $comment_field;
    $fields['cookies'] = $cookies_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'eduvibe_move_comment_field_to_bottom' );

/**
 *  Body Classes
 *
 * @since 1.0.0
 */
add_filter( 'body_class', 'eduvibe_get_body_classes' );

if ( ! function_exists( 'eduvibe_get_body_classes' ) ) :
	function eduvibe_get_body_classes( $classes ) {
		global $post;
		if ( is_page() && is_object( $post ) ) :
			$classes[]                 = 'eduvibe-page-content';
			$page_layout               = get_post_meta( get_the_ID(), 'eduvibe_page_layout_type', true );
			$content_type              = get_post_meta( get_the_ID(), 'eduvibe_page_content_type', true );
			$breadcrumb_visibility     = get_post_meta( get_the_ID(), 'eduvibe_page_breadcrumb', true );
			$breadcrumb_show_framework = eduvibe_get_config( 'show_page_breadcrumb', true );

			$extra_class = get_post_meta( $post->ID, 'eduvibe_page_extra_class', true );
			if ( ! empty( $extra_class ) ) :
				$classes[] = trim( $extra_class );
			endif;

			if( get_post_meta( $post->ID, 'eduvibe_page_header_transparent', true ) && get_post_meta( $post->ID, 'eduvibe_page_header_transparent', true ) == 'yes' ) :
				$classes[] = 'eduvibe-header-transparent-enable';
			endif;

			if ( ! is_front_page() ) :
				if ( 'disable' !== $breadcrumb_visibility ) :
					if ( ( 'enable' === $breadcrumb_visibility ) || ( isset( $breadcrumb_show_framework ) && ! empty( $breadcrumb_show_framework ) ) ) :
						$classes[] = 'eduvibe-page-breadcrumb-enable';
					else :
						$classes[] = 'eduvibe-page-breadcrumb-disable';
					endif;
				else :
					$classes[] = 'eduvibe-page-breadcrumb-disable';
				endif;
			else :
				$classes[] = 'eduvibe-page-breadcrumb-disable';
			endif;

			if ( 'full-width' === $page_layout ) :
				$classes[] = 'eduvibe-page-fullwidth';
			else :
				$classes[] = 'eduvibe-page-boxed';
			endif;

			if ( isset( $content_type ) && ! empty( $content_type ) ) :
				if ( 'no-sidebar' === $content_type ) :
					$classes[] = 'eduvibe-page-sidebar-disable';
				else :
					$classes[] = 'eduvibe-page-sidebar-enable';
				endif;
			else :
				$classes[] = 'eduvibe-page-sidebar-disable';
			endif;

		elseif ( is_singular() || is_category() ||is_tax() || is_home() || is_search() || eduvibe_is_blog() ) :
			$show = eduvibe_get_config( 'show_blog_breadcrumb', true );
			if ( ! $show ) :
				$classes[] = 'eduvibe-page-breadcrumb-disable';
			endif;

		elseif ( is_singular( 'simple_event' ) || is_post_type_archive( 'simple_event' ) || is_tax( 'simple_event_category' )  || is_tax( 'simple_event_tags' ) ) :
			$show = eduvibe_get_config( 'show_event_breadcrumb', true );
			if ( ! $show ) :
				$classes[] = 'eduvibe-page-breadcrumb-disable';
			endif;

		elseif ( function_exists( 'eduvibe_is_lp_courses' ) && eduvibe_is_lp_courses() ) :
			$show = eduvibe_get_config( 'show_course_breadcrumb', true );
			if ( ! $show ) :
				$classes[] = 'eduvibe-page-breadcrumb-disable';
			endif;
			
		elseif ( eduvibe_is_woocommerce_activated() && is_woocommerce() ) :
			$show = eduvibe_get_config( 'show_shop_breadcrumb', true );
			if ( ! $show ) :
				$classes[] = 'eduvibe-page-breadcrumb-disable';
			endif;
    	endif;

	    return $classes;
	}
endif;


/**
 * Simple Event Archive Settings
 *
 * @link https://wpsites.net/wordpress-tips/add-pagination-to-custom-post-type-archive-pages/
 *
 * @since 1.0.0
 */
add_action( 'pre_get_posts', 'eduvibe_simple_event_archive_items' );
function eduvibe_simple_event_archive_items( $query ) {
	$items = eduvibe_get_config( 'simple_event_archive_page_items', '10' );
	if ( $query->is_main_query() && ! is_admin() && ( is_post_type_archive( 'simple_event' ) || is_tax( 'simple_event_category' ) ) ) :
		$query->set( 'posts_per_page', $items );
	endif;
}

/**
 * Simple Event Google Map API
 *
 * @since 1.0.0
 */
function eduvibe_event_map_api_key($key) {
    $key = eduvibe_get_config( 'google_map_api_key' );
    return $key;
}
add_filter( 'eduvibe_map_api_key', 'eduvibe_event_map_api_key' );

/**
 * EduVibe Supported LMS Builders
 *
 * @return boolean
 */
function eduvibe_is_lms_courses() {
	if ( ( function_exists( 'eduvibe_is_lp_courses' ) && eduvibe_is_lp_courses() ) || is_singular( 'lp_course' ) || is_post_type_archive( 'lp_course' ) || is_tax( 'course_category' ) || is_tax( 'course_tag' ) ) : 
		return true;
	elseif ( is_singular( 'courses' ) || is_post_type_archive( 'courses' ) || is_tax( 'course-category' ) || is_tax( 'course-tag' ) ) :
		return true;
	elseif ( is_singular( 'sfwd-courses' ) || is_post_type_archive( 'sfwd-courses' ) || is_tax( 'ld_course_category' ) || is_tax( 'ld_course_tag' ) ) :
		return true;
    endif;
    return false;

}

/**
 * Zoom Single Metting Actions
 *
 * @return boolean
 */
remove_action( 'vczoom_before_main_content', 'video_conference_zoom_output_content_start', 10 );
remove_action( 'vczoom_after_main_content', 'video_conference_zoom_output_content_end', 10 );
remove_action( 'vczoom_single_content_left', 'video_conference_zoom_featured_image', 10 );
add_action( 'vczoom_single_content_left', 'eduvibe_video_conference_zoom_featured_image', 10 );
add_action( 'vczoom_single_content_left', 'eduvibe_video_conference_zoom_title', 15 );
add_action( 'vczoom_single_content_left', 'eduvibe_video_conference_zoom_footer', 30 );

function eduvibe_video_conference_zoom_featured_image() {
	$thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	if ( isset( $thumb_src ) && ! empty( $thumb_src ) ) :
	    $thumb_url = $thumb_src[0];
	else :
	    $thumb_url = get_template_directory_uri() . '/assets/images/no-image-found.png';
	endif;
	echo '<div class="eduvibe-single-event-thumbnail" style="background-image: url(' . esc_url( $thumb_url ) . ')"></div>';
}

function eduvibe_video_conference_zoom_title() {
	the_title( '<h1 class="title">', '</h1>' );
}

function eduvibe_video_conference_zoom_footer() {
	$event_categories = eduvibe_category_by_id( get_the_ID(), 'zoom-meeting', false );
	echo '<div class="eduvibe-cat-social-share">';
		if( ! empty( $event_categories ) ) :
			echo '<div class="eduvibe-single-event-category">';
				echo wp_kses_post( $event_categories );
			echo '</div>';
		endif;
		if ( eduvibe_get_config( 'single_event_social_share', true ) ) :
			echo '<div class="eduvibe-single-post-social-share">';
				echo '<span>' . __( 'Share: ', 'eduvibe' ) . '</span>';
				get_template_part( 'template-parts/social', 'share' );
			echo '</div>';
		endif;
	echo '</div>';
}


/**
 * Course Ajax Search
 */
add_action( 'wp_ajax_nopriv_eduvibe_ajax_course_search','eduvibe_ajax_course_search' );
add_action( 'wp_ajax_eduvibe_ajax_course_search','eduvibe_ajax_course_search' );

if ( ! function_exists( 'eduvibe_ajax_course_search' ) ) :
	function eduvibe_ajax_course_search() {
		$args = array (
			'post_type' 	 => apply_filters( 'eduvibe_course_search_post_type', 'lp_course' ),
			'post_status' 	 => 'publish',
			'order' 		 => 'DESC',
			'orderby' 		 => 'date',
			's' 			 => $_POST['term'],
			'posts_per_page' => apply_filters( 'eduvibe_course_search_number_of_post', 10 )
		);
		 
		$query = new WP_Query( $args );
		 
		if ( $query->have_posts() ) :
			echo '<ul>';
				while ( $query->have_posts() ) :
					$query->the_post();
					printf( '<li><a href="%s">%s</a></li>', esc_url( get_the_permalink() ), esc_html( get_the_title() ) );
				endwhile;
			echo '</ul>';
		else :
			printf( '<ul><li><a href="#">%s</a></li></ul>', __( 'No Course Found.', 'eduvibe' ) );
		endif;

		wp_reset_postdata();
		exit;
	}
endif;

// Define home url for ajax course search
if ( ! function_exists( 'eduvibe_ajax_course_search_base' ) ) :
	function eduvibe_ajax_course_search_base(){
		?>
			<script type="text/javascript">var eduvibe_home_url = "<?php echo esc_url( home_url() ); ?>";</script>
		<?php
	}
endif;
add_action( 'wp_footer', 'eduvibe_ajax_course_search_base' );

/**
 *  Add Preloader Class at Body Classes
 *
 * @since 1.0.0
 */
add_filter( 'body_class', 'eduvibe_add_preloader_class_at_body' );

if ( ! function_exists( 'eduvibe_add_preloader_class_at_body' ) ) :
	function eduvibe_add_preloader_class_at_body( $classes ) {
		$preloader = eduvibe_get_config( 'preloader', false );
		if ( $preloader ) :
			$preloader_type = eduvibe_get_config( 'preloader_type', '1' );
			$classes[] = 'eduvibe-preloader-type-' . $preloader_type;
		endif;
		return $classes;
	}
endif;

/**
 * Estimated Reading Time
 *
 * @return void
 */
if( ! function_exists( 'eduvibe_post_estimated_reading_time' ) ) :
	function eduvibe_post_estimated_reading_time( $with_second = false ) {
		global $post;
		$words_per_min = apply_filters( 'eduvibe_words_read_per_min', 200 );
		// get the content
		$the_content = $post->post_content;
		// count the number of words
		$words = str_word_count( strip_tags( $the_content ) );
		// rounding off and deviding per 200( $words_per_min ) words per minute
		$minute = floor( $words / $words_per_min );
		// rounding off to get the seconds
		$second = floor( $words % $words_per_min / ( $words_per_min / 60 ) );
		// calculate the amount of time needed to read

		$estimate = $minute . ' ' . __( 'Min', 'eduvibe' ) . ( $minute == 1 ? '' : __( 's', 'eduvibe' ) );

		if ( $minute < 1 ) :
			$estimate = $second . ' ' . __( 'Sec', 'eduvibe' ) . ( $second == 1 ? '' : __( 's', 'eduvibe' ) );
		endif;

		if ( $with_second ) :
			$estimate = $minute . ' ' . __( 'Min', 'eduvibe' ) . ( $minute == 1 ? '' : __( 's', 'eduvibe' ) ) . ', ' . $second . ' ' . __( 'Sec', 'eduvibe' ) . ( $second == 1 ? '' : __( 's', 'eduvibe' ) );
		endif;
		
		return $estimate;
	}
endif;

/**
 * Required Plugins
 */
add_action( 'tgmpa_register', 'eduvibe_load_required_plugins' );

if( ! function_exists( 'eduvibe_load_required_plugins' ) ) :
	function eduvibe_load_required_plugins() {

		$plugins = array(
			array(
				'name'      => __( 'Classic Editor', 'eduvibe' ),
				'slug'      => 'classic-editor',
				'required'  => false
			),
			array(
				'name'      => __( 'CMB2', 'eduvibe' ),
				'slug'      => 'cmb2',
				'required'  => true
			),
			array(
				'name'      => __( 'Contact Form 7', 'eduvibe' ),
				'slug'      => 'contact-form-7',
				'required'  => false
			),
			array(
				'name'      => __( 'EduVibe Core', 'eduvibe' ),
				'slug'      => 'eduvibe-core',
				'source'    => get_template_directory() . '/lib/plugins/eduvibe-core.zip',
				'required'  => true,
				'version'   => '1.0.0'
			),
			array(
				'name'      => __( 'Elementor', 'eduvibe' ),
				'slug'      => 'elementor',
				'required'  => true
			),
			array(
				'name'      => __( 'LearnPress', 'eduvibe' ),
				'slug'      => 'learnpress',
				'required'  => false
			),
			array(
				'name'      => __( 'LearnPress - Course Review', 'eduvibe' ),
				'slug'      => 'learnpress-course-review',
				'required'  => false
			),
			array(
				'name'      => __( 'LearnPress – Course Wishlist', 'eduvibe' ),
				'slug'      => 'learnpress-wishlist',
				'required'  => false
			),
			array(
				'name'      => __( 'One Click Demo Import', 'eduvibe' ),
				'slug'      => 'one-click-demo-import',
				'required'  => false
			),
			array(
				'name'      => __( 'Redux Framework', 'eduvibe' ),
				'slug'      => 'redux-framework',
				'required'  => true
			),
			array(
				'name'      => __( 'WooCommerce', 'eduvibe' ),
				'slug'      => 'woocommerce',
				'required'  => false
			),
			array(
				'name'      => __( 'YITH WooCommerce Quick View', 'eduvibe' ),
				'slug'      => 'yith-woocommerce-quick-view',
				'required'  => false
			)
		);

		tgmpa( $plugins );
	}
endif;