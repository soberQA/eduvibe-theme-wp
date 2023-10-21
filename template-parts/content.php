<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EduVibe
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'eduvibe-single-post' ); ?>>
	<?php eduvibe_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		if ( is_single() ) :
			/**
			 * eduvibe_single_post_before hook
			 *
			 * @hooked eduvibe_single_post_before_content - 10
			 */
			do_action( 'eduvibe_single_post_before' );

			the_title( '<h4 class="post-main-title">', '</h4>' );

			the_content( sprintf(
				/* translators: %s: Name of current post. Only visible to screen readers */
				wp_kses( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'eduvibe' ), array( 'span' => array( 'class' => array() ) ) ),
				get_the_title()
			) );

			if ( function_exists( 'eduvibe_link_pages' ) ) :
				eduvibe_link_pages( array(
					'before' => '<nav class="eduvibe-theme-page-links">' . __( 'Pages:', 'eduvibe' ) . '<ul class="pager">',
					'after'  => '</ul></nav>',
				) );
			else :
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'eduvibe' ),
					'after'  => '</div>',
				) );
			endif;
			
			/**
			 * eduvibe_single_post_after hook
			 *
			 * @hooked eduvibe_single_post_after_cats_social_share - 10
			 * @hooked eduvibe_single_post_after_author_bio - 15
			 * @hooked eduvibe_post_nav_prev_next - 20
			 */
			do_action( 'eduvibe_single_post_after' );
		else :
			the_excerpt();
		endif;
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php eduvibe_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
