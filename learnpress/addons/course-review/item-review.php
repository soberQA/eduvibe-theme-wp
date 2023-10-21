<?php
/**
 * Template for displaying loop course review.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/course-review/loop-review.php.
 *
 * @author ThimPress
 * @package LearnPress/Course-Review/Templates
 * version  3.0.2
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! isset( $review ) ) {
	return;
}
?>

<li>
	<div class="review-author">
		<?php echo get_avatar( $review->user_email ?? '' ); ?>
	</div>
	<div class="review-author-info">
        <div class="review-top">
            <h4 class="user-name">
                <?php do_action( 'learn_press_before_review_username' ); ?>
                <?php 
                    if ( $review->display_name ) :
                        echo wp_kses_post( $review->display_name ); 
                    endif;        
                ?>
                <?php do_action( 'learn_press_after_review_username' ); ?>
            </h4>
            <?php
            LP_Addon_Course_Review_Preload::$addon->get_template(
                'rating-stars.php',
                [ 'rated' => $review->rate ?? '' ]
            );
            ?>
        </div>

        <p class="review-title">
            <?php do_action( 'learn_press_before_review_title' ); ?>
            <?php 
                if ( $review->title ) :
                    echo wp_kses_post( $review->title ); 
                endif;        
            ?>
            <?php do_action( 'learn_press_after_review_title' ); ?>
        </p>

        <div class="review-text">
            <div class="review-content">
                <?php do_action( 'learn_press_before_review_content' ); ?>
                <?php 
                    if ( $review->content ) :
                        echo wp_kses_post( $review->content ); 
                    endif;        
                ?>
                <?php do_action( 'learn_press_after_review_content' ); ?>
            </div>
        </div>
	</div>
</li>
