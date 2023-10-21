<?php
/**
 * Template for displaying instructor of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/instructor.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.3.0
 */

defined( 'ABSPATH' ) || exit();

$course = learn_press_get_course();
if ( ! $course ) {
	return;
}
$user = $course->get_instructor();
$user_id = $user->get_id();

do_action( 'learn-press/before-single-course-instructor' );

echo '<div class="eduvibe-course-author-wrapper">';
	echo '<div class="eduvibe-course-author-thumb">';
		echo get_avatar( get_the_author_meta( 'ID' ), 350 );
		// echo wp_kses_post( $course->get_instructor()->get_profile_picture( null, '350' ) );
	echo '</div>';

	echo '<div class="eduvibe-course-author-details">';
		echo '<div class="eduvibe-author-bio-name">';
			echo wp_kses_post( $course->get_instructor_html() );
		echo '</div>';

		echo '<div class="eduvibe-author-bio-designation">';
			echo '<span>' . wp_kses_post( get_the_author_meta( 'eduvibe_job', $user_id ) ) . '</span>';
		echo '</div>';

		echo '<div class="eduvibe-author-bio-details">';
			echo wp_kses_post( $course->get_author()->get_description() );
		echo '</div>';
		
		echo '<div class="eduvibe-author-social-info">';
            eduvibe_user_social_icons( $user_id );
        echo '</div>';
	echo '</div>';
echo '</div>';
do_action( 'learn-press/after-single-course-instructor' );

