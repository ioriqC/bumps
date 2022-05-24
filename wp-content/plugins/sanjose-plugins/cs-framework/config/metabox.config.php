<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// METABOX OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options      = array();
// -----------------------------------------
// POST PREVIEW OPTIONS                    -
// -----------------------------------------
$options[]    = array(
	'id'        => 'sanjose_post_options',
	'title'     => 'Post preview settings',
	'post_type' => array('post', 'portfolio'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'   => 'section_3',
			'fields' => array(
                array(
                    'id'      	 => 'info_post',
                    'type'    	 => 'textarea',
                    'title'   	 => 'Information post',
                ),
                array(
                    'id'    => 'page_url',
                    'type'  => 'textarea',
                    'title' => 'Page url',
                ),
                array(
				  'type'    => 'heading',
				  'content' => 'Top Banner Settings',
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
				  'dependency'   => array( 'style_banner', 'any', 'style_1,style_2,style_4,style_6' ),
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

				// Custom styles 
				array(
				  'type'    => 'heading',
				  'content' => 'Custom styles',
				),
				array(
				  'id'             => 'align',
				  'type'           => 'select',
				  'title'          => 'Align',
				  'options'        => array(
				    'left'          => 'Left',
				    'center'        => 'Center',
				    'right'         => 'Right',
				  ),
				  'default' => 'center',
				),
				// title option
				array(
				  'id'    => 'title_font_size',
				  'type'  => 'text',
				  'title' => 'Title font size',
				),
				array(
				  'id'             => 'title_font_switch',
				  'type'           => 'select',
				  'title'          => 'Title font family',
				  'options'        => array(
				    'default'          => 'Default',
				    'custom'     => 'Custom',
				  ),
				),
				array(
				  'id'    => 'title_font',
				  'type'  => 'typography',
				  'title' => 'Font Family',
				  'dependency'   => array( 'title_font_switch', '==', 'custom' ),
				),
				array(
				  'id'    => 'title_color',
				  'type'  => 'color_picker',
				  'title' => 'Title color',
				  'dependency'   => array( 'title_font_switch', '==', 'custom' ),
				),
				// subtitle option
				array(
				  'id'    => 'subtitle_font_size',
				  'type'  => 'text',
				  'title' => 'Title font size',
				),
				array(
				  'id'             => 'subtitle_font_switch',
				  'type'           => 'select',
				  'title'          => 'Title font family',
				  'options'        => array(
				    'default'          => 'Default',
				    'custom'     => 'Custom',
				  ),
				),
				array(
				  'id'    => 'subtitle_font',
				  'type'  => 'typography',
				  'title' => 'Font Family',
				  'dependency'   => array( 'subtitle_font_switch', '==', 'custom' ),
				),
				array(
				  'id'    => 'subtitle_color',
				  'type'  => 'color_picker',
				  'title' => 'Subtitle color',
				  'dependency'   => array( 'subtitle_font_switch', '==', 'custom' ),
				),
				// text option
				array(
				  'id'    => 'text_font_size',
				  'type'  => 'text',
				  'title' => 'Title font size',
				),
				array(
				  'id'             => 'text_font_switch',
				  'type'           => 'select',
				  'title'          => 'Title font family',
				  'options'        => array(
				    'default'          => 'Default',
				    'custom'     => 'Custom',
				  ),
				),
				array(
				  'id'    => 'text_font',
				  'type'  => 'typography',
				  'title' => 'Font Family',
				  'dependency'   => array( 'text_font_switch', '==', 'custom' ),
				),
				array(
				  'id'    => 'text_color',
				  'type'  => 'color_picker',
				  'title' => 'Text color',
				  'dependency'   => array( 'text_font_switch', '==', 'custom' ),
				),


			),
			
		),
	)
);

// -----------------------------------------
// PAGE OPTIONS                            -
// -----------------------------------------
$options[]    = array(
	'id'        => 'sanjose_page_options',
	'title'     => 'Page settings',
	'post_type' => array('page', 'portfolio'),
	'context'   => 'side',
	'priority'  => 'high',
	'sections'  => array(
		array(
			'name'   => 'section_3',
			'fields' => array(
				array(
					'id'      => 'page_footer',
					'type'    => 'switcher',
					'title'   => 'Page footer',
					'default' => true
				),
//                array( //todo not used
//                    'id'      => 'absolute_header',
//                    'type'    => 'switcher',
//                    'title'   => 'Absolute header',
//                    'default' => false
//                ),
			)
		),
	)
);



// -----------------------------------------
// PAGE OPTIONS                            -
// -----------------------------------------
$options[]    = array(
    'id'        => 'sanjose_team_options',
    'title'     => 'Team settings',
    'post_type' => 'team',
    'context'   => 'normal',
    'priority'  => 'high',
    'sections'  => array(
        array(
            'name'   => 'section_5',
            'fields' => array(
                array(
                    'id'    => 'position',
                    'type'  => 'textarea',
                    'title' => 'Position',
                ),
            )
        ),
    )
);

// -----------------------------------------
// PORTFOLIO OPTIONS                            -
// -----------------------------------------
$options[]    = array(
    'id'        => 'sanjose_portfolio_options',
    'title'     => 'Portfolio settings',
    'post_type' => 'portfolio',
    'context'   => 'normal',
    'priority'  => 'high',
    'sections'  => array(
        array(
            'name'   => 'section_7',
            'fields' => array(
                array(
                    'id'              => 'sanjose_text',
                    'type'            => 'group',
                    'title'           => 'Text field',
                    'button_title'    => 'Add New',
                    'accordion_title' => 'Add New Field',
                    'fields'          => array(

                        array(
                            'id'          => 'title',
                            'type'        => 'text',
                            'title'       => 'Title',
                        ),

                        array(
                            'id'          => 'description',
                            'type'        => 'text',
                            'title'       => 'Description',
                        ),
                    ),
                ),
            )
        ),
    )
);


CSFramework_Metabox::instance( $options );
