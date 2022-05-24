<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$settings = array(
	'menu_title' 		=> 'Theme options',
	'menu_type'  		=> 'menu',
	'menu_slug'  		=> 'sanjose-options',
	'ajax_save'  		=> true,
	'show_reset_all' 	=> true,
	'framework_title'	=> 'Theme options <small>by Foxthemes</small>',
);

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options = array();

// ----------------------------------------
// General option section
// ----------------------------------------
$options[] = array(
	'name'        => 'general',
	'title'       => 'General',
	'icon'        => 'fa fa-globe',
	'fields'      => array(
		array(
			'id'      => 'page_preloader',
			'type'    => 'switcher',
			'title'   => 'Page preloader',
			'default' => true
		),
        array(
            'id'      => 'enable_human_diff',
            'type'    => 'switcher',
            'title'   => 'Show time passed after post was published',
            'default' => true
        ),
	)
);

// ----------------------------------------
// Typography option section
// ----------------------------------------
$options[] = array(
	'name'        => 'typography',
	'title'       => 'Typography',
	'icon'        => 'fa fa-font',
	'fields'      => array(
		array(
			'type'    => 'subheading',
			'content' => 'Global typography style',
		),
		array(
			'id'              => 'typography_style',
			'type'            => 'group',
			'title'           => 'Typography Headings',
			'button_title'    => 'Add New',
			'accordion_title' => 'Add New Icon',

			// begin: fields
			'fields'      => array(

			    // header size
			    array(
					'id'             => 'heading_tag',
					'type'           => 'select',
					'title'          => 'Title Tag',
					'options'        => array(
						'h1'    => esc_html__('H1','antica'),
						'h2'    => esc_html__('H2','antica'),
						'h3'    => esc_html__('H3','antica'),
						'h4'    => esc_html__('H4','antica'),
						'h5'    => esc_html__('H5','antica'),
						'h6'    => esc_html__('H6','antica'),
						'p'     => esc_html__('Paragraph','antica'),
						'span'  => esc_html__('Span','antica'),
						'a'     => esc_html__('Link','antica'),
					),
			    ),

			    // font family
			    array(
					'id'        => 'heading_family',
					'type'      => 'typography',
					'title'     => 'Font Family',
					'default'   => array(
						'family'  => 'Lato',
						'variant' => 'regular',
						'font'    => 'google', // this is helper for output
					),
			    ),

			    // font size
			    array(
					'id'          => 'heading_size',
					'type'        => 'text',
					'title'       => 'Font Size',
					'default'     => '24',
			    ),

			    // font color
			    array(
					'id'      => 'heading_color',
					'type'    => 'color_picker',
					'title'   => 'Font Color',
			    ),
			),
		),
		array(
			'type'    => 'subheading',
			'content' => 'Menu typography style',
		),
		array(
			'id'      => 'default_header_typography',
			'type'    => 'switcher',
			'title'   => 'Default header typography',
			'default' => true
		),
		array(
			'id'        => 'header_typography_group',
			'type'      => 'fieldset',
			'title'     => 'Menu typography',
			'fields'    => array(
				array(
					'id'      => 'header_typography',
					'type'    => 'typography',
					'title'   => 'Font',
					'default'   => array(
						'font'    => 'google',
					),
				),
				array(
					'id'      => 'header_font_size',
					'type'    => 'number',
					'title'   => 'Menu font size',
					'after'   => ' <i class="cs-text-muted">(px)</i>'
				),
				array(
					'id'      => 'header_font_color',
					'type'    => 'color_picker',
					'title'   => 'Menu font color',
				),
			),
			'dependency' => array( 'default_header_typography', '==', true )
		),
	)
);

// ----------------------------------------
// Theme colors
// ----------------------------------------
$options[]      = array(
  'name'        => 'theme_colors',
  'title'       => 'Theme Color',
  'icon'        => 'fa fa-magic',

  // begin: fields
  'fields'      => array(

      array(
        'id'      => 'base_color',
        'type'    => 'color_picker',
        'title'   => 'Base Color',
        'rgba'    => true,
      ),

      array(
        'id'      => 'front_base_color',
        'type'    => 'color_picker',
        'title'   => 'Front Base Color',
        'rgba'    => true,
      ),

      array(
        'id'      => 'front_other_color',
        'type'    => 'color_picker',
        'title'   => 'Front Color',
        'rgba'    => true,
      ),

      array(
        'id'      => 'other_color',
        'type'    => 'color_picker',
        'title'   => 'Other Color',
        'rgba'    => true,
      ),

  ), // end: fields
);

