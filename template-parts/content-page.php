<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EduVibe
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'eduvibe-single-page' ); ?>>

	<?php eduvibe_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();
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
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer<?php do_action( 'eduvibe_page_footer_wrapper_class' ); ?>">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'eduvibe' ),
						array(
							'span' => array(
								'class' => array()
							)
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
