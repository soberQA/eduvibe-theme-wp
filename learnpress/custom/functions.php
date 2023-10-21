<?php

remove_action( 'admin_footer', 'learn_press_footer_advertisement', - 10 );

// remove breadcrumbs
remove_action( 'learn-press/before-main-content', LP()->template( 'general' )->func( 'breadcrumb' ) );
remove_action( 'learn-press/before-main-content', 'learn_press_breadcrumb', 10 );
remove_action( 'learn-press/before-main-content', 'learn_press_search_form', 15 );

remove_all_actions( 'learn-press/course-content-summary', 10 );
remove_all_actions( 'learn-press/course-content-summary', 15 );
remove_all_actions( 'learn-press/course-content-summary', 30 );
remove_all_actions( 'learn-press/course-content-summary', 35 );
remove_all_actions( 'learn-press/course-content-summary', 40 );
remove_all_actions( 'learn-press/course-content-summary', 80 );
// remove course sidebar
remove_all_actions( 'learn-press/course-content-summary', 85 );
remove_all_actions( 'learn-press/course-content-summary', 100 );

remove_action( 'learn-press/after-courses-loop-item', 'learn_press_course_loop_item_buttons', 35 );
remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_price', 20 );
remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_instructor', 25 );
remove_action( 'learn-press/courses-loop-item-title', 'learn_press_courses_loop_item_thumbnail', 10 );
remove_action( 'learn-press/courses-loop-item-title', 'learn_press_courses_loop_item_title', 15 );

/* 
 * Course Sidebar Button 
 */
if ( class_exists( 'LP_Prere_Course_Hooks' ) ) :
	$eduvibe_lp_prerequisite_plugin = LP_Prere_Course_Hooks::get_instance();
	remove_action( 'learn-press/course-buttons', [$eduvibe_lp_prerequisite_plugin, 'check_condition'], 1 );
endif;

/* 
 * Remove Wishlist Button From Sidebar 
 */
// if ( class_exists( 'LP_Addon_Wishlist' ) ) :
// 	remove_action( 'learn-press/after-course-buttons', 'LP_Addon_Wishlist', 'wishlist_button', 100 );
// endif;

add_action( 'eduvibe_course_sidebar_lp_button', LearnPress::instance()->template( 'course' )->func( 'course_enroll_button' ), 5 );
add_action( 'eduvibe_course_sidebar_lp_button', LearnPress::instance()->template( 'course' )->func( 'course_purchase_button' ), 10 );
add_action( 'eduvibe_course_sidebar_lp_button', LearnPress::instance()->template( 'course' )->func( 'course_external_button' ), 15 );
add_action( 'eduvibe_course_sidebar_lp_button', LearnPress::instance()->template( 'course' )->func( 'button_retry' ), 20 );
add_action( 'eduvibe_course_sidebar_lp_button', LearnPress::instance()->template( 'course' )->func( 'course_continue_button' ), 25 );
add_action( 'eduvibe_course_sidebar_lp_button', LearnPress::instance()->template( 'course' )->func( 'course_finish_button' ), 30 );

/**
 * LearnPress specific scripts & stylesheets.
 *
 * @return void
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'eduvibe_lp_scripts' ) ) :
	function eduvibe_lp_scripts() {
		wp_enqueue_style( 'eduvibe-lp-style', esc_url( get_template_directory_uri() . '/assets/css/learnpress.css' ), array( 'learnpress' ), EDUVIBE_THEME_VERSION );

		if ( is_singular( LP_COURSE_CPT ) ) :
			wp_enqueue_style( 'jquery-fancybox' );
			wp_enqueue_script( 'jquery-fancybox' );
		endif;
	}
endif;
add_action( 'wp_enqueue_scripts', 'eduvibe_lp_scripts' );

/**
 * Course Page Container Class
 *
 * @since 1.0.0
 */
add_filter( 'eduvibe_container_class', 'eduvibe_lp_course_container_class' );
if ( ! function_exists( 'eduvibe_lp_course_container_class' ) ) :
	function eduvibe_lp_course_container_class ( $class ) {
		if ( is_singular( LP_COURSE_CPT ) ) :
			return ' eduvibe-container eduvibe-lp-course-details-page';
		else :
			return $class;
		endif;
	}
endif;

/**
 * Content area class
 */
