<?php

/**
 * MetaBoxes for EduVibe
 *
 * @since 1.0.0
 */
namespace EduVibe;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * Metaboxes Class
 *
 * @since 1.0.0
 */ 
class Metaboxes {

	public static function init() {
		add_filter( 'cmb2_admin_init', array( __CLASS__, 'page_metabox' ) );
		add_filter( 'cmb2_admin_init', array( __CLASS__, 'event_metabox' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'team_metabox' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'woo_product_metabox' ) );
		if ( eduvibe_is_learnpress_activated() ) :
			add_filter( 'cmb2_admin_init', array( __CLASS__, 'lp_course_side_meta' ) );
		endif;
		if ( eduvibe_is_learndash_activated() ) :
			add_filter( 'cmb2_admin_init', array( __CLASS__, 'ld_course_metas' ) );
			add_filter( 'cmb2_admin_init', array( __CLASS__, 'ld_course_side_meta' ) );
		endif;
		if ( eduvibe_is_tutor_lms_activated() ) :
			add_filter( 'cmb2_admin_init', array( __CLASS__, 'tutor_course_features' ) );
		endif;
	}

	public static function get_course_levels() {
		$course_levels = array(
			'beginner'     => __( 'Beginner', 'eduvibe' ),
			'intermediate' => __( 'Intermediate', 'eduvibe' ),
			'advanced'     => __( 'Advanced', 'eduvibe' ),
			''             => __( 'None', 'eduvibe' )
	    );
	    $levels = array( 'all-level' => __( 'All Levels', 'eduvibe' ) );
	    $levels = array_merge( $levels, $course_levels );
	    return apply_filters( 'eduvibe_get_course_levels', $levels );
	}

