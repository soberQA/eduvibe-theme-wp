<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

$eduvibe_post_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'eduvibe-post-thumb' );
if ( isset( $eduvibe_post_thumb_src ) && ! empty( $eduvibe_post_thumb_src ) ) :
    $eduvibe_post_thumb_url = $eduvibe_post_thumb_src[0];
else :
    $eduvibe_post_thumb_url = '';
endif;
$blog_post_desktop_cols  = 12/eduvibe_get_config( 'blog_post_columns', 2 );

if ( isset( $_GET['column'] ) && $_GET['column'] == 3 ) :
	$blog_post_desktop_cols = 4;
endif;
?>
<div id="post-<?php the_ID(); ?>" <?php post_class( 'eduvibe-post-one-single-grid eduvibe-col-lg-' . esc_attr( $blog_post_desktop_cols ) . ' eduvibe-col-md-6 eduvibe-col-sm-12' ); ?>>
	<?php
	echo '<div class="edu-blog eduvibe-blog-post-1 variation-2 radius-small">';
		echo '<div class="inner">';
			if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
				echo '<div class="thumbnail">';
					echo '<a href="' . esc_url( get_the_permalink() ) . '">';
						echo '<img src="' . esc_url( $eduvibe_post_thumb_url ). '" alt="' . esc_attr( eduvibe_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '" >';
					echo '</a>';
				echo '</div>';
			endif;
			
			echo '<div class="content">';
				if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
					echo '<div class="blog-date-status">';
						echo '<span class="day">' . esc_html( get_the_date( 'd' ) ) . '</span> <span class="month">' . esc_html( get_the_date( 'M' ) ) . '</span>';
					echo '</div>';
				endif;

				echo '<div class="status-style-5">';
					echo '<span class="eduvibe-status status-05">';
						echo '<i class="icon-price-tag-3-line"></i>'; 
						echo eduvibe_category_by_id( get_the_ID() );
					echo '</span> ';

					echo '<span class="eduvibe-status status-05">';
						echo '<i class="icon-time-line"></i> ' . eduvibe_post_estimated_reading_time() . ' '. __( 'Read', 'eduvibe' );
					echo '</span>';
				echo '</div>';

				echo eduvibe_get_title();
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</div>';