add_filter( 'eduvibe_content_area_class', 'eduvibe_lp_content_area_class' );
if ( ! function_exists( 'eduvibe_lp_content_area_class' ) ) :
	function eduvibe_lp_content_area_class ( $class ) {

		if ( is_post_type_archive( LP_COURSE_CPT ) || is_tax( 'course_category' ) ) :

			$course_layout = 'full_width';

			if ( 'right' === $course_layout ) :
				$class = 'eduvibe-col-lg-9';
			elseif ( 'left' === $course_layout ) :
				$class = 'eduvibe-col-lg-9 eduvibe-order-1';
			elseif ( 'full_width' === $course_layout ) :
				$class = 'eduvibe-col-lg-12';
			endif;
		endif;

		if ( is_singular( LP_COURSE_CPT ) ) :
			
			$single_course_layout = 'full_width';

			if ( 'right' ===  $single_course_layout ) :
				$class = 'eduvibe-col-lg-9';
			elseif ( 'left' === $single_course_layout ) :
				$class = 'eduvibe-col-lg-9 eduvibe-order-1';
			elseif ( 'full_width' === $single_course_layout ) :
				$class = 'eduvibe-col-lg-12';
			endif;
		endif;

		return $class;
	}
endif;

/**
 * Widget area class
 */
add_filter( 'eduvibe_widget_area_class', 'eduvibe_lp_widget_area_class' );

if ( ! function_exists( 'eduvibe_lp_widget_area_class' ) ) :
	function eduvibe_lp_widget_area_class ( $class ) {

		if ( is_post_type_archive( LP_COURSE_CPT ) || is_tax( 'course_category' ) ) :

			$course_layout = 'full_width';

			if ( 'right' === $course_layout ) :
				$class = 'eduvibe-col-lg-3';
			elseif ( 'left' === $course_layout ) :
				$class = 'eduvibe-col-lg-3 eduvibe-order-2';
			elseif ( 'full_width' === $course_layout ) :
				$class = '';
			endif;
		endif;

		if ( is_singular( LP_COURSE_CPT ) ) :
			
			$single_course_layout = 'full_width';

			if ( 'right' === $single_course_layout ) :
				$class = 'eduvibe-col-lg-3';
			elseif ( 'left' === $single_course_layout ) :
				$class = 'eduvibe-col-lg-3 eduvibe-order-2';
			elseif ( 'full_width' === $single_course_layout ) :
				$class = '';
			endif;
		endif;
		
		return $class;

	}
endif;

/**
 * Sale tag for promotional courses
 */
if ( ! function_exists( 'eduvibe_lp_course_sale_tag' ) ) :
	function eduvibe_lp_course_sale_tag() {

		$course = LP_Global::course();
		if ( $course->get_origin_price() != $course->get_price() ) :
			printf( '<span class="label">%s</span>', apply_filters( 'eduvibe_course_sale_tag_text', __( 'Sale', 'eduvibe' ) ) );
		endif;
	}
endif;

/**
 * Sale percentage tag for promotional courses
 */
if ( ! function_exists( 'eduvibe_lp_course_sale_offer_in_percentage' ) ) :
	function eduvibe_lp_course_sale_offer_in_percentage() {

		$course = LP_Global::course();
		$discount = round( 100 * ($course->get_origin_price() - $course->get_price()) / $course->get_origin_price() );
		$offer = apply_filters( 'eduvibe_course_sale_offer_text', __( 'Off', 'eduvibe' ) );
		return $discount.'%' . ' ' . $offer;
	}
endif;

/**
 * course author profile link
 */
if ( ! function_exists( 'eduvibe_lp_author_profile_url' ) ) :
	function eduvibe_lp_author_profile_url( $author_id ) {
		$output = '';
		$output .= home_url( '/' );

		$learn_press_profile_page_id = get_option( 'learn_press_profile_page_id' );
		$profile_page                = get_post( $learn_press_profile_page_id ); 
		$profile_page_slug           = $profile_page->post_name;
		if ($profile_page_slug ) :
			$output .= $profile_page_slug.'/';
		endif;

		$author_url = get_the_author_meta( 'user_login', $author_id);
		if ( $author_url ) :
			$output .= $author_url.'/';
		endif;

		return $output;
	}
endif;

/**
 * Count Course Data
 */
if ( ! function_exists( 'eduvibe_count_published_posts' ) ) :
	function eduvibe_count_published_posts( $post_type ) {

		$count_posts = wp_count_posts( $post_type );

		if ( $count_posts->publish ) :
			return $count_posts->publish;
		else :
			return 0;
		endif;
	}
endif;

/**
 * Count User by their role
 */
if ( ! function_exists( 'eduvibe_count_users_by_role' ) ) :
	function eduvibe_count_users_by_role( $role ) {

		$users = get_users( array( 'role' => $role ) );

		if ( $users && ! empty( $users ) ) :
			return count( $users );
		else :
			return 0;
		endif;
	}
endif;

/**
 * count students
 */
if ( ! function_exists( 'educhamp_count_students' ) ) :
	function educhamp_count_students( $status ) {
		
		global $wpdb;
		$table 			= $wpdb->base_prefix . 'learnpress_user_items';
		$count_students = $wpdb->get_var( 
			$wpdb->prepare( "SELECT COUNT(*) FROM $table WHERE status = %d", $status ) 
		);

		if ( $count_students && ! empty( $count_students ) ) :
			return $count_students;
		else :
			return '0';
		endif;

	}
