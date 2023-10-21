<?php

/**
 * Template for displaying the list of course content is in wishlist.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/wishlist/wishlist-content.php.
 *
 * @author ThimPress
 * @package LearnPress/Wishlist/Templates
 * @version 3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

global $post;
echo '<li id="learn-press-tab-wishlist-course-'. esc_attr( $post->ID ) . '" class="course eduvibe-col-md-6" data-context="tab-wishlist">';
    learn_press_get_template( 'custom/course-block/blocks.php' );
echo '</li>';
?>
