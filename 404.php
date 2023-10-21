<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package EduVibe
 */

get_header( 'blank' );
	echo '<div class="edu-error-area eduvibe-404-page edu-error-style">';
		echo '<div class="eduvibe-container eduvibe-animated-shape">';
			echo '<div class="eduvibe-row">';
				echo '<div class="eduvibe-col-lg-12">';
					echo '<div class="content text-center">';
						echo '<div class="thumbnail eduvibe-mb--60">';
							echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/404.png' ) . '" alt="404 Images">';
						echo '</div>';

						$error_page_title = eduvibe_get_config( 'error_page_title', __( 'Oops... Page Not Found!', 'eduvibe' ) );
						$error_page_desc = eduvibe_get_config( 'error_page_description', __( 'Please return to the site\'s homepage, It looks like nothing was found at this location.', 'eduvibe' ) );

						if ( ! empty( $error_page_title ) ) :
							echo '<h3 class="title">' . wp_kses_post( $error_page_title ) . '</h3>';
						endif;
						
						if ( ! empty( $error_page_desc ) ) :
							echo '<p class="description">' . wp_kses_post( $error_page_desc ) . '</p>';
						endif;

						echo '<div class="backto-home-btn">';
							echo '<a class="edu-btn" href="' . esc_url( get_site_url() ) . '">Back To Home<i class="icon-arrow-right-line-right"></i></a>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';

			echo '<div class="shape-dot-wrapper shape-wrapper eduvibe-d-xl-block eduvibe-d-none">';
				echo '<div class="shape-image shape-image-1">';
					echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/shape-11-06.png' ) . '" alt="Shape Thumb">';
				echo '</div>';
				echo '<div class="shape-image shape-image-2">';
					echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/shape-09-02.png' ) . '" alt="Shape Thumb">';
				echo '</div>';
				echo '<div class="shape-image shape-image-3">';
					echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/shape-05-06.png' ) . '" alt="Shape Thumb">';
				echo '</div>';
				echo '<div class="shape-image shape-image-4">';
					echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/shape-14-03.png' ) . '" alt="Shape Thumb">';
				echo '</div>';
				echo '<div class="shape-image shape-image-5">';
					echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/shape-03-10.png' ) . '" alt="Shape Thumb">';
				echo '</div>';
				echo '<div class="shape-image shape-image-6">';
					echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/shape-15.png' ) . '" alt="Shape Thumb">';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';

get_footer( 'blank' );