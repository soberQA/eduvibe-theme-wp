<?php $full_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); ?>

<ul class="eduvibe-social-share-icons-wrapper">
	<?php do_action( 'eduvibe_social_share_items_before' ); ?>

	<?php if ( eduvibe_get_config( 'linkedin_share', true ) ) : ?>
 		<li class="eduvibe-social-share-each-icon linkedin">
			<a class="eduvibe-social-share-link" href="https://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" target="_blank" title="<?php esc_attr_e( 'Share on LinkedIn', 'eduvibe' ); ?>">
				<i class="icon-linkedin"></i>
			</a>
 		</li>
	<?php endif; ?>
	
	<?php if ( eduvibe_get_config( 'facebook_share', true ) ) : ?>
		<li class="eduvibe-social-share-each-icon facebook">
			<a class="eduvibe-social-share-link" href="https://www.facebook.com/sharer.php?s=100&u=<?php the_permalink(); ?>&i=<?php echo urlencode($full_image ? $full_image[0] : ''); ?>" target="_blank" title="<?php esc_attr_e( 'Share on facebook', 'eduvibe' ); ?>">
				<i class="icon-Fb"></i>
			</a>
	 	</li>
	<?php endif; ?>
	<?php if ( eduvibe_get_config( 'twitter_share', true ) ) : ?>
 		<li class="eduvibe-social-share-each-icon twitter">
			<a class="eduvibe-social-share-link" href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>" target="_blank" title="<?php esc_attr_e( 'Share on Twitter', 'eduvibe' ); ?>">
				<i class="icon-Twitter"></i>
			</a>
 		</li>
	<?php endif; ?>

	<?php if ( eduvibe_get_config( 'pinterest_share', false ) ) : ?>
 		<li class="eduvibe-social-share-each-icon pinterest">
			<a class="eduvibe-social-share-link" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;description=<?php echo urlencode($post->post_title); ?>&amp;media=<?php echo urlencode( $full_image ? $full_image[0] : '' ); ?>" target="_blank" title="<?php esc_attr_e( 'Share on Pinterest', 'eduvibe' ); ?>">
				<i class="icon-Pinterest"></i>
			</a>
 		</li>
	<?php endif; ?>
	<?php do_action( 'eduvibe_social_share_items_after' ); ?>
</ul>