endif;

/**
 * Single Course Thumbnail
 */
if ( ! function_exists( 'eduvibe_lp_single_course_thumbnail' ) ) :
	function eduvibe_lp_single_course_thumbnail(){
		$thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
		if ( isset( $thumb_src ) && ! empty( $thumb_src ) ) :
		    $thumb_url = $thumb_src[0];
		else :
		    $thumb_url = get_template_directory_uri() . '/assets/images/no-image-found.png';
		endif;
		echo '<div class="eduvibe-single-course-thumbnail" style="background-image: url(' . esc_url( $thumb_url ) . ')"></div>';
	}
endif;


/**
 * Before Course Content Area
 */
if ( ! function_exists( 'eduvibe_lp_single_course_content_start_wrapper' ) ) :
	function eduvibe_lp_single_course_content_start_wrapper() {
		echo '<div class="eduvibe-course-content-wrapper">';
	}
endif;

/**
 * After Course Content Area
 */
if ( ! function_exists( 'eduvibe_lp_single_course_content_end_wrapper' ) ) :
	function eduvibe_lp_single_course_content_end_wrapper() {
		echo '</div>';
	}
endif;

/**
 * Left Side Content
 */
if ( ! function_exists( 'eduvibe_lp_single_course_content_left_side_wrapper_start' ) ) :
	function eduvibe_lp_single_course_content_left_side_wrapper_start() {
		echo '<div class="eduvibe-course-content-left-side-wrapper">';
	}
endif;

/**
 * After Left Side Content
 */
if ( ! function_exists( 'eduvibe_lp_single_course_content_left_side_wrapper_end' ) ) :
	function eduvibe_lp_single_course_content_left_side_wrapper_end() {
		echo '</div>';
	}
endif;

/**
 * Right Side Content
 */