// ----------------------------------------
// Header option section
// ----------------------------------------
$options[] = array(
	'name'        => 'header',
	'title'       => 'Header',
	'icon'        => 'fa fa-arrow-up',
	'fields'      => array(
		array(
			'type'    => 'subheading',
			'content' => 'Other settings',
		),

        array(
            'id'      => 'sticky_header',
            'type'    => 'switcher',
            'title'   => 'Sticky header',
            'default' => true
        ),
        array(
            'id'      => 'button_color',
            'type'    => 'color_picker',
            'title'   => 'Button Color',
            'default' => '3b55e6',
            'rgba'    => true,
        ),
		array(
			'id'         => 'logo_type',
			'type'       => 'select',
			'title'      => 'Logo type',
			'options'    => array(
				'image'   => 'Image',
				'text'    => 'Text'
			),
			'default' => 'text'
		),
		array(
			'id'         => 'site_logo',
			'type'       => 'upload',
			'title'      => 'Site Logo',
			'desc'       => 'Upload any media using the WordPress Native Uploader.',
			'dependency' => array( 'logo_type', '==', 'image' )
		),
		array(
			'id'         => 'retina_logo',
			'type'       => 'upload',
			'title'      => 'Retina Logo',
			'desc'       => 'Upload any media using the WordPress Native Uploader.',
			'dependency' => array( 'logo_type', '==', 'image' )
		),
		array(
			'id'         => 'text_logo',
			'type'       => 'textarea',
			'title'      => 'Text logo',
			'default'    => 'Sanjose',
			'dependency' => array( 'logo_type', '==', 'text' )
		),
        array(
            'id'      => 'text_color',
            'type'    => 'color_picker',
            'title'   => 'Text color',
            'default' 	  => '#fff',
            'dependency' => array( 'logo_type', '==', 'text' )
        ),
		array(
			'id'         => 'text_logo_font_size',
			'type'       => 'number',
			'title'      => 'Text logo font size',
			'dependency' => array( 'logo_type', '==', 'text' )
		),

        array(
            'id'        => 'header_other_links',
            'type'      => 'fieldset',
            'title'     => 'Other links',
            'fields'    => array(

                array(
                    'id'         => 'first_link_text',
                    'type'       => 'text',
                    'title'      => 'First link Text'
                ),
                array(
                    'id'     => 'first_link_url',
                    'type'   => 'text',
                    'title'  => 'First link Url'
                ),

                array(
                    'id'         => 'second_link_text',
                    'type'       => 'text',
                    'title'      => 'Second link Text'
                ),
                array(
                    'id'     => 'second_link_url',
                    'type'   => 'text',
                    'title'  => 'Second link Url'
                ),

            ),
        ),
	) // end: fields
);

// ----------------------------------------
// Footer option section                  -
// ----------------------------------------
$author_url = 'foxthemes.com';
$options[] = array(
	'name'        => 'footer',
	'title'       => 'Footer',
	'icon'        => 'fa fa-arrow-down',
	'fields'      => array(
		array(
			'type'    => 'subheading',
			'content' => 'Other settings',
		),
        array(
            'id'      => 'button_color_botton',
            'type'    => 'color_picker',
            'title'   => 'Button Color',
            'default' => '3b55e6',
            'rgba'    => true,
        ),
		array(
			'id'      => 'footer_subscribe',
			'type'    => 'switcher',
			'title'   => 'Footer subscribe',
			'default' => true
		),
		array(
			'id'      => 'footer_subscribe_shortcode',
			'type'    => 'textarea',
			'title'   => 'Subscribe shortcode',
			'desc'    => 'Please, paste here your shortcode',
			'dependency' => array( 'footer_subscribe', '==', true )
		),
        array(
            'id'      => 'footer_other_links',
            'type'    => 'switcher',
            'title'   => 'Footer other links',
            'default' => true
        ),
        array(
            'id'           => 'footer_other_list',
            'type'         => 'group',
            'title'        => 'Footer other list',
            'button_title' => 'Add New',
            'fields'       => array(
                array(
                    'id'          => 'footer_other_link',
                    'type'        => 'text',
                    'title'       => 'Url'
                ),
                array(
                    'id'          => 'footer_other_text',
                    'type'        => 'text',
                    'title'       => 'Text'
                )
            ),
            'default' => array(
                array(
                    'footer_other_link' => '#',
                    'footer_other_text' => 'Useful Links'
                ),
            ),
            'dependency' => array( 'footer_other_links', '==', true )
        ),
		array(
			'id'         => 'footer_copyright',
			'type'       => 'textarea',
			'title'      => 'Copyright text',
			'default'    => '&copy; 2017. Create with love by <a href="' . esc_url( $author_url ) . '">Foxthemes</a>',
		),

	) // end: fields
);

