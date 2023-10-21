<?php
/**
 * Quick view content.
 *
 * @author  YITH
 * @package YITH WooCommerce Quick View
 * @version 1.0.0
 */

defined( 'YITH_WCQV' ) || exit; // Exit if accessed directly.

while ( have_posts() ) :
	the_post();
	global $product;
	$count_total_rating = $product->get_review_count();
	?>

	<div class="product">

		<div id="product-<?php the_ID(); ?>" <?php post_class( 'product' ); ?>>

			<?php do_action( 'yith_wcqv_product_image' ); ?>

			<div class="eduvibe-yith-wcqv-wrapper summary entry-summary">
				<div class="summary-content">
					<?php //do_action( 'yith_wcqv_product_summary' ); ?>
					<?php 
						if ( $count_total_rating && wc_review_ratings_enabled() ) :
							echo '<div class="eduvibe-yith-wcqv-rating-wrapper">';
								woocommerce_template_single_rating();
								echo '<div class="eduvibe-yith-wcqv-rating-number">';
									$reviews_title = sprintf( esc_html( _n( '(%1$s Customer Review)', '(%1$s Customers Reviews)', $count_total_rating, 'eduvibe' ) ), esc_html( $count_total_rating ) );
									echo wp_kses_post( $reviews_title );
								echo '</div>';
							echo '</div>';
						endif;

						eduvibe_woocommerce_template_loop_product_author();

						woocommerce_template_single_title();
						
						echo '<div class="product-pricing">';
							woocommerce_template_single_price();
						echo '</div>';
						
						echo '<div class="product-description">';
							woocommerce_template_single_excerpt();
						echo '</div>';

						echo '<div class="product-cart-wrapper">';
							woocommerce_template_single_add_to_cart();
						echo '</div>';

						echo '<div class="product-meta">';
							woocommerce_template_single_meta();
						echo '</div>';
					?>
				</div>
			</div>

		</div>

	</div>
	<?php
endwhile; // end of the loop.
