<?php
/**
 * Template for displaying content of course without header and footer
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit();

/**
 * If course has set password
 */
if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}

$show_related_course = eduvibe_get_config( 'lp_related_courses', true );
$course_details_style = eduvibe_get_config( 'lp_course_details_style', 1 );

echo '<div class="main-image">';
	the_post_thumbnail( 'full' );
echo '</div>';

/**
 * LP Hook
 */
do_action( 'learn-press/before-single-course' );

echo '<div class="eduvibe-row">';
	echo '<div id="learn-press-course" class="course-summary eduvibe-col-xl-8 eduvibe-col-lg-7">';
		echo '<div class="course-details-content course-details-style-' . esc_attr( $course_details_style ). '">';
			echo '<div class="content-details-top">';
				echo '<div class="author-thumb">';
					echo get_avatar( get_the_author_meta( 'ID' ), 40 );
					echo '<span class="author-title">';
						echo '<span class="author-by">';
							_e( 'By', 'eduvibe' );
						echo '</span>';
						the_author();
					echo '</span>';
				echo '</div>';
				echo '<div class="course-rating">';
					eduvibe_lp_course_ratings();
				echo '</div>';
			echo '</div>';

			echo '<h3 class="course-heading">';
				the_title();
			echo '</h3>';

			if ( $course_details_style == 2 ) :
				$tabs = learn_press_get_course_tabs();
				if ( empty( $tabs ) ) :
					return;
				endif;
				
				echo '<div class="course-tab-panels">';
					foreach ( $tabs as $key => $tab ) :
						echo '<div class="course-tab-panel-' . esc_attr( $key ) . ' course-each-tab-panel">';
							if ( isset( $tab['callback'] ) && is_callable( $tab['callback'] ) ) :
								call_user_func( $tab['callback'], $key, $tab );
							else :
								do_action( 'learn-press/course-tab-content', $key, $tab );
							endif;
						echo '</div>';
					endforeach;
				echo '</div>';
			else :
				/**
				 * @since 3.0.0
				 *
				 * @called single-course/content.php
				 * @called single-course/sidebar.php
				 */
				do_action( 'learn-press/single-course-summary' );
			endif;
		echo '</div>';
	echo '</div>';

	echo '<div class="eduvibe-col-xl-4 eduvibe-col-lg-5">';
		eduvibe_lp_single_course_content_right_side_wrapper();
	echo '</div>';
echo '</div>';

if ( $show_related_course ) :
	learn_press_get_template( 'custom/courses-releated.php' );
endif;

/**
 * LP Hook
 */
do_action( 'learn-press/after-single-course' );