// ----------------------------------------
// Blog                                   -
// ----------------------------------------
$options[] = array(
	'name'        => 'blog',
	'title'       => 'Blog',
	'icon'        => 'fa fa-book',
	'fields'      => array(
        array(
            'type'    => 'heading',
            'content' => 'Banner blog',
        ),
		array(
			'id'      	 => 'banner_blog',
			'type'    	 => 'switcher',
			'title'   	 => 'Show/Hide Banner Blog',
			'default' 	 => true
		),
        array(
            'id'      	 => 'banner_image',
            'type'    	 => 'upload',
            'title'   	 => 'Banner image',
            'desc'    	 => 'Upload any media using the WordPress Native Uploader.',
            'dependency' => array( 'banner_blog', '==', true )
        ),
        array(
            'id'      	 => 'banner_blog_title',
            'type'    	 => 'textarea',
            'title'   	 => 'Banner title',
            'dependency' => array( 'banner_blog', '==', true )
        ),
        array(
            'id'      	 => 'banner_blog_subtitle',
            'type'    	 => 'text',
            'title'   	 => 'Banner subtitle',
            'dependency' => array( 'banner_blog', '==', true )
        ),
        array(
            'id'        => 'banner_link',
            'type'      => 'fieldset',
            'title'     => 'Banner blog link',
            'fields'    => array(

                array(
                    'id'      	 => 'banner_blog_link',
                    'type'    	 => 'text',
                    'title'   	 => 'Banner link URI',
                ),
                array(
                    'id'      	 => 'banner_blog_link_text',
                    'type'    	 => 'text',
                    'title'   	 => 'Banner link text',
                ),

            ),
            'dependency' => array( 'banner_blog', '==', true )
        ),
        array(
            'type'    => 'heading',
            'content' => 'Other settings',
        ),
        array(
            'id'      => 'blog_style',
            'type'    => 'select',
            'title'   => 'Blog style',
            'options' => array(
                'default'    => 'Default',
                'modern'     => 'Modern',
                'vertical'   => 'Vertical',
            )
        ),
        array(
            'id'      => 'blog_sidebar',
            'type'    => 'select',
            'title'   => 'Blog sidebar',
            'options' => array(
                'left'    => 'Left',
                'right'   => 'Right',
                'disable' => 'Disable'
            ),
            'default' => 'right'
        ),
        array(
            'id'      => 'pagination_style',
            'type'    => 'select',
            'title'   => 'Pagination style',
            'options' => array(
                'default'       => 'Default',
                'load_more'     => 'Load More',
            )
        ),
	)
);

