<?php
/**
 * Template part for displaying sfwd-courses single( details ) content in single.php.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EduVibe
 * @since   1.0.0
 */
while ( have_posts() ) :
    the_post();
    the_content();
endwhile;