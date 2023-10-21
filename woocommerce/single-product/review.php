<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">
		<div class="eduvibe-woo-review the-comment">
			<div class="avatar">
				<?php echo get_avatar( $comment->user_id, apply_filters( 'woocommerce_review_gravatar_size', '80' ), '' ); ?>
			</div>

			<div class="comment-box">
				<div class="eduvibe-woo-review-info">
					<div class="reviewer-name-date">
						<h3 class="name-comment"><?php comment_author(); ?></h3>
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<div class="date"><em><?php esc_html_e( 'Your comment is awaiting approval', 'eduvibe' ); ?></em></div>
						<?php else : ?>
							<div class="date">
								<?php
									if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' )
										if ( wc_customer_bought_product( $comment->comment_author_email, $comment->user_id, $comment->comment_post_ID ) )
											echo '<em class="verified">(' . esc_html__( 'verified owner', 'eduvibe' ) . ')</em> ';

								?><time itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' ); ?>"><?php echo get_comment_date( wc_date_format() ); ?></time>
							</div>
						<?php endif; ?>
					</div>

					<?php if ( $rating && wc_review_ratings_enabled() ) : ?>
						<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating ms-auto" title="<?php echo sprintf( esc_attr__( 'Rated %d out of 5', 'eduvibe' ), $rating ) ?>">
							<span style="width:<?php echo esc_attr(( $rating / 5 ) * 100); ?>%"><strong itemprop="ratingValue"><?php echo trim($rating); ?></strong> <?php esc_html_e( 'out of 5', 'eduvibe' ); ?></span>
						</div>
					<?php endif; ?>
				</div>

				<div itemprop="description" class="comment-text"><?php comment_text(); ?></div>
			</div>
		</div>
	</div>