if ( ! function_exists( 'eduvibe_lp_single_course_content_right_side_wrapper' ) ) :
	function eduvibe_lp_single_course_content_right_side_wrapper() {
		$course = LP_Global::course();

		echo '<div class="eduvibe-course-details-sidebar">';
			echo '<div class="eduvibe-course-details-sidebar-inner">';
				eduvibe_lp_course_preview();

				echo '<div class="eduvibe-course-details-sidebar-content">';
					eduvibe_lp_course_meta_data();
					echo '<div class="eduvibe-course-details-sidebar-buttons">';
						
						echo '<button class="eduvibe-course-price-button edu-btn btn-bg-alt">';
							echo '<span class="eduvibe-course-price-text">';
								_e( 'Price: ', 'eduvibe' );
							echo '</span>';
							LP()->template( 'course' )->courses_loop_item_price();
						echo '</button>';

						// do_action( 'eduvibe_course_sidebar_lp_button' );
						LearnPress::instance()->template( 'course' )->course_buttons();
					echo '</div>';

					echo '<div class="eduvibe-single-event-social-share">';
						echo '<span>' . __( 'Share: ', 'eduvibe' ) . '</span>';
						get_template_part( 'template-parts/social', 'share' );
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Right Side Course Preview
 */
if ( ! function_exists( 'eduvibe_lp_course_preview' ) ) :
	function eduvibe_lp_course_preview() {
		$preview_video = get_post_meta( get_the_ID(), 'eduvibe_lp_course_preview_video_link', true );
		$preview_image = get_post_meta( get_the_ID(), 'eduvibe_lp_course_preview_image', true );
		if ( empty( $preview_image ) ) :
			$preview_image = apply_filters( 'eduvibe_lp_course_default_preview_image', esc_url( get_template_directory_uri() . '/assets/images/course-preview.png' ) );
		endif;
		echo '<div class="eduvibe-course-details-card-preview" style="background-image: url(' . esc_url( $preview_image ) . ')">';
			echo '<div class="eduvibe-course-video-preview-area">';
				if ( ! empty( $preview_video ) ) :
					echo '<a data-fancybox href="' . esc_url( $preview_video ) . '" class="eduvibe-course-video-popup">';
						echo '<i class="ri-play-fill"></i>';
					echo '</a>';
				endif;
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Right Side Meta Data
 */
if ( ! function_exists( 'eduvibe_lp_course_meta_data' ) ) :
	function eduvibe_lp_course_meta_data() {
		$course        = \LP_Global::course();
		$enrolled      = $course->get_users_enrolled();
		$lessons       = $course->get_curriculum_items( 'lp_lesson' ) ? count( $course->get_curriculum_items( 'lp_lesson' ) ) : 0;
		$quiz          = $course->get_curriculum_items( 'lp_quiz' ) ? count( $course->get_curriculum_items( 'lp_quiz' ) ) : 0;
		$pass_mark     = get_post_meta( get_the_ID(), '_lp_passing_condition', true );
		$duration      = get_post_meta( get_the_ID(), '_lp_duration', true );
		$level         = get_post_meta( get_the_ID(), '_lp_level', true);
		$skill         = $level ? $level : __( 'All Levels', 'eduvibe');
		$certificate   = 'on' === get_post_meta( get_the_ID(), 'eduvibe_lp_course_certificate', true ) ? __( 'Yes', 'eduvibe' ) : __( 'No', 'eduvibe' );	
		$language      = get_post_meta( get_the_ID(), 'eduvibe_lp_course_language', true );
		$deadline      = get_post_meta( get_the_ID(), 'eduvibe_lp_course_deadline', true );
		$duration_time = absint( $duration );

		if ( ! empty( $duration_time ) ) :
			$duration_text = str_replace( $duration_time, '', $duration );
			$duration_text = trim( $duration_text );

			switch ( $duration_text ) :
				case 'minute':
				$duration_text = $duration_time > 1 ? __( 'Minutes', 'eduvibe' ) : __( 'Minute', 'eduvibe' );
				break;
				case 'hour':
				$duration_text = $duration_time > 1 ? __( 'Hours', 'eduvibe' ) : __( 'Hour', 'eduvibe' );
				break;
				case 'day':
				$duration_text = $duration_time > 1 ? __( 'Days', 'eduvibe' ) : __( 'Day', 'eduvibe' );
				break;
				case 'week':
				$duration_text = $duration_time > 1 ? __( 'Weeks', 'eduvibe' ) : __( 'Week', 'eduvibe' );
				break;
			endswitch;
		endif;

		echo '<ul class="eduvibe-course-meta-informations">';
			do_action( 'eduvibe_lp_course_meta_before' );

			if ( ! empty( $duration_time ) && eduvibe_get_config( 'lp_course_duration', true ) ) :
				$duration_label = eduvibe_get_config( 'lp_course_duration_label' ) ? eduvibe_get_config( 'lp_course_duration_label' ) : __( 'Duration', 'eduvibe' );
				echo '<li class="eduvibe-course-details-features-item">';
					echo '<span>';
						echo '<i class="icon-time-line"></i>';
						echo esc_html( $duration_label );
					echo '</span>';
					echo '<span class="eduvibe-course-feature-item-value">' . esc_html( $duration_time ) . ' ' . esc_html( $duration_text ) . '</span>';
				echo '</li>';
			endif;

			if ( eduvibe_get_config( 'lp_course_students', true ) ) :
				$students_label = eduvibe_get_config( 'lp_course_students_label' ) ? eduvibe_get_config( 'lp_course_students_label' ) : __( 'Students', 'eduvibe' );
				echo '<li class="eduvibe-course-details-features-item">';
					echo '<span>';
						echo '<i class="icon-user-2"></i>';
						echo esc_html( $students_label );
					echo '</span>';
					echo '<span class="eduvibe-course-feature-item-value">' . esc_html( $enrolled ) . '</span>';
				echo '</li>';
			endif;

			if ( eduvibe_get_config( 'lp_course_lessons', true ) ) :
				$lessons_label = eduvibe_get_config( 'lp_course_lessons_label' ) ? eduvibe_get_config( 'lp_course_lessons_label' ) : __( 'Lessons', 'eduvibe' );
				echo '<li class="eduvibe-course-details-features-item">';
					echo '<span>';
						echo '<i class="icon-draft-line"></i>';
						echo esc_html( $lessons_label );
					echo '</span>';
					echo '<span class="eduvibe-course-feature-item-value">' . esc_html( $lessons ) . '</span>';
				echo '</li>';
			endif;

			if ( ! empty( $skill ) && eduvibe_get_config( 'lp_course_skill_level', true ) ) :
				$skill_label = eduvibe_get_config( 'lp_course_skill_level_label' ) ? eduvibe_get_config( 'lp_course_skill_level_label' ) : __( 'Skill Level', 'eduvibe' );
				echo '<li class="eduvibe-course-details-features-item">';
					echo '<span>';
						echo '<i class="icon-bar-chart-2-line"></i>';
						echo esc_html( $skill_label );
					echo '</span>';
					echo '<span class="eduvibe-course-feature-item-value">' . esc_html( ucwords( $skill ) ) . '</span>';
				echo '</li>';
			endif;

			if ( ! empty( $language ) && eduvibe_get_config( 'lp_course_language', true ) ) :
				$language_label = eduvibe_get_config( 'lp_course_language_label' ) ? eduvibe_get_config( 'lp_course_language_label' ) : __( 'Language', 'eduvibe' );
				echo '<li class="eduvibe-course-details-features-item">';
					echo '<span>';
						echo '<i class="icon-translate"></i>';
						echo esc_html( $language_label );
					echo '</span>';
					echo '<span class="eduvibe-course-feature-item-value">' . esc_html( ucwords( $language ) ) . '</span>';
				echo '</li>';
			endif;

			if ( eduvibe_get_config( 'lp_course_quizzes', true ) ) :
				$quizzes_label = eduvibe_get_config( 'lp_course_quizzes_label' ) ? eduvibe_get_config( 'lp_course_quizzes_label' ) : __( 'Quizzes', 'eduvibe' );
				echo '<li class="eduvibe-course-details-features-item">';
					echo '<span>';
						echo '<i class="icon-artboard-line"></i>';
						echo esc_html( $quizzes_label );
					echo '</span>';
					echo '<span class="eduvibe-course-feature-item-value">' . esc_html( $quiz ) . '</span>';
				echo '</li>';
			endif;

			if ( ! empty( $certificate ) && eduvibe_get_config( 'lp_course_certification', true ) ) :
				$certification_label = eduvibe_get_config( 'lp_course_certification_label' ) ? eduvibe_get_config( 'lp_course_certification_label' ) : __( 'Certifications', 'eduvibe' );
				echo '<li class="eduvibe-course-details-features-item">';
					echo '<span>';
						echo '<i class="icon-award-line"></i>';
						echo esc_html( $certification_label );
					echo '</span>';
					echo '<span class="eduvibe-course-feature-item-value">' . esc_html( $certificate ) . '</span>';
				echo '</li>';
			endif;
			
			if ( ! empty( $pass_mark ) && eduvibe_get_config( 'lp_course_pass_percentage', true ) ) :
				$pass_percentage_label = eduvibe_get_config( 'lp_course_pass_percentage_label' ) ? eduvibe_get_config( 'lp_course_pass_percentage_label' ) : __( 'Pass Percentage', 'eduvibe' );
				echo '<li class="eduvibe-course-details-features-item">';
					echo '<span>';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/icons/percent.svg' ) . '" class="eduvibe-course-sidebar-img-icon">';
						echo esc_html( $pass_percentage_label );
					echo '</span>';
					echo '<span class="eduvibe-course-feature-item-value">' . esc_html( $pass_mark ) . '%</span>';
				echo '</li>';
			endif;

			if ( ! empty( $deadline ) && eduvibe_get_config( 'lp_course_deadline', true ) ) :
				$deadline_label = eduvibe_get_config( 'lp_course_deadline_label' ) ? eduvibe_get_config( 'lp_course_deadline_label' ) : __( 'Deadline', 'eduvibe' );
				echo '<li class="eduvibe-course-details-features-item">';
					echo '<span>';
						echo '<i class="icon-calendar-2-line"></i>';
						echo esc_html( $deadline_label );
					echo '</span>';
					echo '<span class="eduvibe-course-feature-item-value">' . esc_html( ucwords( $deadline ) ) . '</span>';
				echo '</li>';
			endif;

			if ( eduvibe_get_config( 'lp_course_instructor', true ) ) :
				$instructor_label = eduvibe_get_config( 'lp_course_instructor_label' ) ? eduvibe_get_config( 'lp_course_instructor_label' ) : __( 'Instructor', 'eduvibe' );
				echo '<li class="eduvibe-course-details-features-item">';
					echo '<span>';
						echo '<i class="icon-user-2-line_tie"></i>';
						echo esc_html( $instructor_label );
					echo '</span>';
					echo '<span>' . wp_kses_post( get_the_author() ) . '</span>';
				echo '</li>';
			endif;

			do_action( 'eduvibe_lp_course_meta_after' );
		echo '</ul>';
	}
endif;

/**
 * Course instructor
 */
if ( ! function_exists( 'eduvibe_lp_course_instructor' ) ) :
	function eduvibe_lp_course_instructor( $thumb_size = 60 ) {
		echo '<div class="course-author" itemscope="" itemtype="http://schema.org/Person">';
			printf( get_avatar( get_the_author_meta( 'ID' ), $thumb_size ) );	
			echo '<div class="author-contain">';
				echo '<label itemprop="jobTitle">' . __( 'Teacher', 'eduvibe' ) . '</label>';
				echo '<div class="value" itemprop="name">';
					the_author();
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Course category
 */
if ( ! function_exists( 'eduvibe_lp_course_first_category' ) ) :
	function eduvibe_lp_course_first_category() {
		$first_cat = eduvibe_category_by_id( get_the_id(), 'course_category' );
		if ( ! empty( $first_cat) ) :
			echo '<div class="course-categories">';
				echo '<label>' . __( 'Categories', 'eduvibe' ) . '</label>';
				echo '<div class="value">';
					echo '<span class="cat-links">';
						echo wp_kses_post( $first_cat );
					echo '</span>';
				echo '</div>';
			echo '</div>';
		endif;
	}
endif;

/**
 * Display course ratings
 */
if ( ! function_exists( 'eduvibe_lp_course_ratings' ) ) :
	function eduvibe_lp_course_ratings( $show_rating = false ) {
		if ( ! class_exists( 'LP_Addon_Course_Review_Preload' ) ) :
			return;
		endif;

		$course_rate_res = learn_press_get_course_rate( get_the_ID(), false );
		$course_rate     = $course_rate_res['rated'];
		$total           = $course_rate_res['total'];
		$ratings         = learn_press_get_course_rate_total( get_the_ID() );
		echo '<div class="eduvibe-course-review-wrapper">';
			learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );

			if ( $show_rating ) :
				echo '<span>';
					echo esc_html( '(' . number_format( $course_rate, 1 ) . ')' );
				echo '</span>';
			else :
				echo '<span>';
					printf( _nx( '(%s Review)', '(%s Reviews)', $ratings, 'Ratings', 'eduvibe' ), number_format_i18n( $ratings ) );
				echo '</span>';
			endif;
		echo '</div>';
	}
endif;

/**
 * Display course rating value only
 */
if ( ! function_exists( 'eduvibe_lp_course_rating_value' ) ) :
	function eduvibe_lp_course_rating_value() {
		if ( ! class_exists( 'LP_Addon_Course_Review_Preload' ) ) :
			return;
		endif;

		$course_rate_res = learn_press_get_course_rate( get_the_ID(), false );
		$course_rate     = $course_rate_res['rated'];
		$total           = $course_rate_res['total'];
		$ratings         = learn_press_get_course_rate_total( get_the_ID() );
		return number_format( $course_rate, 1 );
	}
endif;

/**
 * Generate wishlist icon
 */
if ( ! function_exists( 'eduvibe_lp_wishlist_icon' ) ) :
	function eduvibe_lp_wishlist_icon( $course_id ){
		$user_id = get_current_user_id();

		if ( ! class_exists( 'LP_Addon_Wishlist' ) || ! $course_id ) :
			return;
		endif;

		if ( ! $user_id ) :
			echo '<button class="eduvibe-wishlist-wrapper eduvie-lp-non-logged-user">';
			echo '</button>';
			return;
		endif;

		$classes = array( 'course-wishlist' );
		$state   = learn_press_user_wishlist_has_course( $course_id, $user_id ) ? 'on' : 'off';

		if ( 'on' === $state ) :
			$classes[] = 'on';
		endif;
		$classes = apply_filters( 'learn_press_course_wishlist_button_classes', $classes, $course_id );
		$title   = ( 'on' === $state ) ? __( 'Remove this course from your wishlist', 'eduvibe' ) : __( 'Add this course to your wishlist', 'eduvibe' );

		printf(
			'<button class="eduvibe-wishlist-wrapper learn-press-course-wishlist-button-%2$d %s" data-id="%s" data-nonce="%s" title="%s"></button>',
			join( " ", $classes ),
			$course_id,
			wp_create_nonce( 'course-toggle-wishlist' ),
			$title
		);	

	}
endif;

/**
 * Related Courses
 */
if ( ! function_exists( 'eduvibe_lp_single_course_related_course_wrapper' ) ) :
	function eduvibe_lp_single_course_related_course_wrapper() {
		$show_related_course = eduvibe_get_config( 'lp_related_courses', true );
		if ( $show_related_course ) :
			learn_press_get_template( 'custom/courses-releated.php' );
		endif;
	}
endif;

/**
 * Curriculum section title
 */
if ( ! function_exists( 'eduvibe_lp_curriculum_section_title' ) ) :
	function eduvibe_lp_curriculum_section_title( $section ) {
		learn_press_get_template( 'custom/curriculum-title.php', array( 'section' => $section ) );
	}
endif;

/**
 * LearnPress Course
 * @return boolean
 */
function eduvibe_is_lp_courses() {
    if ( learn_press_is_courses() || learn_press_is_course_tag() || learn_press_is_course_category() || learn_press_is_course_tax() || learn_press_is_search() ) :
        return true;
    endif;
    return false;
}

/**
 * LP breadcrumb delimiter
 */

add_filter( 'learn_press_breadcrumb_defaults', 'eduvibe_lp_breadcrumb_delimiter' );

if( ! function_exists( 'eduvibe_lp_breadcrumb_delimiter' ) ) :
	function eduvibe_lp_breadcrumb_delimiter( $args ) {
		$args['delimiter'] = '';
		return $args;
	}
endif;

/**
 * indexing result of courses
 */
if( ! function_exists( 'eduvibe_lp_course_index_result' ) ) :
	function eduvibe_lp_course_index_result( $total ) {
		if ( 0 === $total ) :
			$result = __( 'There are no available courses!', 'eduvibe' );	
		elseif ( 1 === $total ) :
			$result = __( 'Showing only one result.', 'eduvibe' );
		else :
			$courses_per_page = absint( LP()->settings->get( 'archive_course_limit' ) );
			$paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

			$from = 1 + ( $paged - 1 ) * $courses_per_page;
			$to   = ( $paged * $courses_per_page > $total ) ? $total : $paged * $courses_per_page;

			if ( $from == $to ) :
				$result = sprintf( __( 'Showing Last Course Of %s Results', 'eduvibe' ), $total );
			else :
				$result = sprintf( __( 'Showing %s-%s Of %s Results', 'eduvibe' ), '<span>' . $from, $to . '</span>', '<span>' . $total . '</span>' );
			endif;
		endif;
		echo wp_kses_post( $result );
	}
endif;

/**
 * Course archive top bar
 */
if( ! function_exists( 'eduvibe_lp_course_header_top_bar' ) ) :
	function eduvibe_lp_course_header_top_bar( $query ) {
		global $wp_query;
		$top_bar      = eduvibe_get_config( 'lp_course_archive_top_bar', true );
		$index      = eduvibe_get_config( 'lp_course_index', true );
		$search_bar = eduvibe_get_config( 'lp_course_search_bar', true );

		if ( true == $index && true == $search_bar ) :
			$column = 'eduvibe-col-md-6';
		else :
			$column = 'eduvibe-col-md-12';
		endif;

		if ( ( true == $top_bar ) && ( true == $index || true == $search_bar ) ) :
			echo '<div class="eduvibe-course-archive-top-bar-wrapper">';
				echo '<div class="eduvibe-course-archive-top-bar eduvibe-row">';
					if ( true == $index ) :
						echo '<div class="' . esc_attr( $column ) . '">';
							echo '<span class="eduvibe-course-archive-index-count">';
								eduvibe_lp_course_index_result( $query->found_posts );
							echo '</span>';
						echo '</div>';
					endif;
					if ( true == $search_bar ) :
						echo '<div class="' . esc_attr( $column ) . '">';
							echo '<div class="eduvibe-course-archive-search">';
								eduvibe_lp_course_archive_search_bar();
							echo '</div>';
						echo '</div>';
					endif;
				echo '</div>';
			echo '</div>';
		endif;
	}
endif;

/**
 * Course archive search bar
 */
if( ! function_exists( 'eduvibe_lp_course_archive_search_bar' ) ) :
	function eduvibe_lp_course_archive_search_bar() {
		/*
		 * remove param action="' . esc_url( get_post_type_archive_link( LP_COURSE_CPT ) ) . '"
		 * if you don't want to redirect to course category archive
		 */
		echo '<div class="edu-search-box">';
			echo '<form class="eduvibe-archive-course-search-form" method="get" action="' . esc_url( get_post_type_archive_link( LP_COURSE_CPT ) ) . '">';
				echo '<input type="text" value="" name="s" placeholder="'. __( 'Search Courses...', 'eduvibe' ) . '" class="input-search" autocomplete="off" />';
				echo '<input type="hidden" value="course" name="ref" />';
				echo '<button class="search-button"><i class="icon-search-line"></i></button>';
			echo '</form>';
		echo '</div>';
	}
endif;

/**
 * Main Content Wrapper Class for LearnPress 
 * Course Archive & Course Details
 */
add_filter( 'eduvibe_main_content_inner', 'eduvibe_lp_main_content_wrapper_class' );
if( ! function_exists( 'eduvibe_lp_main_content_wrapper_class' ) ) :
	function eduvibe_lp_main_content_wrapper_class( $class ) {
		if ( learn_press_is_courses() || learn_press_is_course_tag() || learn_press_is_course_category() || learn_press_is_course_tax() || learn_press_is_search() ) :
			$class = '';
		elseif ( is_singular( LP_COURSE_CPT ) ) :
			$class = ' eduvibe-row';
		endif;
		return $class;
	}
endif;

/**
 * Remove and Modify Instructor Tab From 
 * LearnPress Course Details Page
 */
add_filter( 'learn-press/course-tabs', 'eduvibe_lp_instructor_tab_modify' );
if( ! function_exists( 'eduvibe_lp_instructor_tab_modify' ) ) :
	function eduvibe_lp_instructor_tab_modify( $tabs ) {
		$instructor_tab = eduvibe_get_config( 'lp_instructor_tab', true );
		if ( true == $instructor_tab ) :
			$tabs['instructor']['title']   = eduvibe_get_config( 'lp_instructor_tab_title', __( 'Instructor', 'eduvibe' ) );
		else :
			unset( $tabs['instructor'] );
		endif;
		return $tabs;
	}
endif;


/**
 * Course Taxonomy Archive Page Query
 * Only for Category( 'course_category' ) and 
 * Tag( 'course_tag' ) Archive Pages
 */
add_filter( 'eduvibe_lp_course_archive_args', 'eduvibe_lp_course_taxonomy_filter_archive' );
if( ! function_exists( 'eduvibe_lp_course_taxonomy_filter_archive' ) ) :
	function eduvibe_lp_course_taxonomy_filter_archive( $args ) {
		$category = get_queried_object();
		if ( learn_press_is_course_archive() ) :
			if ( isset( $category->taxonomy ) && 'course_category' === $category->taxonomy ) :
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'course_category',
						'field'    => 'term_id',
						'terms'    => array( $category->term_id )
					)
				);
			elseif ( isset( $category->taxonomy ) && 'course_tag' === $category->taxonomy ) :
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'course_tag',
						'field'    => 'term_id',
						'terms'    => array( $category->term_id )
					)
				);
			endif;
		endif;
		return $args;
	}
