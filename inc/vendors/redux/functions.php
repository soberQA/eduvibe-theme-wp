<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

if ( ! class_exists( 'EduVibe_Redux_Framework_Config' ) ) :
	class EduVibe_Redux_Framework_Config {

		public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            if ( ! class_exists( 'ReduxFramework' ) ) :
                return;
            endif;
            add_action( 'init', array( $this, 'initSettings' ), 10 );
        }

        public function initSettings() {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if ( ! isset( $this->args['opt_name'] ) ) : // No errors please
                return;
            endif;

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        public function setSections() {

            $columns = array( 
                '1' => __( '1 Column', 'eduvibe' ),
                '2' => __( '2 Columns', 'eduvibe' ),
                '3' => __( '3 Columns', 'eduvibe' ),
                '4' => __( '4 Columns', 'eduvibe' )
            );

            global $wp_registered_sidebars;
            $sidebars = array();

            if ( is_admin() && ! empty( $wp_registered_sidebars ) ) :
                foreach ( $wp_registered_sidebars as $sidebar ) :
                    $sidebars[$sidebar['id']] = $sidebar['name'];
                endforeach;
            endif;

            // General
            $this->sections[] = array(
                'icon'   => 'el el-website',
                'title'  => __( 'General', 'eduvibe' ),
                'fields' => array(
                    array(
                        'id'      => 'preloader',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Preloader at Website', 'eduvibe' ),
                        'default' => false
                    ),
                    array(
                        'id'       => 'preloader_type',
                        'type'     => 'select',
                        'title'    => __( 'Preloader Type', 'eduvibe' ),
                        'subtitle' => __( 'Choose a preloader for your website.', 'eduvibe' ),
                        'default'  => '3',
                        'options'  => array(
                            '1'    => 'Preloader 1',
                            '2'    => 'Preloader 2',
                            '3'    => 'Preloader 3'
                        ),
                        'required' => array( 'preloader', 'equals', true )
                    ),
                    array(
                        'id'      => 'smooth_scroll',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Smooth Scroll', 'eduvibe' ),
                        'default' => false
                    ),
                    array(
                        'id'      => 'mailchimp_api',
                        'type'    => 'text',
                        'default' => '6b38881989adf4b2160cd9290974f7d5-us2',
                        'title'   => __( 'MailChimp API Key', 'eduvibe' )
                    ),
                    array(
                        'id'      => 'google_map_api_key',
                        'type'    => 'text',
                        'default' => 'AIzaSyDQui8Qo1nZHxT3PXQuX4XnAcfhPn06kmI',
                        'title'   => __( 'Google Map API Key', 'eduvibe' )
                    ),
                    // array(
                    //     'id'      => 'custom_color',
                    //     'type'    => 'switch',
                    //     'on'      => __( 'Enable', 'eduvibe' ),
                    //     'off'     => __( 'Disable', 'eduvibe' ),
                    //     'title'   => __( 'Custom Color', 'eduvibe' ),
                    //     'default' => false
                    // ),
                    // array(
                    //     'id'       => 'body_color',
                    //     'type'     => 'color',
                    //     'title'    => __( 'Body Color', 'eduvibe' ), 
                    //     'subtitle' => __( 'Pick a color for the theme (default: #021E40).', 'eduvibe' ),
                    //     'default'  => '#021E40',
                    //     'required' => array( 'custom_color', 'equals', true )
                    // ),
                    // array(
                    //     'id'       => 'primary_color',
                    //     'type'     => 'color',
                    //     'title'    => __( 'Primary Color', 'eduvibe' ), 
                    //     'subtitle' => __( 'Pick a primary color for the theme (default: #3655C6).', 'eduvibe' ),
                    //     'default'  => '#3655C6',
                    //     'required' => array( 'custom_color', 'equals', true )
                    // )
                )
            );
            
            // Header
            $this->sections[] = array(
				'icon'   => 'el el-website',
				'title'  => __( 'Header', 'eduvibe' ),
				'fields' => array(
                    array(
						'id'       => 'header_type',
						'type'     => 'select',
						'title'    => __( 'Header Layout Type', 'eduvibe' ),
						'subtitle' => __( 'Choose a header for your website.', 'eduvibe' ),'default'  => 'theme-header-1',
						'options'  => eduvibe_get_header_layouts(),
						'desc'     => sprintf( wp_kses( __( 'You can add or edit a header in <a href="%s" target="_blank">Headers Builder</a>', 'eduvibe' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'edit.php?post_type=eduvibe_header' ) ) )
                    ),
                    array(
                        'id'      => 'sticky_header',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Sticky Header', 'eduvibe' ),
                        'default' => true
                    ),
                    array(
                        'id'       => 'custom_header_button_text',
                        'type'     => 'text',
                        'title'    => __( 'Header Button Text', 'eduvibe' ),
                        'desc'     => __( 'This text will replace the "Login / Register" text at "Theme Header 2" & "Theme Header 3".', 'eduvibe' )
                    ),
                    array(
                        'id'       => 'custom_header_button_url',
                        'type'     => 'text',
                        'title'    => __( 'Header Button URL', 'eduvibe' )
                    )
                )
            );

            // Footer
            $this->sections[] = array(
                'icon'   => 'el el-website',
                'title'  => __( 'Footer', 'eduvibe' ),
                'fields' => array(
                    array(
                        'id'       => 'footer_type',
                        'type'     => 'select',
                        'title'    => __( 'Footer Layout Type', 'eduvibe' ),
                        'subtitle' => __( 'Choose a footer for your website.', 'eduvibe' ),
                        'default'  => 'theme-default-footer',
                        'options'  => eduvibe_get_footer_layouts(),
                        'desc'     => sprintf( wp_kses( __( 'You can add or edit a footer in <a href="%s" target="_blank">Footers Builder</a>', 'eduvibe' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'edit.php?post_type=eduvibe_footer' ) ) )
                    ),
                    array(
                        'id'       => 'footer_custom_copyright_text',
                        'type'     => 'text',
                        'title'    => __( 'Footer Custom Copyright Text', 'eduvibe' ),
                        'desc'     => __( 'This text will replace the footer copyright text of <b>Theme Default Footer</b> only.', 'eduvibe' ),
                    ),
                    array(
                        'id'       => 'scroll_to_top',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'eduvibe' ),
                        'off'      => __( 'Disable', 'eduvibe' ),
                        'title'    => __( 'Scroll To Top Button', 'eduvibe' ),
                        'subtitle' => __( 'Toggle whether or not to enable a scroll to top button on your pages.', 'eduvibe' ),
                        'default'  => true
                    )
                )
            );

            // Page settings
            $this->sections[] = array(
                'icon'   => 'el el-pencil',
                'title'  => __( 'Page', 'eduvibe' ),
                'fields' => array(
                    array(
                        'id'      => 'show_page_breadcrumb',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Breadcrumbs', 'eduvibe' ),
                        'default' => true
                    ),
                    array(
                        'id'      => 'show_default_breadcrumb_at_page',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Show Default Breadcrumb Background', 'eduvibe' ),
                        'default' => true,
                        'required' => array( 'show_page_breadcrumb', 'equals', true )
                    ),
                    array (
                        'title'       => __( 'Breadcrumbs Background Color', 'eduvibe' ),
                        'subtitle'    => '<em>' . __( 'The breadcrumbs background color.', 'eduvibe' ) . '</em>',
                        'id'          => 'page_breadcrumb_color',
                        'type'        => 'color',
                        'required'    => array( 
                            array( 'show_page_breadcrumb', 'equals', true ),
                            array( 'show_default_breadcrumb_at_page', '!=', true )    
                        )
                    ),
                    array(
                        'id'       => 'page_breadcrumb_image',
                        'type'     => 'media',
                        'title'    => __( 'Breadcrumbs Background', 'eduvibe' ),
                        'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs background image.', 'eduvibe' ),
                        'default'  => array(
                            'url'  => get_template_directory_uri() . '/assets/images/eduvibe-breadcrumb-bg.jpg'
                        ),
                        'required'    => array( 
                            array( 'show_page_breadcrumb', 'equals', true ),
                            array( 'show_default_breadcrumb_at_page', '!=', true )    
                        )
                    )
                )
            );

            // Blog settings
            $this->sections[] = array(
                'icon'   => 'el el-pencil',
                'title'  => __( 'Blog', 'eduvibe' ),
                'fields' => array(
                    array(
                        'id'      => 'show_blog_breadcrumb',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Breadcrumbs', 'eduvibe' ),
                        'default' => true
                    ),
                    array(
                        'id'      => 'show_default_breadcrumb_at_blog',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Show Default Breadcrumb Background', 'eduvibe' ),
                        'default' => true,
                        'required' => array( 'show_blog_breadcrumb', 'equals', true )
                    ),
                    array (
                        'title'       => __( 'Breadcrumbs Background Color', 'eduvibe' ),
                        'subtitle'    => '<em>' . __( 'The breadcrumbs background color of the site. If there is no background image available only then this background color will be visible.', 'eduvibe' ) . '</em>',
                        'id'          => 'blog_breadcrumb_color',
                        'type'        => 'color',
                        'required'    => array( 
                            array( 'show_blog_breadcrumb', 'equals', true ),
                            array( 'show_default_breadcrumb_at_blog', '!=', true )    
                        )
                    ),
                    array(
                        'id'       => 'blog_breadcrumb_image',
                        'type'     => 'media',
                        'title'    => __( 'Breadcrumbs Background', 'eduvibe' ),
                        'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs.', 'eduvibe' ),
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/assets/images/eduvibe-breadcrumb-bg.jpg'
                        ),
                        'required'    => array( 
                            array( 'show_blog_breadcrumb', 'equals', true ),
                            array( 'show_default_breadcrumb_at_blog', '!=', true )    
                        )
                    )
                )
            );

            // Archive Blogs settings
            $this->sections[] = array(
                'subsection' => true,
                'title'      => __( 'Blog/Post Archive', 'eduvibe' ),
                'fields'     => array(
                    array(
                        'id'       => 'blog_archive_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Layout', 'eduvibe' ),
                        'default'  => 'right-sidebar',
                        'options'  => array(
                            'no-sidebar' => array(
                                'title'  => __( 'No Sidebar', 'eduvibe' ),
                                'alt'    => __( 'No Sidebar', 'eduvibe' ),
                                'img'    => get_template_directory_uri() . '/assets/images/sidebar-none.png'
                            ),
                            'left-sidebar'  => array(
                                'title'  => __( 'Left Sidebar', 'eduvibe' ),
                                'alt'    => __( 'Left Sidebar', 'eduvibe' ),
                                'img'    => get_template_directory_uri() . '/assets/images/sidebar-left.png'
                            ),
                            'right-sidebar' => array(
                                'title'  => __( 'Right Sidebar', 'eduvibe' ),
                                'alt'    => __( 'Right Sidebar', 'eduvibe' ),
                                'img'    => get_template_directory_uri() . '/assets/images/sidebar-right.png'
                            )
                        )
                    ),
                    array(
                        'id'       => 'blog_archive_sidebar_name',
                        'type'     => 'select',
                        'default'  => 'blog-sidebar',
                        'title'    => __( 'Select Sidebar', 'eduvibe' ),
                        'options'  => $sidebars,
                        'required' => array( 'blog_archive_layout', '!=', 'no-sidebar' )
                    ),
                    array(
                        'id'       => 'blog_post_style',
                        'type'     => 'select',
                        'title'    => __( 'Post Style', 'eduvibe' ),
                        'default'  => 'standard',
                        'options'  => array(
                            1      => 'Post 1',
                            2      => 'Post 2',
                            3      => 'Post 3',
                            'standard' => 'Post Standard'
                        )
                    ),
                    array(
                        'id'       => 'blog_post_columns',
                        'type'     => 'select',
                        'title'    => __( 'Post Columns', 'eduvibe' ),
                        'options'  => $columns,
                        'default'  => 2, // it's mandatory value is 2, before changing it, search for the param blog_post_columns and analyze it.
                        'required'  => array( 'blog_post_style', '!=', 'standard' )
                    ),
                    array(
                        'id'        => 'blog_post_excerpt_length',
                        'type'      => 'slider',
                        'title'     => __( 'Excerpt Length', 'eduvibe' ),
                        'default'   => 42,
                        'min'       => 1,
                        'step'      => 1,
                        'max'       => 250,
                        'required'  => array( 'blog_post_style', 'equals', 'standard' )
                    )
                )
            );

            // Single Blog settings
            $this->sections[] = array(
                'subsection' => true,
                'title'      => __( 'Post Single', 'eduvibe' ),
                'fields'     => array(
                    array(
                        'id'       => 'blog_single_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Layout', 'eduvibe' ),
                        'default'  => 'right-sidebar',
                        'options'  => array(
                            'no-sidebar' => array(
                                'title'  => __( 'No Sidebar', 'eduvibe' ),
                                'alt'    => __( 'No Sidebar', 'eduvibe' ),
                                'img'    => get_template_directory_uri() . '/assets/images/sidebar-none.png'
                            ),
                            'left-sidebar'  => array(
                                'title'  => __( 'Left Sidebar', 'eduvibe' ),
                                'alt'    => __( 'Left Sidebar', 'eduvibe' ),
                                'img'    => get_template_directory_uri() . '/assets/images/sidebar-left.png'
                            ),
                            'right-sidebar' => array(
                                'title'  => __( 'Right Sidebar', 'eduvibe' ),
                                'alt'    => __( 'Right Sidebar', 'eduvibe' ),
                                'img'    => get_template_directory_uri() . '/assets/images/sidebar-right.png'
                            )
                        )
                    ),
                    array(
                        'id'       => 'blog_single_sidebar_name',
                        'type'     => 'select',
                        'default'  => 'blog-sidebar',
                        'title'    => __( 'Select Sidebar', 'eduvibe' ),
                        'options'  => $sidebars,
                        'required' => array( 'blog_single_layout', '!=', 'no-sidebar' )
                    ),                    
                    array(
                        'id'        => 'featured_image_height',
                        'type'      => 'slider',
                        'title'     => __( 'Blog Feature Image Height', 'eduvibe' ),
                        'default'   => 450,
                        'min'       => 300,
                        'step'      => 1,
                        'max'       => 1250,
                        'desc'      => __( 'If you changed the image size, you have to regenerate thumbnails. You can use any regenerate thumbnails plugin for that.', 'eduvibe' ),
                    ),
                    array(
                        'id'        => 'featured_image_width',
                        'type'      => 'slider',
                        'title'     => __( 'Blog Feature Image Width', 'eduvibe' ),
                        'default'   => 770,
                        'min'       => 500,
                        'step'      => 1,
                        'max'       => 1500
                    ),
                    array(
                        'id'        => 'blog_single_catgory_and_social_share',
                        'type'      => 'switch',
                        'on'        => __( 'Enable', 'eduvibe' ),
                        'off'       => __( 'Disable', 'eduvibe' ),
                        'title'     => __( 'Category & Social Share', 'eduvibe' ),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog_single_author_bio',
                        'type'      => 'switch',
                        'on'        => __( 'Enable', 'eduvibe' ),
                        'off'       => __( 'Disable', 'eduvibe' ),
                        'title'     => __( 'Author Bio', 'eduvibe' ),
                        'default'   => true
                    )
                )
            );

            // Course settings
            $this->sections[] = array(
                'icon'   => 'el el-pencil',
                'title'  => __( 'Course', 'eduvibe' ),
                'fields' => array(
                    array(
                        'id'      => 'show_course_breadcrumb',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Breadcrumbs', 'eduvibe' ),
                        'default' => true
                    ),
                    array(
                        'id'      => 'show_default_breadcrumb_at_course',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Show Default Breadcrumb Background', 'eduvibe' ),
                        'default' => true,
                        'required' => array( 'show_course_breadcrumb', 'equals', true )
                    ),
                    array (
                        'title'       => __( 'Breadcrumbs Background Color', 'eduvibe' ),
                        'subtitle'    => '<em>' . __( 'The breadcrumbs background color of the site. If there is no background image available only then this background color will be visible.', 'eduvibe' ) . '</em>',
                        'id'          => 'course_breadcrumb_color',
                        'type'        => 'color',
                        'required'    => array( 
                            array( 'show_page_breadcrumb', 'equals', true ),
                            array( 'show_default_breadcrumb_at_course', '!=', true )    
                        )
                    ),
                    array(
                        'id'       => 'course_breadcrumb_image',
                        'type'     => 'media',
                        'title'    => __( 'Breadcrumbs Background', 'eduvibe' ),
                        'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs.', 'eduvibe' ),
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/assets/images/eduvibe-breadcrumb-bg.jpg'
                        ),
                        'required'    => array( 
                            array( 'show_page_breadcrumb', 'equals', true ),
                            array( 'show_default_breadcrumb_at_course', '!=', true )    
                        )
                    )
                )
            );

            if ( eduvibe_is_learnpress_activated() ) :
                // LearnPress Course Archive settings
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Courses Archive(LearnPress)', 'eduvibe' ),
                    'fields'     => array(
                        array(
                            'id'       => 'lp_course_style',
                            'type'     => 'select',
                            'title'    => __( 'Course Style', 'eduvibe' ),
                            'default'  => 1,
                            'options'  => array(
                                1      => 'Course 1',
                                2      => 'Course 2',
                                3      => 'Course 3',
                                4      => 'Course 4',
                                5      => 'Course 5',
                                6      => 'Course 6'
                            )
                        ),
                        array(
                            'id'      => 'lp_course_archive_top_bar',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Enable Top Bar on Course Archive Page.', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_course_index',
                            'type'     => 'switch',
                            'on'       => __( 'Enable', 'eduvibe' ),
                            'off'      => __( 'Disable', 'eduvibe' ),
                            'title'    => __( 'Total Number of Courses', 'eduvibe' ),
                            'default'  => true,
                            'required' => array( 'lp_course_archive_top_bar', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_course_search_bar',
                            'type'     => 'switch',
                            'on'       => __( 'Enable', 'eduvibe' ),
                            'off'      => __( 'Disable', 'eduvibe' ),
                            'title'    => __( 'Course Search Bar', 'eduvibe' ),
                            'default'  => true,
                            'required' => array( 'lp_course_archive_top_bar', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_course_white_bg',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Enable White Background', 'eduvibe' ),
                            'default' => false
                        ),
                        array(
                            'id'        => 'lp_course_excerpt_length',
                            'type'      => 'slider',
                            'title'     => __( 'Excerpt Length', 'eduvibe' ),
                            'default'   => 25,
                            'min'       => 1,
                            'step'      => 1,
                            'max'       => 250
                        ),
                        array(
                            'id'       => 'lp_course_button_text',
                            'type'     => 'text',
                            'title'    => __( 'Button Text', 'eduvibe' ),
                            'default'  => __( 'Enroll Now', 'eduvibe' ),
                            'desc'     => __( 'Default Text: Enroll Now', 'edublink' )
                        )
                    )
                );

                // LearnPress Single Course settings
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Course Single(LearnPress)', 'eduvibe' ),
                    'fields'     => array(
                        array(
                            'id'          => 'lp_course_details_style',
                            'type'        => 'select',
                            'title'       => __( 'Course Details Style', 'eduvibe' ),
                            'default'     => 1,
                            'options'     => array(
                                1         => 'Course 1',
                                2         => 'Course 2',
                            ),
                            'required' => array( 'lp_related_courses', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_related_courses',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Related Courses', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'          => 'lp_related_course_style',
                            'type'        => 'select',
                            'title'       => __( 'Related Course Style', 'eduvibe' ),
                            'default'     => 'default',
                            'options'     => array(
                                'default' => 'Default',
                                1         => 'Course 1',
                                2         => 'Course 2',
                                3         => 'Course 3',
                                4         => 'Course 4',
                                5         => 'Course 5'
                            ),
                            'required' => array( 'lp_related_courses', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_related_course_pre_title',
                            'type'     => 'text',
                            'title'    => __( 'Related Courses Pre Title', 'eduvibe' ),
                            'default'  => __( 'RELATED COURSES', 'eduvibe' ),
                            'required' => array( 'lp_related_courses', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_related_course_title',
                            'type'     => 'text',
                            'title'    => __( 'Related Courses Title', 'eduvibe' ),
                            'default'  => __( 'Courses You May Like', 'eduvibe' ),
                            'required' => array( 'lp_related_courses', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_instructor_tab',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Instructor Tab', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_instructor_tab_title',
                            'type'     => 'text',
                            'default'  => __( 'Instructor', 'eduvibe' ),
                            'title'    => __( 'Instructor Tab Title', 'eduvibe' ),
                            'required' => array( 'lp_instructor_tab', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_course_sidebar_options',
                            'type'     => 'section',
                            'title'    => __( 'Course Sidebar Options', 'eduvibe' ),
                            'indent'   => true
                        ),

                        array(
                            'id'      => 'lp_course_students',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Course Students', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_course_students_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Students.', 'eduvibe' ),
                            'desc'     => __( 'Default Text: Students', 'edublink' ),
                            'required' => array( 'lp_course_students', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_course_lessons',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Course Lessons', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_course_lessons_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Lessons.', 'eduvibe' ),
                            'desc'     => __( 'Default Text: Lessons', 'edublink' ),
                            'required' => array( 'lp_course_lessons', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_course_duration',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Course Duration', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_course_duration_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Duration', 'eduvibe' ),
                            'desc'     => __( 'Default Text: Duration', 'edublink' ),
                            'required' => array( 'lp_course_duration', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_course_certification',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Course Certification', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_course_certification_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Certification.', 'eduvibe' ),
                            'desc'     => __( 'Default Text: Certifications', 'edublink' ),
                            'required' => array( 'lp_course_certification', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_course_skill_level',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Course Skill Level', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_course_skill_level_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Skill Level.', 'eduvibe' ),
                            'desc'     => __( 'Default Text: Skill Level', 'edublink' ),
                            'required' => array( 'lp_course_skill_level', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_course_quizzes',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Course Quizzes', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_course_quizzes_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Quizzes.', 'eduvibe' ),
                            'desc'     => __( 'Default Text: Quizzes', 'edublink' ),
                            'required' => array( 'lp_course_quizzes', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_course_pass_percentage',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Course Pass Percentage', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_course_pass_percentage_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Pass Percentage.', 'eduvibe' ),
                            'desc'     => __( 'Default Text: Pass Percentage', 'edublink' ),
                            'required' => array( 'lp_course_pass_percentage', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_course_language',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Course Language', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_course_language_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Language.', 'eduvibe' ),
                            'desc'     => __( 'Default Text: Language', 'edublink' ),
                            'required' => array( 'lp_course_language', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_course_deadline',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Course Deadline', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_course_deadline_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Deadline.', 'eduvibe' ),
                            'desc'     => __( 'Default Text: Deadline', 'edublink' ),
                            'required' => array( 'lp_course_deadline', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_course_instructor',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Course Instructor', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_course_instructor_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Instructor.', 'eduvibe' ),
                            'desc'     => __( 'Default Text: Instructor', 'edublink' ),
                            'required' => array( 'lp_course_instructor', 'equals', true )
                        ),
                        array(
                            'id'    => 'lp_external_link_text',
                            'type'  => 'text',
                            'title' => __( 'External Button Text', 'edublink' ),
                            'desc'  => __( 'Default Text: More Info', 'edublink' )
                        ),
                        array(
                            'id'    => 'lp_purchase_button_text',
                            'type'  => 'text',
                            'title' => __( 'Purchase Button Text', 'edublink' ),
                            'desc'  => __( 'Default Text: Buy Now', 'edublink' )
                        ),
                        array(
                            'id'    => 'lp_enroll_button_text',
                            'type'  => 'text',
                            'title' => __( 'Enroll Button Text', 'edublink' ),
                            'desc'  => __( 'Default Text: Start Now', 'edublink' )
                        )
                    )
                );
            endif;

            // Events settings
            $this->sections[] = array(
                'icon'   => 'el el-pencil',
                'title'  => __( 'Events', 'eduvibe' ),
                'fields' => array(
                    array(
                        'id'      => 'show_event_breadcrumb',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Breadcrumbs', 'eduvibe' ),
                        'default' => true
                    ),
                    array(
                        'id'      => 'show_default_breadcrumb_at_event',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Show Default Breadcrumb Background', 'eduvibe' ),
                        'default' => true,
                        'required' => array( 'show_event_breadcrumb', 'equals', true )
                    ),
                    array (
                        'title'       => __( 'Breadcrumbs Background Color', 'eduvibe' ),
                        'subtitle'    => '<em>' . __( 'The breadcrumbs background color of the site. If there is no background image available only then this background color will be visible.', 'eduvibe' ) . '</em>',
                        'id'          => 'event_breadcrumb_color',
                        'type'        => 'color',
                        'required'    => array( 
                            array( 'show_page_breadcrumb', 'equals', true ),
                            array( 'show_default_breadcrumb_at_event', '!=', true )    
                        )
                    ),
                    array(
                        'id'       => 'event_breadcrumb_image',
                        'type'     => 'media',
                        'title'    => __( 'Breadcrumbs Background', 'eduvibe' ),
                        'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs.', 'eduvibe' ),
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/assets/images/eduvibe-breadcrumb-bg.jpg'
                        ),
                        'required'    => array( 
                            array( 'show_page_breadcrumb', 'equals', true ),
                            array( 'show_default_breadcrumb_at_event', '!=', true )    
                        )
                    )
                )
            );

            $this->sections[] = array(
                'subsection' => true,
                'title'      => __( 'Event Archive', 'eduvibe' ),
                'fields'     => array(
                    array(
                        'id'       => 'simple_event_style',
                        'type'     => 'select',
                        'title'    => __( 'Event Style', 'eduvibe' ),
                        'default'  => 1,
                        'options'  => array(
                            1      => 'Event 1',
                            'list' => 'Event 2(List)',
                        )
                    ),
                    array(
                        'id'      => 'simple_event_active_white_bg',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Enable White Background', 'eduvibe' ),
                        'default' => false
                    ),
                    array(
                        'id'        => 'simple_event_archive_page_items',
                        'type'      => 'slider',
                        'title'     => __( 'Number of Events Per Page', 'eduvibe' ),
                        'default'   => 6,
                        'min'       => -1,
                        'step'      => 1,
                        'max'       => 250
                    ),
                    array(
                        'id'       => 'simple_event_button_text',
                        'type'     => 'text',
                        'title'    => __( 'Button Text', 'eduvibe' ),
                        'default'  => __( 'Book A Seat', 'eduvibe' )
                    )
                )
            );

            $this->sections[] = array(
                'subsection' => true,
                'title'      => __( 'Event Single', 'eduvibe' ),
                'fields'     => array(
                    array(
                        'id'       => 'single_event_social_share',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'eduvibe' ),
                        'off'      => __( 'Disable', 'eduvibe' ),
                        'title'    => __( 'Social Share', 'eduvibe' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'single_event_details_meta',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'eduvibe' ),
                        'off'      => __( 'Disable', 'eduvibe' ),
                        'title'    => __( 'Event Meta', 'eduvibe' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'single_event_google_map',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'eduvibe' ),
                        'off'      => __( 'Disable', 'eduvibe' ),
                        'title'    => __( 'Google Map', 'eduvibe' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'single_event_price',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'eduvibe' ),
                        'off'      => __( 'Disable', 'eduvibe' ),
                        'title'    => __( 'Price', 'eduvibe' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'single_event_booking_button',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'eduvibe' ),
                        'off'      => __( 'Disable', 'eduvibe' ),
                        'title'    => __( 'Booking Button', 'eduvibe' ),
                        'default'  => true
                    ),
                    array(
                        'id'      => 'single_event_booking_button_text',
                        'type'    => 'text',
                        'title'   => __( 'Booking Button Text', 'eduvibe' ),
                        'default' => __( 'Book Your Seat Now', 'eduvibe' ),
                        'required' => array( 'single_event_booking_button', 'equals', true )
                    ),
                    array(
                        'id'       => 'single_event_meta_options',
                        'type'     => 'section',
                        'title'    => __( 'Event Meta Options', 'eduvibe' ),
                        'indent'   => true,
                        'required' => array( 'single_event_details_meta', 'equals', true )
                    ),
                    array(
                        'id'       => 'single_event_details_heading',
                        'type'     => 'text',
                        'title'    => __( 'Heading for Event Detail.', 'eduvibe' ),
                        'desc'     => __( 'Default Text: Event Detail', 'edublink' ),
                        'required' => array( 'single_event_details_meta', 'equals', true )
                    ),
                    array(
                        'id'       => 'single_event_start_date_label',
                        'type'     => 'text',
                        'title'    => __( 'Label for Start Date.', 'eduvibe' ),
                        'desc'     => __( 'Default Text: Start Date', 'edublink' ),
                        'required' => array( 'single_event_details_meta', 'equals', true )
                    ),
                    array(
                        'id'       => 'single_event_start_time_label',
                        'type'     => 'text',
                        'title'    => __( 'Label for Start Time.', 'eduvibe' ),
                        'desc'     => __( 'Default Text: Start Time', 'edublink' ),
                        'required' => array( 'single_event_details_meta', 'equals', true )
                    ),
                    array(
                        'id'       => 'single_event_end_date_label',
                        'type'     => 'text',
                        'title'    => __( 'Label for End Date.', 'eduvibe' ),
                        'desc'     => __( 'Default Text: End Date', 'edublink' ),
                        'required' => array( 'single_event_details_meta', 'equals', true )
                    ),
                    array(
                        'id'       => 'single_event_end_time_label',
                        'type'     => 'text',
                        'title'    => __( 'Label for End Time.', 'eduvibe' ),
                        'desc'     => __( 'Default Text: End Time', 'edublink' ),
                        'required' => array( 'single_event_details_meta', 'equals', true )
                    ),
                    array(
                        'id'       => 'single_event_participants_label',
                        'type'     => 'text',
                        'title'    => __( 'Label for Number of Participants.', 'eduvibe' ),
                        'desc'     => __( 'Default Text: Ongoing', 'edublink' ),
                        'required' => array( 'single_event_details_meta', 'equals', true )
                    ),
                    array(
                        'id'       => 'single_event_location_label',
                        'type'     => 'text',
                        'title'    => __( 'Label for Location.', 'eduvibe' ),
                        'desc'     => __( 'Default Text: Location', 'edublink' ),
                        'required' => array( 'single_event_details_meta', 'equals', true )
                    ),
                    array(
                        'id'       => 'single_event_price_label',
                        'type'     => 'text',
                        'title'    => __( 'Label for Price.', 'eduvibe' ),
                        'desc'     => __( 'Default Text: Price:', 'edublink' ),
                        'required' => array( 'single_event_details_meta', 'equals', true )
                    )
                )
            );

            if ( eduvibe_is_woocommerce_activated() ) :
                // WooCommerce  settings
                $this->sections[] = array(
                    'icon'   => 'el el-pencil',
                    'title'  => __( 'Shop Settings', 'eduvibe' ),
                    'fields' => array(
                        array(
                            'id'      => 'show_shop_breadcrumb',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Breadcrumbs', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'      => 'show_default_breadcrumb_at_shop',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Show Default Breadcrumb Background', 'eduvibe' ),
                            'default' => true,
                            'required' => array( 'show_shop_breadcrumb', 'equals', true )
                        ),
                        array (
                            'title'       => __( 'Breadcrumbs Background Color', 'eduvibe' ),
                            'subtitle'    => '<em>' . __( 'The breadcrumbs background color of the site. If there is no background image available only then this background color will be visible.', 'eduvibe' ) . '</em>',
                            'id'          => 'shop_breadcrumb_color',
                            'type'        => 'color',
                            'required'    => array( 
                                array( 'show_page_breadcrumb', 'equals', true ),
                                array( 'show_default_breadcrumb_at_shop', '!=', true )    
                            )
                        ),
                        array(
                            'id'       => 'shop_breadcrumb_image',
                            'type'     => 'media',
                            'title'    => __( 'Breadcrumbs Background', 'eduvibe' ),
                            'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs.', 'eduvibe' ),
                            'default'  => array(
                                'url' => get_template_directory_uri() . '/assets/images/eduvibe-breadcrumb-bg.jpg'
                            ),
                            'required'    => array( 
                                array( 'show_page_breadcrumb', 'equals', true ),
                                array( 'show_default_breadcrumb_at_shop', '!=', true )    
                            )
                        )
                    )
                );

                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Product Archive', 'eduvibe' ),
                    'fields'     => array(
                        array(
                            'id'        => 'woo_number_of_products',
                            'type'      => 'slider',
                            'title'     => __( 'Number of Products Per Page', 'eduvibe' ),
                            'default'   => 12,
                            'min'       => -1,
                            'step'      => 1,
                            'max'       => 100
                        ),
                        array(
                            'id'       => 'woo_product_columns',
                            'type'     => 'select',
                            'title'    => __( 'Product Columns', 'eduvibe' ),
                            'options'  => $columns,
                            'default'  => 4
                        )
                    )
                );

                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Shop Single', 'eduvibe' ),
                    'fields'     => array(
                        array(
                            'id'      => 'woo_related_products',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'eduvibe' ),
                            'off'     => __( 'Disable', 'eduvibe' ),
                            'title'   => __( 'Related Products', 'eduvibe' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'woo_related_products_subtitle',
                            'type'     => 'text',
                            'title'    => __( 'Related Products Sub Title', 'eduvibe' ),
                            'default'  => __( 'SIMILAR ITEMS', 'eduvibe' ),
                            'required' => array( 'woo_related_products', 'equals', true )
                        ),
                        array(
                            'id'       => 'woo_related_products_title',
                            'type'     => 'text',
                            'title'    => __( 'Related Products Title', 'eduvibe' ),
                            'default'  => __( 'Related Products', 'eduvibe' ),
                            'required' => array( 'woo_related_products', 'equals', true )
                        )
                    )
                );

            endif;

            // 404 page
            $this->sections[] = array(
                'title'  => __( '404 Page', 'eduvibe' ),
                'fields' => array(
                    array(
                        'id'      => 'error_page_title',
                        'type'    => 'text',
                        'title'   => __( 'Title', 'eduvibe' ),
                        'default' => __( 'Oops... Page Not Found!', 'eduvibe' )
                    ),
                    array(
                        'id'      => 'error_page_description',
                        'type'    => 'editor',
                        'title'   => __( 'Description', 'eduvibe' ),
                        'default' => __( 'Please return to the site\'s homepage, It looks like nothing was found at this location.', 'eduvibe' )
                    )
                )
            );

            // Social Media
            $this->sections[] = array(
                'icon'   => 'el el-file',
                'title'  => __( 'Social Media', 'eduvibe' ),
                'desc'   => __( 'This options will be applied at Event Details and Post Details page.', 'eduvibe' ),
                'fields' => array(
                    array(
                        'id'      => 'facebook_share',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Facebook', 'eduvibe' ),
                        'default' => true
                    ),
                    array(
                        'id'      => 'twitter_share',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Twitter', 'eduvibe' ),
                        'default' => true
                    ),
                    array(
                        'id'      => 'linkedin_share',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Linkedin', 'eduvibe' ),
                        'default' => true
                    ),
                    array(
                        'id'      => 'pinterest_share',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'eduvibe' ),
                        'off'     => __( 'Disable', 'eduvibe' ),
                        'title'   => __( 'Pinterest', 'eduvibe' ),
                        'default' => true
                    )
                )
            );

            // Custom Code
            $this->sections[] = array(
                'title'           => __( 'Import / Export', 'eduvibe' ),
                'desc'            => __( 'Import and Export your Redux Framework settings from file, text or URL.', 'eduvibe' ),
                'icon'            => 'el-icon-refresh',
                'fields'          => array(
                    array(
                        'id'         => 'opt-import-export',
                        'type'       => 'import_export',
                        'title'      => 'Import Export',
                        'subtitle'   => 'Save and restore your Redux options',
                        'full_width' => false
                    ),
                ),
            );
        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {
        	$theme = wp_get_theme(); // For use with some settings. Not necessary.
        	$this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'                    => apply_filters( 'eduvibe_theme_option_name', 'eduvibe_theme_options' ),
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'                => $theme->get( 'Name' ),
                // Name that appears at the top of your panel
                'display_version'             => $theme->get( 'Version' ),
                // Version that appears at the top of your panel
                'menu_type'                   => 'submenu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'              => true,
                // Show the sections below the admin menu item or not
                'menu_title'                  => __( 'Theme Options', 'eduvibe' ),
                'page_title'                  => __( 'Theme Options', 'eduvibe' ),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key'              => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly'        => false,
                // Must be defined to add google fonts to the typography module
                'async_typography'            => true,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar'                   => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon'              => 'dashicons-portfolio',
                // Choose an icon for the admin bar menu
                'admin_bar_priority'          => 50,
                // Choose an priority for the admin bar menu
                'global_variable'             => 'eduvibe_options',
                // Set a different name for your global variable other than the opt_name
                'dev_mode'                    => false,
                // Show the time the page took to load, etc
                'update_notice'               => false,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer'                  => true,
                // Enable basic customizer support
                //'open_expanded'             => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn'         => true,                    // Disable the save warning when a user changes a field
                
                // OPTIONAL -> Give you extra features
                'page_priority'               => null,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'                 => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'            => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon'                   => '',
                // Specify a custom URL to an icon
                'last_tab'                    => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon'                   => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug'                   => 'eduvibe_options',
                // Page slug used to denote the panel
                'save_defaults'               => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show'                => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark'                => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export'          => true,
                // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'              => 60 * MINUTE_IN_SECONDS,
                'output'                      => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'                  => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'            => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'                    => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'                 => false,
                // REMOVE
                'use_cdn'                     => true
            );
            return $this->args;
        }
    }
    global $reduxConfig;
    $reduxConfig = new EduVibe_Redux_Framework_Config();
endif;