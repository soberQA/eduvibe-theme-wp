<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package EduVibe
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php 

	if ( function_exists( 'wp_body_open' ) ) :
		wp_body_open();
	endif;

	$preloader = eduvibe_get_config( 'preloader', false );
	if ( $preloader ) : 
		get_template_part( 'template-parts/preloaders/preloader' );
	endif;
	echo '<div id="page" class="site">';
		echo '<a class="skip-link screen-reader-text" href="#content">' . __( 'Skip to content', 'eduvibe' ) . '</a>';
		get_template_part( 'template-parts/headers/default' );
		echo '<div id="content" class="site-content">';
			echo '<div class="site-content-inner' . esc_attr( apply_filters( 'eduvibe_container_class', ' eduvibe-container' ) ) . '">';
				do_action( 'eduvibe_before_content' );