// ----------------------------------------
// Single                                 -
// ----------------------------------------
$options[] = array(
    'name'        => 'single',
    'title'       => 'Single',
    'icon'        => 'fa fa-file-text-o',
    'fields'      => array(
        array(
            'type'    => 'heading',
            'content' => 'Banner post',
        ),

        array(
            'id'       => 'style_banner',
            'type'     => 'select',
            'title'    => 'Banner style',
            'options'  => array(
                'style_1'  =>  'Style 1',
                'style_2'  =>  'Style 2',
                'style_3'  =>  'Style 3',
                'style_4'  =>  'Style 4',
                'style_5'  =>  'Style 5',
                'style_6'  =>  'Style 6',
            ),
        ),
        array(
            'id'    => 'title_banner',
            'type'  => 'textarea',
            'title' => 'Title',
        ),

        // for all styles banner but not banner style 3, style 5
        array(
            'id'    => 'subtitle_banner',
            'type'  => 'text',
            'title' => 'Subtitle',
            'dependency'   => array( 'style_banner', 'any', 'style_1,style_2,style_4,style_6'  ),
        ),

        array(
            'id'    => 'text_banner',
            'type'  => 'textarea',
            'title' => 'Text',
        ),
        // for all styles banner but not banner style 4
        array(
            'id'       => 'type_banner',
            'type'     => 'select',
            'title'    => 'Type banner',
            'options'  => array(
                'image'  =>  'Image',
                'video'  =>  'Video',
                'particles'  =>  'Particles',
            ),
            'dependency'   => array( 'style_banner', '!=', 'style_4' ),
        ),

        // for type banner image and style banner all but not style banner 4
        array(
            'id'        => 'bg_banner',
            'type'      => 'image',
            'title'     => 'Image Background',
            'dependency'   => array( 'type_banner|style_banner', '==|!=', 'image|style_4' ),
        ),
        array(
            'id'    => 'check_paralax',
            'type'  => 'switcher',
            'title' => 'Enable paralax effect',
            'dependency'   => array( 'type_banner|style_banner', '==|!=', 'image|style_4' ),
        ),

        // for type banner video and style banner all but not style banner 4
        array(
            'id'    => 'video_url',
            'type'  => 'text',
            'title' => 'Video url',
            'dependency'   => array( 'type_banner|style_banner', '==|!=', 'video|style_4' ),
        ),

        // for banner style 1, 2
        array(
            'id'        => 'image_content',
            'type'      => 'image',
            'title'     => 'Image content',
            'dependency'   => array( 'style_banner', 'any', 'style_1,style_2' ),
        ),

        // for all styles banner but not banner style 5
        array(
            'id'        => 'banner_link',
            'type'      => 'fieldset',
            'title'     => 'Banner post link',
            'fields'    => array(

                array(
                    'id'      	 => 'banner_post_link',
                    'type'    	 => 'text',
                    'title'   	 => 'Banner link URI',
                ),
                array(
                    'id'      	 => 'banner_post_link_text',
                    'type'    	 => 'text',
                    'title'   	 => 'Banner link text',
                ),

            ),
            'dependency'   => array( 'style_banner', '!=', 'style_5' ),
        ),

        // for banner style 2
        array(
            'type'    => 'heading',
            'content' => 'Buttons banner',
            'dependency'   => array( 'style_banner', '==', 'style_2' ),
        ),
        array(
            'id'    => 'first_button_url',
            'type'  => 'text',
            'title' => 'First button url',
            'dependency'   => array( 'style_banner', '==', 'style_2' ),
        ),
        array(
            'id'    => 'first_button_image',
            'type'  => 'image',
            'title' => 'First button image',
            'dependency'   => array( 'style_banner', '==', 'style_2' ),
        ),
        array(
            'id'    => 'second_button_url',
            'type'  => 'text',
            'title' => 'Second button url',
            'dependency'   => array( 'style_banner', '==', 'style_2' ),
        ),
        array(
            'id'    => 'second_button_image',
            'type'  => 'image',
            'title' => 'Second button image',
            'dependency'   => array( 'style_banner', '==', 'style_2' ),
        ),

        // for banner style 5
        array(
            'id'    => 'mailchimp_form',
            'type'  => 'text',
            'title' => 'Mailchimp form',
            'dependency'   => array( 'style_banner', '==', 'style_5' ),
        ),

        // for banner style 6
        array(
            'type'    => 'heading',
            'content' => 'Gradient colors banner',
            'dependency'   => array( 'style_banner', '==', 'style_6' ),
        ),
        array(
            'id'    => 'top_gradient_color',
            'type'  => 'color_picker',
            'title' => 'Top gradient color 1',
            'default' 	  => '#455eb8',
            'dependency'   => array( 'style_banner', '==', 'style_6' ),
        ),
        array(
            'id'    => 'top_gradient_color_two',
            'type'  => 'color_picker',
            'title' => 'Top gradient color 2',
            'default' 	  => '#72c5db',
            'dependency'   => array( 'style_banner', '==', 'style_6' ),
        ),
        array(
            'id'    => 'bottom_gradient_color',
            'type'  => 'color_picker',
            'title' => 'Bottom gradient color 1',
            'default' 	  => '#48d7db',
            'dependency'   => array( 'style_banner', '==', 'style_6' ),
        ),
        array(
            'id'    => 'bottom_gradient_color_two',
            'type'  => 'color_picker',
            'title' => 'Bottom gradient color 2',
            'default' 	  => '#17174d',
            'dependency'   => array( 'style_banner', '==', 'style_6' ),
        ),

        array(
            'type'    => 'heading',
            'content' => 'Other settings',
        ),
        array(
            'id'      => 'post_sidebar',
            'type'    => 'select',
            'title'   => 'Single post sidebar',
            'options' => array(
                'left'    => 'Left',
                'right'   => 'Right',
                'disable' => 'Disable'
            ),
            'default' => 'right'
        ),
    )
);

