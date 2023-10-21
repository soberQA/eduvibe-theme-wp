<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package EduVibe
 */

				do_action( 'eduvibe_after_content' );
			echo '</div>';
		echo '</div>';

		$footer = apply_filters( 'eduvibe_get_footer_layout', eduvibe_get_config( 'footer_type' ) );
		$default_footers = array( 'theme-default-footer' );
		$footer_custom_copyright = eduvibe_get_config( 'footer_custom_copyright_text' );

		if ( 'none' !== $footer ) :
			if ( in_array( $footer, $default_footers ) || empty( $footer ) ) :
				echo '<footer id="colophon" class="eduvibe-footer-default-wrapper site-footer">';
					echo '<div class="site-info ' . esc_attr( apply_filters( 'eduvibe_footer_site_info_container_class', 'eduvibe-container' ) ) . '">';
						echo '<div class="eduvibe-row">';
							echo '<div class="eduvibe-col-lg-12">';
								if ( $footer_custom_copyright ) :
									echo wp_kses_post( $footer_custom_copyright );
								else :
									$allowed_html_array = array( 'a' => array( 'href' => array() ) );
									echo wp_kses( sprintf( __( '&copy; %s - EduVibe. All Rights Reserved. Proudly powered by <a href="https://devsvibe.com">DevsVibe</a>', 'eduvibe' ), date( "Y" ) ), $allowed_html_array );
								endif;
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</footer>';
			else :
				eduvibe_display_footer_builder( $footer );
			endif;
		endif;

		if ( eduvibe_get_config( 'scroll_to_top', true ) ) :
			echo '<div class="devsvibe-progress-parent">';
				echo '<svg class="devsvibe-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">';
					echo '<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />';
				echo '</svg>';
			echo '</div>';
		endif;
	echo '</div>';

	wp_footer();
echo '</body>';
echo '</html>';