endif;

/**
 * Course Archive Search Filter
 */
add_filter( 'eduvibe_lp_course_archive_args', 'eduvibe_lp_course_search_filter_archive' );
if( ! function_exists( 'eduvibe_lp_course_search_filter_archive' ) ) :
	function eduvibe_lp_course_search_filter_archive( $args ) {
		if ( learn_press_is_course_archive() ) :
			if ( isset( $_REQUEST['ref'] ) && 'course' === $_REQUEST['ref'] ) :
				$args['s'] = sanitize_text_field( $_REQUEST['s'] );
			endif;
		endif;
		return $args;
	}
endif;

/**
 * Course Archive Main Filter
 */
add_filter( 'eduvibe_lp_course_archive_args', 'eduvibe_lp_course_category_filter_archive' );
if( ! function_exists( 'eduvibe_lp_course_category_filter_archive' ) ) :
	function eduvibe_lp_course_category_filter_archive( $args ) {
		if ( learn_press_is_course_archive() ) :
			if ( ! empty( $_GET['filter-category'] ) ) :
				if ( is_array( $_GET['filter-category'] ) ) :
					$args['tax_query'] = array(
						array(
						'taxonomy'  => 'course_category',
						'field'     => 'term_id',
						'terms'     => array_map( 'sanitize_text_field', $_GET['filter-category'] ),
						'compare'   => 'IN'
						)
					);
				else :
					$args['tax_query'] = array(
						array(
							'taxonomy'  => 'course_category',
							'field'     => 'term_id',
							'terms'     => sanitize_text_field( $_GET['filter-category'] ),
							'compare'   => '=='
						)
					);
				endif;
			endif;

			if ( ! empty( $_GET['filter-level'] ) ) :
				if ( is_array( $_GET['filter-level'] ) ) :
					$args['meta_query'][] = array(
						'key'     => '_lp_level',
						'value'   => array_map( 'sanitize_text_field', $_GET['filter-level'] ),
						'compare' => 'IN'
					);
				else :
					$args['meta_query'][] = array(
						'key'     => '_lp_level',
						'value'   => sanitize_text_field( $_GET['filter-level'] ),
						'compare' => '='
					);
				endif;
            endif;
        endif;
		return $args;
	}