// ----------------------------------------
// Custom CSS and JS
// ----------------------------------------
$options[] = array(
	'name'        => 'custom_css',
	'title'       => 'Custom JS',
	'icon'        => 'fa fa-css3',
	'fields'      => array(
		array(
		  	'id'         => 'custom_js_code',
		  	'desc'       => 'Only JS code, without tag &lt;script&gt;.',
		  	'type'       => 'textarea',
		  	'title'      => 'Custom JS code'
		)
	)
);

// ----------------------------------------
// 404 Page                               -
// ----------------------------------------
$options[] = array(
	'name'        => 'error_page',
	'title'       => '404 Page',
	'icon'        => 'fa fa-warning',
	'fields'      => array(
		array(
			'id'      => 'error_title',
			'type'    => 'text',
			'title'   => 'Error Title'
		),
		array(
			'id'      => 'error_content',
			'type'    => 'text',
			'title'   => 'Error button text'
		),

        array(
            'id'       => 'bg_style',
            'type'     => 'select',
            'title'    => 'Type Background',
            'options'  => array(
                'image'  =>  'Background image',
                'color'  =>  'Background color',
            ),

            'default' 	  => 'color',
        ),
        array(
            'id'      => 'bg_color',
            'type'    => 'color_picker',
            'title'   => 'Background Color',
            'default' 	  => '#d9e6eb',
            'dependency' => array( 'bg_style', '==', 'color' ),
        ),

        array(
            'id'        => 'bg_images',
            'type'      => 'image',
            'title'     => 'Image Background',
            'dependency' => array( 'bg_style', '==', 'image' ),
        ),
	) // end: fields
);

// ----------------------------------------
// 404 Search                               -
// ----------------------------------------
$options[] = array(
    'name'        => 'Search_page',
    'title'       => 'Search',
    'icon'        => 'fa fa-search',
    'fields'      => array(
        array(
            'id'       => 'bg_style_search',
            'type'     => 'select',
            'title'    => 'Type Background',
            'options'  => array(
                'image'  =>  'Background image',
                'color'  =>  'Background color',
            ),
            'default' 	  => 'color',
        ),
        array(
            'id'      => 'bg_color_search',
            'type'    => 'color_picker',
            'title'   => 'Background Color',
            'default' 	  => '#d9e6eb',
            'dependency' => array( 'bg_style_search', '==', 'color' ),
        ),

        array(
            'id'        => 'bg_images_search',
            'type'      => 'image',
            'title'     => 'Image Background',
            'dependency' => array( 'bg_style_search', '==', 'image' ),
        ),
    ) // end: fields
);

// ----------------------------------------
// Backup
// ----------------------------------------
$options[] = array(
	'name'     => 'backup_section',
	'title'    => 'Backup',
	'icon'     => 'fa fa-shield',
	'fields'   => array(
		array(
			'type'    => 'notice',
			'class'   => 'warning',
			'content' => 'You can save your current options. Download a Backup and Import.',
		),
		array(
			'type'    => 'backup',
		),
	) // end: fields
);

// ----------------------------------------
// Documentation
// ----------------------------------------
// $options[]  = array(
// 	'name'     => 'documentation_section',
// 	'title'    => 'Documentation',
// 	'icon'     => 'fa fa-info-circle',
// 	'fields'   => array(
// 		array(
// 		  'type'    => 'heading',
// 		  'content' => 'Documentation'
// 		),
// 		array(
// 		  'type'    => 'content',
// 		  'content' => 'To view the documentation, go to <a href="' . esc_url( $author_url ) . '" target="_blank">documentation page</a>.',
// 		),
// 	)
// );

CSFramework::instance( $settings, $options );
