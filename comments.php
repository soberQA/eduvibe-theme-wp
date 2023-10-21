<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EduVibe
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area eduvibe-comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$eduvibe_comment_count = get_comments_number();
			if ( '1' === $eduvibe_comment_count ) :
				printf(
					/* translators: 1: title. */
					__( '1 Comment', 'eduvibe' )
				);
			else :
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s Comment', '%1$s Comments', $eduvibe_comment_count, 'comments title', 'eduvibe' ) ),
					number_format_i18n( $eduvibe_comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			endif;
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="eduvibe-comment-list">
			<?php
			wp_list_comments( array(
				'walker'      => new EduVibe_Comment_Walker,
				'style'       => 'ol',
				'short_ping'  => false,
				'type'        => 'all',
				'format'      => current_theme_supports( 'html5', 'comment-list' ) ? 'html5' : 'xhtml',
				'avatar_size' => 100
			) );
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'eduvibe' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form( eduvibe_comments_template() );
	?>

</div><!-- #comments -->