endif;

/**
 * LearnPress External Button Text
 *
 */
add_filter( 'learn-press/course-external-link-text', 'eduvibe_lp_external_link_text' );
function eduvibe_lp_external_link_text( $default ) {
	$text = eduvibe_get_config( 'lp_external_link_text' );
	return $text ? $text : $default;
}

/**
 * LearnPress Purchase Button Text
 *
 */
add_filter( 'learn-press/purchase-course-button-text', 'eduvibe_lp_course_purchase_button_text' );
function eduvibe_lp_course_purchase_button_text( $default ) {
	$text = eduvibe_get_config( 'lp_purchase_button_text' );
	return $text ? $text : $default;
}

/**
 * LearnPress Enroll Button Text
 *
 */
add_filter( 'learn-press/enroll-course-button-text', 'eduvibe_lp_course_enroll_button_text' );
function eduvibe_lp_course_enroll_button_text( $default ) {
	$text = eduvibe_get_config( 'lp_enroll_button_text' );
	return $text ? $text : $default;
}

/**
 * Enable templates override
 *
 * @return bool
 * @since 4.0.0
 */

add_filter( 'learn-press/override-templates', 'eduvibe_lp_override_action' );
if( ! function_exists( 'eduvibe_lp_override_action' ) ) :
	function eduvibe_lp_override_action() {
		return true;
	}
endif;