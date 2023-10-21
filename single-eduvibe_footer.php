<?php
/**
 * The template for displaying the footer
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package EduVibe
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	echo '<div id="page" class="site">';
		echo '<a class="skip-link screen-reader-text" href="#content">' . __( 'Skip to content', 'eduvibe' ) . '</a>';
		echo '<div id="content" class="site-content">';
			while ( have_posts() ) : the_post();
				the_content();
			endwhile;
		echo '</div>';
	echo '</div>';
wp_footer();
echo '</body>';
echo '</html>';