	public static function page_metabox() {
		global $wp_registered_sidebars;
        $sidebars = array();
        if ( ! empty( $wp_registered_sidebars ) ) :
            foreach ( $wp_registered_sidebars as $sidebar ) :
                $sidebars[$sidebar['id']] = $sidebar['name'];
            endforeach;
        endif;

		$headers = array_merge( array( 'global' => __( 'Global Setting', 'eduvibe' ) ), eduvibe_get_header_layouts(), array( 'none' => __( 'None', 'eduvibe' ) ) );
		$footers = array_merge( array( 'global' => __( 'Global Setting', 'eduvibe' ) ), eduvibe_get_footer_layouts(), array( 'none' => __( 'None', 'eduvibe' ) ) );
		$prefix = 'eduvibe_page_';

		$page_meta = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Display Settings', 'eduvibe' ),
			'object_types' => array( 'page' ), // Post type
			'context'      => 'normal', //  'normal', 'advanced', or 'side'
			'priority'     => 'high',  //  'high', 'core', 'default' or 'low'
			'show_names'   => true // Show field names on the left
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'layout_type',
			'type'        => 'select',
			'name'        => __( 'Layout Type', 'eduvibe' ),
			'default'     => 'boxed',
			'options'     => array(
				'boxed'      => __( 'Boxed', 'eduvibe' ),
				'full-width' => __( 'Full Width', 'eduvibe' )
			)
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'content_type',
			'type'        => 'select',
			'name'        => __( 'Content Type', 'eduvibe' ),
			'default'     => 'full-width',
			'options'     => array(
				'no-sidebar'    => __( 'Only Content( No Sidebar )', 'eduvibe' ),
				'left-sidebar'  => __( 'Left Sidebar', 'eduvibe' ),
				'right-sidebar' => __( 'Right Sidebar', 'eduvibe' )
			),
			'description' => __( 'If you select <b>Full Width</b> Layout Type then this option won\'t work.', 'eduvibe' )
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'sidebar_name',
			'type'        => 'select',
			'name'        => __( 'Sidebar', 'eduvibe' ),
			'options'     => $sidebars,
			'description' => __( 'If you select <b>Full Width</b> from Layout Type or <b>Only Content( No Sidebar )</b> from Content Type then this selected sidebar won\'t display.', 'eduvibe' )
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'breadcrumb',
			'type'        => 'select',
			'name'        => __( 'Breadcrumb', 'eduvibe' ),
			'default'     => 'default',
			'options'     => array(
				'default' => __( 'Default', 'eduvibe' ),
				'enable'  => __( 'Enable', 'eduvibe' ),
				'disable' => __( 'Disable', 'eduvibe' )
			),
			'description' => __( 'This option won\'t work at the Front Page.', 'eduvibe' )
		) );

		$page_meta->add_field( array(
			'id'   => $prefix . 'breadcrumb_color',
			'type' => 'colorpicker',
			'name' => __( 'Breadcrumb Background Color', 'eduvibe' )
		) );

		$page_meta->add_field( array(
			'id'   => $prefix . 'breadcrumb_image',
			'type' => 'file',
			'name' => __( 'Breadcrumb Background Image', 'eduvibe' )
        ) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'header_type',
			'type'        => 'select',
			'name'        => __( 'Header Layout Type', 'eduvibe' ),
			'description' => __( 'Choose a header for your website.', 'eduvibe' ),
			'options'     => $headers,
			'default'     => 'global'
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'header_transparent',
			'type'        => 'select',
			'name'        => __( 'Header Transparent', 'eduvibe' ),
			'description' => __( 'Turn header into transparent. If page breadcrumb is disable then this option will work.', 'eduvibe' ),
			'default'     => 'default',
			'options'     => array(
				'default' => __( 'Default', 'eduvibe' ),
				'no'      => __( 'No', 'eduvibe' ),
				'yes'     => __( 'Yes', 'eduvibe' )
            )
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'footer_type',
			'type'        => 'select',
			'name'        => __( 'Footer Layout Type', 'eduvibe' ),
			'description' => __( 'Choose a footer for your website.', 'eduvibe' ),
			'options'     => $footers,
			'default'     => 'global'
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'extra_class',
			'type'        => 'text',
			'name'        => __( 'Extra Class', 'eduvibe' ),
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eduvibe' )
        ) );
	}

	public static function event_metabox() {
		$prefix = 'eduvibe_simple_event_';

		$event_meta = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Event Meta Information', 'eduvibe' ),
			'object_types' => array( 'simple_event' ),
			'context'      => 'normal',
			'priority'     => 'high', 
			'show_names'   => true
		) );

		$event_meta->add_field( array(
			'name' => __( 'Event Start Date', 'eduvibe' ),
			'id'   => $prefix . 'start_date',
			'type' => 'text'
		) );

		$event_meta->add_field( array(
			'name' => __( 'Event End Date', 'eduvibe' ),
			'id'   => $prefix . 'end_date',
			'type' => 'text'
		) );

		$event_meta->add_field( array(
			'name' => __( 'Event Start Time', 'eduvibe' ),
			'id'   => $prefix . 'start_time',
			'type' => 'text'
		) );

		$event_meta->add_field( array(
			'name' => __( 'Event End Time', 'eduvibe' ),
			'id'   => $prefix . 'end_time',
			'type' => 'text'
		) );

		$event_meta->add_field( array(
			'name' => __( 'Event Location', 'eduvibe' ),
			'id'   => $prefix . 'location',
			'type' => 'text'
		) );

		$event_meta->add_field( array(
			'name' => __( 'Ongoing People', 'eduvibe' ),
			'id'   => $prefix . 'perticipant',
			'type' => 'text'
		) );

		$event_meta->add_field( array(
			'name' => __( 'Latitude for Google Map', 'eduvibe' ),
			'id'   => $prefix . 'latitude',
			'type' => 'text'
		) );

		$event_meta->add_field( array(
			'name' => __( 'Longitude for Google Map', 'eduvibe' ),
			'id'   => $prefix . 'longitude',
			'type' => 'text'
		) );	

		$event_meta->add_field( array(
			'name' => __( 'Price', 'eduvibe' ),
			'id'   => $prefix . 'price',
			'type' => 'text'
		) );	

		$event_meta->add_field( array(
			'name'    => __( 'Purchase Link', 'eduvibe' ),
			'id'      => $prefix . 'purchase_link',
			'type'    => 'text',
			'default' => __( '#', 'eduvibe' )
		) );	
	}

	public static function team_metabox( array $metaboxes ) {
		$prefix = 'eduvibe_simple_team_';
		
		$metaboxes[ $prefix . 'info' ] = array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Team Information', 'eduvibe' ),
			'object_types' => array( 'simple_team' ),
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true,
			'fields'       => self::team_metaboxes()
		);

		return $metaboxes;
	}

	public static function team_metaboxes() {
        $prefix = 'eduvibe_simple_team_';

        $fields = array(
            array(
                'name'    => __( 'Designation', 'eduvibe' ),
                'id'      => $prefix . 'designation',
                'type'    => 'text',
                'default' => __( 'WordPress Expert', 'eduvibe' )
            ),
            array(
                'name'    => __( 'Email', 'eduvibe' ),
                'id'      => $prefix . 'email',
                'type'    => 'text',
                'default' => __( 'info@eduvibe.com', 'eduvibe' )
            ),
            array(
                'name'    => __( 'Phone', 'eduvibe' ),
                'id'      => $prefix . 'phone',
                'type'    => 'text',
                'default' => __( '619-986-9028', 'eduvibe' )
            ),
            array(
				'name' => __( 'Social Icons', 'eduvibe' ),
				'id'   => 'social_icons',
				'type' => 'title'
			),
			array(
                'name'    => __( 'Facebook', 'eduvibe' ),
                'id'      => $prefix . 'facebook',
                'type'    => 'text',
                'default' => '#'
            ),
			array(
                'name'    => __( 'Twitter', 'eduvibe' ),
                'id'      => $prefix . 'twitter',
                'type'    => 'text',
                'default' => '#'
            ),
			array(
                'name'    => __( 'Linkedin', 'eduvibe' ),
                'id'      => $prefix . 'linkedin',
                'type'    => 'text',
                'default' => '#'
            ),
			array(
                'name'    => __( 'Instagram', 'eduvibe' ),
                'id'      => $prefix . 'instagram',
                'type'    => 'text'
            ),
			array(
                'name'    => __( 'Pinterest', 'eduvibe' ),
                'id'      => $prefix . 'pinterest',
                'type'    => 'text'
            ),
			array(
                'name'    => __( 'Medium', 'eduvibe' ),
                'id'      => $prefix . 'medium',
                'type'    => 'text'
            ),
			array(
                'name'    => __( 'Dribbble', 'eduvibe' ),
                'id'      => $prefix . 'dribbble',
                'type'    => 'text'
            ),
			array(
                'name'    => __( 'Reddit', 'eduvibe' ),
                'id'      => $prefix . 'reddit',
                'type'    => 'text'
            ),
			array(
                'name'    => __( 'Youtube', 'eduvibe' ),
                'id'      => $prefix . 'youtube',
                'type'    => 'text'
            )
        );
        
        return apply_filters( 'eduvibe_simple_team_metabox_fields' , $fields, $prefix );
    }

	public static function woo_product_metabox( array $metaboxes ) {
		$prefix = 'eduvibe_woo_product_';
		
		$metaboxes[ $prefix . 'info' ] = array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Author Details', 'eduvibe' ),
			'object_types' => array( 'product' ),
			'context'      => 'side',
			'priority'     => 'low',
			'show_names'   => true,
			'fields'       => self::woo_product_metaboxes()
		);
		
		return $metaboxes;
	}

	public static function woo_product_metaboxes() {
		$prefix = 'eduvibe_woo_product_';

		$fields = array(
			array(
				'name'        => __( 'Name', 'eduvibe' ),
				'id'          => $prefix . 'author_name',
				'type'        => 'text',
				'description' => __( 'You can put the author name here.', 'eduvibe' )
			)
		);
		
		return apply_filters( 'eduvibe_woo_product_metabox_fields' , $fields, $prefix );
	}

	public static function lp_course_side_meta() {
		$prefix = 'eduvibe_lp_course_';

		$course_meta = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Course Meta', 'eduvibe' ),
			'object_types' => array( 'lp_course' ),
			'context'      => 'side',
			'priority'     => 'low', 
			'show_names'   => true
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Preview Image', 'eduvibe' ),
			'id'      => $prefix . 'preview_image',
			'type'    => 'file',
			'options' => array(
				'url' => false
			),
			'text'    => array(
				'add_upload_file_text' => __( 'Add Image', 'eduvibe' )
			),
			'description'  => __( 'This image will be shown at the course preview video background.', 'eduvibe' )
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Preview Video Link', 'eduvibe' ),
			'id'      => $prefix . 'preview_video_link',
			'type' => 'text',
			'default' => __( 'https://www.youtube.com/watch?v=pNje3bWz7V8', 'eduvibe' )
		) );
		
		$course_meta->add_field( array(
			'name'    => __( 'Language', 'eduvibe' ),
			'id'      => $prefix . 'language',
			'type' => 'text',
			'default' => __( 'English', 'eduvibe' )
		) );
		
		$course_meta->add_field( array(
			'name' => __( 'Certificate', 'eduvibe' ),
			'id'   => $prefix . 'certificate',
			'desc' => __( 'Set certificate course.', 'eduvibe' ),
			'std'  => 'yes',
			'default' => true,
			'type'    => 'checkbox'
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Deadline', 'eduvibe' ),
			'id'      => $prefix . 'deadline',
			'type'    => 'text',
			'default' => __( '25 Dec, 2023', 'eduvibe' )
		) );
		
	}

	public static function tutor_course_features() {
		$prefix = 'eduvibe_tutor_course_';

		$tl_course = new_cmb2_box( array(
			'id'           => $prefix . 'features',
			'title'        => __( 'Course Features', 'eduvibe' ),
			'object_types' => array( 'courses' ),
			'context'      => 'normal',
			'priority'     => 'core', 
			'show_names'   => true
		) );

		$group_field_id = $tl_course->add_field( array(
			'id'           => $prefix . 'top_features',
			'type'         => 'group',
			'name'         => __( 'Features', 'eduvibe' ),
			'description'  => __( 'This features will be shown only on Course Style 3', 'eduvibe' ),
			'options'      => array(
				'group_title'      => __( 'Feature {#}', 'eduvibe' ),
				'add_button'       => __( 'Add Another Feature', 'eduvibe' ),
				'remove_button'    => __( 'Remove Feature', 'eduvibe' ),
				'sortable'         => true
			),
			'fields'       => array(
	            array(
	                'name' => __( 'Feature', 'eduvibe' ),
	                'id'   => 'name',
	                'type' => 'text'
	            )
	        )
		) );
	}

	public static function ld_course_metas() {
		$prefix = 'eduvibe_ld_course_';

		$ld_course = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'LearnDash Custom Meta', 'eduvibe' ),
			'object_types' => array( 'sfwd-courses' ),
			'context'      => 'normal',
			'priority'     => 'low', 
			'show_names'   => true
		) );

		$ld_course->add_field( array(
			'name' => __( 'Estimated Duration', 'eduvibe' ),
			'desc' => __( '6 hours, 30 minutes', 'eduvibe' ),
			'id'   => $prefix . 'duration',
			'type' => 'text'
		) );

		$ld_course->add_field( array(
			'name'             => __( 'Course Level', 'eduvibe' ),
			'id'               => $prefix . 'level',
			'type'             => 'select',
			'default'          => 'beginner',
			'options'          => apply_filters( 'eduvibe_ld_course_levels', array(
				'all-level'    => __( 'All Levels', 'eduvibe' ),
				'beginner'     => __( 'Beginner', 'eduvibe' ),
				'intermediate' => __( 'Intermediate', 'eduvibe' ),
				'advanced'     => __( 'Advanced', 'eduvibe' )
	        ) )
		) );

		$ld_course->add_field( array(
			'name' => __( 'Course Language', 'eduvibe' ),
			'desc' => __( 'The instructor used this language while conducting the course.', 'eduvibe' ),
			'id'   => $prefix . 'language',
			'type' => 'text'
		) );

		$ld_course->add_field( array(
			'name' => __( 'Number of Enrolled Students', 'eduvibe' ),
			'id'   => $prefix . 'students',
			'type' => 'text'
		) );

		$ld_course->add_field( array(
			'name' => __( 'Pass Mark', 'eduvibe' ),
			'id'   => $prefix . 'pass_mark',
			'type' => 'text',
			'default' => __( '80', 'eduvibe' )
		) );

		$ld_course->add_field( array(
			'name' => __( 'Access', 'eduvibe' ),
			'id'   => $prefix . 'access',
			'type' => 'text',
			'std'  => __( 'Lifetime', 'eduvibe' )
		) );

		$ld_course->add_field( array(
			'name' => __( 'Deadline', 'eduvibe' ),
			'id'   => $prefix . 'deadline',
			'type' => 'text',
			'std'  => __( '21 Sep, 2021', 'eduvibe' )
		) );

		$ld_course->add_field( array(
			'name' => __( 'Preview Video Link', 'eduvibe' ),
			'id'   => $prefix . 'preview_video_link',
			'type' => 'text',
			'default' => __( 'https://www.youtube.com/watch?v=pNje3bWz7V8', 'eduvibe' )
		) );

		$group_field_id = $ld_course->add_field( array(
			'id'          => $prefix . 'top_features',
			'type'        => 'group',
			'name'        => __( 'Features', 'eduvibe' ),
			'description' => __( 'This features will be shown only on Course Style 3', 'eduvibe' ),
			'options'     => array(
				'group_title'      => __( 'Feature {#}', 'eduvibe' ),
				'add_button'       => __( 'Add Another Feature', 'eduvibe' ),
				'remove_button'    => __( 'Remove Feature', 'eduvibe' ),
				'sortable'         => true,
				'closed'           => false
			)
		) );

		$ld_course->add_group_field( $group_field_id, array(
			'name'       => __( 'Feature', 'eduvibe' ),
			'id'         => $prefix . 'title',
			'type'       => 'text'
		) );
	}

	public static function ld_course_side_meta() {
		$prefix = 'eduvibe_ld_course_';

		$ld_course = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Course Meta', 'eduvibe' ),
			'object_types' => array( 'sfwd-courses' ),
			'context'      => 'side',
			'priority'     => 'low', 
			'show_names'   => true
		) );

		$ld_course->add_field( array(
			'name'    => __( 'Preview Image', 'eduvibe' ),
			'id'      => $prefix . 'preview_image',
			'type'    => 'file',
			'options' => array(
				'url' => false
			),
			'text'    => array(
				'add_upload_file_text' => __( 'Add Image', 'eduvibe' )
			),
			'description'  => __( 'This image will be shown at the course preview video background.', 'eduvibe' )
		) );
		
	}
}

Metaboxes::init();