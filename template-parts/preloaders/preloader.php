<?php

$preloader_type = eduvibe_get_config( 'preloader_type', '1' );
echo '<div id="eduvibe-preloader" class="eduvibe-preloader-wrapper eduvibe-preloader-' . esc_attr( $preloader_type ) . '-wrapper">';
	echo '<div class="eduvibe-preloader-inner">';
		get_template_part( 'template-parts/preloaders/preloader', $preloader_type );

		echo '<div class="eduvibe-preloader-close-btn-wraper">';
			echo '<span class="eduvibe-preloader-close-btn">';
				_e( 'Cancel Preloader', 'eduvibe' );
			echo '</span>';
		echo '</div>';
	echo '</div>';
echo '</div>';