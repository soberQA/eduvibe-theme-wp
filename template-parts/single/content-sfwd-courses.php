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
    eduvibe_ld_single_course_thumbnail();
    echo '<div class="eduvibe-course-content-wrapper">';
        echo '<div class="eduvibe-course-content-left-side-wrapper">';
            the_content();
        echo '</div>';
        echo '<div class="eduvibe-course-content-right-side-wrapper">';
            echo '<div class="eduvibe-course-details-right-inner">';
                eduvibe_ld_course_preview();
                eduvibe_ld_course_meta_data();
            echo '</div>';
        echo '</div>';
    echo '</div>';
    eduvibe_ld_single_related_course_wrapper();
endwhile;