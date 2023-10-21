<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package EduVibe
 */

if ( ! function_exists( 'eduvibe_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function eduvibe_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) :
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		endif;

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'eduvibe' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'eduvibe_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function eduvibe_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'eduvibe' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'eduvibe_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function eduvibe_entry_footer() {
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'eduvibe' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		endif;

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'eduvibe' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'eduvibe_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function eduvibe_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ( ! has_post_thumbnail() && ! get_the_post_thumbnail_url() ) ) :
			return;
		endif;

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'full' ); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'eduvibe-post-thumb', array(
				'alt' => the_title_attribute( array(
					'echo' => false
				) )
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;


/**
 * Thumbnail alt attribute text
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'eduvibe_thumbanil_alt_text' ) ) :
	function eduvibe_thumbanil_alt_text( $image_id ) {
		$alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
        $title = get_post( $image_id )->post_title;
        $alt_text = apply_filters( 'edvibe_thumbanil_alt_default_text', __( 'Post Thumb', 'eduvibe' ) );

        if ( $alt ) :
            $alt_text = $alt;
        else :
            $alt_text = $title;
        endif;
		return $alt_text;
	}
endif;

/**
 * Get tags meta
 *
 * @return string
 */
if ( ! function_exists( 'eduvibe_entry_meta_tags' ) ) :
	function eduvibe_entry_meta_tags() {
		$tags_list = get_the_tag_list( '', ' ' );
		if ( $tags_list ) :
			return sprintf( '<span class="tags-links">' . esc_html__( 'Tags: %1$s', 'eduvibe' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		endif;

		return '';
	}
endif;

/**
 * Search Form Theme Style
 *
 */
if ( ! function_exists( 'eduvibe_search_form_replace' ) ) {
    function eduvibe_search_form_replace( $search_form ) {

        $search_form = sprintf(
            '<div class="eduvibe-search-box">
				<form class="search-form" action="%s" method="get">
					<input type="search" value="%s" required name="s" placeholder="%s">
					<button type="submit" class="search-button"><i class="icon-search-line"></i></button>
				</form>
			</div>',
            esc_url( home_url( '/' ) ),
            esc_attr( get_search_query() ),
            __( 'Search', 'eduvibe' )
        );

        return $search_form;
    }
    add_filter( 'get_search_form', 'eduvibe_search_form_replace' );
}

/**
 * Single Post Before Content
 *
 * @since 1.0.0
 */
add_action( 'eduvibe_single_post_before', 'eduvibe_single_post_before_content', 10 );
function eduvibe_single_post_before_content() {
	echo '<ul class="eduvibe-blog-meta">';
		echo '<li>';
			echo get_avatar( get_the_author_meta( 'ID' ), 80 );
			echo '<span class="author-title">';
				the_author();
			echo '</span>';
		echo '</li>';

		echo '<li>';
			echo '<i class="icon-calendar-2-line"></i>';
			echo esc_html( get_the_date( 'd M, Y' ) );
		echo '</li>';

		echo '<li>';
			echo '<i class="icon-discuss-line"></i>';
			printf( // WPCS: XSS OK.
				/* translators: 1: comment count number, 2: title. */
				esc_html( _nx( '%1$s Comment', '%1$s Comments', get_comments_number(), 'comments title', 'eduvibe' ) ),
				number_format_i18n( get_comments_number() ),
				'<span>' . get_the_title() . '</span>'
			);
		echo '</li>';

		echo '<li>';
			echo '<i class="icon-eye-line"></i>';
			echo eduvibe_post_estimated_reading_time() . ' '. __( 'Read', 'eduvibe' );
		echo '</li>';
	echo '</ul>';
}

/**
 * Single Post After Content
 *
 * Post Category and Post Share
 *
 * @since 1.0.0
 */
add_action( 'eduvibe_single_post_after', 'eduvibe_single_post_after_cats_social_share', 10 );
function eduvibe_single_post_after_cats_social_share() {
	if ( 'post' === get_post_type() && eduvibe_get_config( 'blog_single_catgory_and_social_share', true ) ) :
		$categories = eduvibe_category_by_id( get_the_ID(), 'category', false );
		echo '<div class="eduvibe-cat-social-share-wrapper">';
			echo '<div class="eduvibe-cat-social-share eduvibe-row">';
				if ( empty( $categories ) ) :
					$column = 'eduvibe-col-sm-12';
				else :
					$column = 'eduvibe-col-sm-6';
				endif;

				if( ! empty( $categories ) ) :
					echo '<div class="eduvibe-post-category ' . esc_attr( $column ). '">';
						echo wp_kses_post( $categories );
					echo '</div>';
				endif;
				
				echo '<div class="eduvibe-single-post-social-share ' . esc_attr( $column ). '">';
					echo '<span>' . __( 'Share: ', 'eduvibe' ) . '</span>';
					get_template_part( 'template-parts/social', 'share' );
				echo '</div>';
			echo '</div>';
		echo '</div>';
	endif;
}

/**
 * Single Post After Content
 *
 * Author Bio
 *
 * @since 1.0.0
 */
add_action( 'eduvibe_single_post_after', 'eduvibe_single_post_after_author_bio', 15 );
function eduvibe_single_post_after_author_bio() {
	if ( 'post' === get_post_type() && eduvibe_get_config( 'blog_single_author_bio', true ) ) :
		eduvibe_author_bio();
	endif;
}

/**
 * Single Post After Content
 *
 * Related Posts
 *
 * @since 1.0.0
 */
// add_action( 'eduvibe_single_post_after', 'eduvibe_single_post_after_related_posts', 20 );
function eduvibe_single_post_after_related_posts() {
	if ( 'post' === get_post_type() && eduvibe_get_config( 'blog_single_related_post', true ) ) :
		get_template_part( 'template-parts/related', 'posts' );
	endif;
}

/**
 * Single Post After Content
 *
 * Displays Previous & Next Post Naviation
 *
 * @since 1.0.0
 */
add_action( 'eduvibe_single_post_after', 'eduvibe_post_nav_prev_next', 20 );
if ( ! function_exists( 'eduvibe_post_nav_prev_next' ) ) :
	function eduvibe_post_nav_prev_next() {
		$prev_post = get_previous_post();
		$next_post = get_next_post();
		if ( ! empty( $prev_post->post_title ) || ! empty( $next_post->post_title ) ) :
			echo '<div class="eduvibe-post-nav-prev-next eduvibe-row">';
				if ( ! empty( $prev_post->post_title ) ) :
					echo '<div class="eduvibe-col-sm-6">';
						echo '<div class="eduvibe-single-post-nav eduvibe-prev-post">';
							echo '<a href="' . esc_url( get_permalink( $prev_post->ID ) ) . '">';
								echo '<i class="ri-arrow-left-s-line"></i>';
								echo '<span class="post-title">' . esc_html( $prev_post->post_title ) . '</span>';
							echo '</a>';
						echo '</div>';
					echo '</div>';
				endif;

				if ( ! empty( $next_post->post_title ) ) :
					echo '<div class="eduvibe-col-sm-6">';
						echo '<div class="eduvibe-single-post-nav eduvibe-next-post">';
							echo '<a href="' . esc_url( get_permalink( $next_post->ID ) ) . '">';
								echo '<span class="post-title">' . esc_html( $next_post->post_title ) . '</span>';
								echo '<i class="ri-arrow-right-s-line"></i>';
							echo '</a>';
						echo '</div>';
					echo '</div>';
				endif;
			echo '</div>';
		endif;
	}
endif;
