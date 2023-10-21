<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package EduVibe
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$sidebar = apply_filters( 'eduvibe_get_sidebar', 'sidebar-default' );

if ( ! is_active_sidebar( $sidebar ) || isset( $_GET['sidebar_disable'] ) ) :
	return;
endif;

echo '<aside id="secondary" class="widget-area ' . esc_attr( apply_filters( 'eduvibe_widget_area_class', 'eduvibe-col-lg-4' ) ) . '">';
	do_action( 'eduvibe_sidebar_before' );
	dynamic_sidebar( $sidebar );
	do_action( 'eduvibe_sidebar_after' );
echo '</aside>';
