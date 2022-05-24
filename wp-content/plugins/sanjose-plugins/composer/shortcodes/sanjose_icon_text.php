<?php
/*
 * Icon Text Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0
 */

vc_map(
    array(
        'name'        => __( 'Featured block', 'js_composer' ),
        'base'        => 'sanjose_featured_block',
        'params'      => array(
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Title', 'js_composer' ),
                'admin_label' => true,
                'param_name'  => 'title',
            ),

            array(
                'heading' 	  => __( 'Icon or image', 'js_composer' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'style_icon',
                'value' 	  => array(
                    __( 'Icon', 'js_composer' )         => 'icon',
                    __( 'Image', 'js_composer' )      => 'disable',
                )
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => __( 'Icon color', 'js_composer' ),
                'param_name'  => 'icon_color',
                'dependency'  => array( 'element' => 'style_icon', 'value' => 'icon' ),
            ),
            array(
                'type' 		  => 'attach_image',
                'heading' 	  => __( 'Image', 'js_composer' ),
                'param_name'  => 'news_image',
                'dependency'  => array( 'element' => 'style_icon', 'value' => 'disable' ),
            ),

            array(
                'heading' 	  => __( 'Icon style', 'js_composer' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'icon_type',
                'value' 	  => array(
                    __( 'Font awesome', 'js_composer' ) => 'faw',
                    __( 'Info icons', 'js_composer' ) 	=> 'info'
                ),
                'dependency'  => array( 'element' => 'style_icon', 'value' => 'icon' )
            ),
            array(
                'heading'     => __( 'Icon', 'js_composer' ),
                'type'        => 'iconpicker',
                'param_name'  => 'icon',
                'description' => __( 'Select icon from library.', 'js_composer' ),
                'dependency'  => array( 'element' => 'icon_type', 'value' => 'faw' )
            ),
            array(
                'type' 		  => 'iconpicker',
                'heading' 	  => __( 'Icon Info', 'js_composer' ),
                'param_name'  => 'icon_info',
                'value' 	  => 'icon-adjustments',
                'settings' 	  => array(
                    'emptyIcon'    => false,
                    'type' 		   => 'info',
                    'source' 	   => sanjose_info_icons(),
                    'iconsPerPage' => 4000,
                ),
                'dependency'  => array( 'element' => 'icon_type', 'value'   => 'info' ),
                'description' => __( 'Select icon from library.', 'js_composer' ),
            ),
            array(
                'type' 		  => 'textarea',
                'heading'     => __( 'Content', 'js_composer' ),
                'param_name'  => 'text',
                'value' 	  => ''
            ),
             array(
                'type'        => 'checkbox',
                'heading'     => __( 'Top border', 'js_composer' ),
                'param_name'  => 'top_border',
                'value'       => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
            ),
              array(
                'type'        => 'checkbox',
                'heading'     => __( 'Right border', 'js_composer' ),
                'param_name'  => 'right_border',
                'value'       => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
            ),
               array(
                'type'        => 'checkbox',
                'heading'     => __( 'Left border', 'js_composer' ),
                'param_name'  => 'left_border',
                'value'       => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
            ),
                array(
                'type'        => 'checkbox',
                'heading'     => __( 'Bottom border', 'js_composer' ),
                'param_name'  => 'bottom_border',
                'value'       => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => __( 'Border color', 'js_composer' ),
                'param_name'  => 'border_color',
                'dependency'  => array( 'element' => 'style_icon', 'value' => 'icon' ),
            ),
             array(
                'type'        => 'checkbox',
                'heading'     => __( 'Top border', 'js_composer' ),
                'param_name'  => 'top_border',
                'value'       => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
            ),
            array(
                'type' 		  => 'textfield',
                'heading' 	  => __( 'Extra class name', 'js_composer' ),
                'param_name'  => 'el_class',
                'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
                'value' 	  => ''
            ),
            /* Style tab */
            array(
                'heading' 	  => __( 'Block align', 'js_composer' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'align',
                'value' 	  => array(
                    __( 'Left', 'js_composer' )   => 'left',
                    __( 'Center', 'js_composer' ) => 'center',
                    __( 'Right', 'js_composer' )  => 'right'
                ),
                'group' 	 => __( 'Style', 'js_composer' ),
            ),
            array(
                'heading' 	  => __( 'Style', 'js_composer' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'style',
                'value' 	  => array(
                    __( 'Default', 'js_composer' )  => 'default',
                    __( 'Custom', 'js_composer' ) => 'custom'
                ),
                'group' 	 => __( 'Style', 'js_composer' ),
                'dependency'  => array( 'element' => 'style_icon', 'value' => 'icon' )
            ),
            array(
                'type'        => 'checkbox',
                'heading'     => __( 'Big size', 'js_composer' ),
                'param_name'  => 'big_size',
                'value'       => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
                'group' 	 => __( 'Style', 'js_composer' ),
                'dependency'  => array( 'element' => 'style_icon', 'value' => 'icon' )
            ),

            array(
                'type'        => 'textfield',
                'heading'     => __( 'Icon size', 'js_composer' ),
                'param_name'  => 'icon_font_size',
                'value'       => '',
                'dependency'  => array( 'element' => 'style', 'value' => 'custom' ),
                'group' 	  => __( 'Style', 'js_composer' )
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => __( 'Separator color', 'js_composer' ),
                'param_name'  => 'separator_color',
                'dependency'  => array( 'element' => 'style', 'value' => 'custom' ),
                'group' 	  => __( 'Style', 'js_composer' )
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Title font size', 'js_composer' ),
                'param_name'  => 'title_font_size',
                'value'       => '',
                'dependency'  => array( 'element' => 'style', 'value' => 'custom' ),
                'group' 	  => __( 'Style', 'js_composer' )
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => __( 'Title color', 'js_composer' ),
                'param_name'  => 'title_color',
                'dependency'  => array( 'element' => 'style', 'value' => 'custom' ),
                'group' 	  => __( 'Style', 'js_composer' )
            ),
            array(
                'type' 		 => 'dropdown',
                'heading' 	 => __( 'Title font family', 'js_composer' ),
                'param_name' => 'title_font_family',
                'value' 	 => array(
                    __( 'Default',  'js_composer' ) => 'default',
                    __( 'Custom',   'js_composer' ) => 'custom'
                ),
                'dependency' => array( 'element' => 'style', 'value' => 'custom' ),
                'group' 	 => __( 'Style', 'js_composer' )
            ),
            array(
                'type' 		 => 'google_fonts',
                'param_name' => 'title_font',
                'value' 	 => '',
                'settings'   => array(
                    'fields' => array(
                        'font_family_description' => __( 'Select font family.', 'js_composer' ),
                        'font_style_description'  => __( 'Select font styling.', 'js_composer' ),
                    ),
                ),
                'dependency' => array( 'element' => 'title_font_family', 'value' => 'custom' ),
                'group' 	 => __( 'Style', 'js_composer' )
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Content font size', 'js_composer' ),
                'param_name'  => 'content_font_size',
                'dependency'  => array( 'element' => 'style', 'value' => 'custom' ),
                'group' 	  => __( 'Style', 'js_composer' )
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => __( 'Content color', 'js_composer' ),
                'param_name'  => 'content_color',
                'dependency'  => array( 'element' => 'style', 'value' => 'custom' ),
                'group' 	 => __( 'Style', 'js_composer' )
            ),
            array(
                'type' 		 => 'dropdown',
                'heading' 	 => __( 'Content font family', 'js_composer' ),
                'param_name' => 'content_font_family',
                'value' 	 => array(
                    __( 'Default',  'js_composer' ) => 'default',
                    __( 'Custom',   'js_composer' ) => 'custom'
                ),
                'dependency' => array( 'element' => 'style', 'value' => 'custom' ),
                'group' 	 => __( 'Style', 'js_composer' )
            ),
            array(
                'type' 		 => 'google_fonts',
                'param_name' => 'content_font',
                'value' 	 => '',
                'settings'   => array(
                    'fields' => array(
                        'font_family_description' => __( 'Select font family.', 'js_composer' ),
                        'font_style_description'  => __( 'Select font styling.', 'js_composer' ),
                    ),
                ),
                'dependency' => array( 'element' => 'content_font_family', 'value' => 'custom' ),
                'group' 	 => __( 'Style', 'js_composer' )
            ),
            /* CSS editor */
            array(
                'type' 		  => 'css_editor',
                'heading' 	  => __( 'CSS box', 'js_composer' ),
                'param_name'  => 'css',
                'group' 	  => __( 'Design options', 'js_composer' )
            )
        )
    )
);

class WPBakeryShortCode_sanjose_featured_block extends WPBakeryShortCode{
    protected function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
            'title' 			  => '',
            'style_icon' 		  => 'icon',
            'icon' 				  => '',
            'icon_info'           => '',
            'news_image'          => '',
            'text' 				  => '',
            'icon_type'           => 'faw',
            'top_border'          => '',
            'left_border'         => '',
            'right_border'        => '',
            'bottom_border'       => '',
            'border_color' 	      => '',
            'el_class' 			  => '',
            'align' 			  => 'left',
            'style' 			  => 'default',
            'big_size' 			  => '',
            'icon_color' 		  => '',
            'icon_font_size' 	  => '',
            'title_font_size' 	  => '',
            'title_color' 		  => '',
            'title_font_family'   => 'default',
            'title_font' 		  => '',
            'content_font_size'   => '',
            'content_color' 	  => '',
            'content_font_family' => 'default',
            'content_font' 		  => '',
            'css' 				  => ''
        ), $atts ) );


        $class  = ( ! empty( $el_class ) ) ? $el_class : '';
        $class .= vc_shortcode_custom_css_class( $css, ' ' );
        $class .= ( $style != 'custom' ) ? ' ' . $style : '';

        $title_style     = '';
        $content_style   = '';
        $google_fonts = new Vc_Google_Fonts;
        /* Get styles from options */
        $styles = array('title', 'content');

        /* Custom shortcode styles */
        foreach ( $styles as $item ) {

            if( ! empty( ${$item."_font_size"} ) ) {
                ${$item."_style"}  = ( is_numeric( ${$item."_font_size"} ) ) ? 'font-size: ' . ${$item."_font_size"} . 'px;' : 'font-size: ' . ${$item."_font_size"} . ';';
                ${$item."_style"} .= ( is_numeric( ${$item."_font_size"} ) ) ? 'line-height: ' . ${$item."_font_size"} . 'px;' : 'line-height: ' . ${$item."_font_size"} . ';';
            }
            ${$item."_style"} .= ( ! empty( ${$item."_color"} ) ) ? 'color: ' . ${$item."_color"} . ';' : '';

            if( ${$item."_font_family"} == 'custom' ) {
                ${$item."_font"} = $google_fonts->_vc_google_fonts_parse_attributes( $atts, ${$item."_font"} );

                $subsets  = '';
                $settings = get_option( 'wpb_js_google_fonts_subsets' );
                if ( is_array( $settings ) && ! empty( $settings ) ) {
                    $subsets = '&subset=' . implode( ',', $settings );
                }

                wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( ${$item."_font"}['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . ${$item."_font"}['values']['font_family'] . $subsets );

                $google_fonts_family = explode( ':', ${$item."_font"}['values']['font_family'] );
                ${$item."_style"} .= 'font-family:' . $google_fonts_family[0] . ';';
                $google_fonts_styles = explode( ':', ${$item."_font"}['values']['font_style'] );
                ${$item."_style"} .= 'font-weight:' . $google_fonts_styles[1] . ';';
                ${$item."_style"} .= 'font-style:' . $google_fonts_styles[2] . ';';
            }

            ${$item."_style"} = ( ! empty( ${$item."_style"} ) ) ? 'style="' . ${$item."_style"} . '"' : '';

        }

        $big_size = ( isset( $big_size ) && $big_size == 'yes' ) ? 'big-size' : '';

        if( $icon_type == 'faw' ) {
            $icon = $icon;
        } else {
            $icon = $icon_info;
        }

        // Icon color
        $icon_color = ( ! empty( $icon_color ) ) ? 'color: ' . $icon_color . ';' : '';
        

        // Icon font size
        $icon_font_size  = ( is_numeric( $icon_font_size ) ) ? 'font-size: ' . $icon_font_size . 'px;' : 'font-size: ' . $icon_font_size . ';';
        $icon_font_size .= ( is_numeric( $icon_font_size ) ) ? 'line-height: ' . $icon_font_size . 'px;' : 'line-height: ' . $icon_font_size . ';';

        $icon_style = ( ! empty( $icon_color ) || ! empty( $icon_font_size ) ) ? 'style="' . $icon_color . ' ' . $icon_font_size . '"' : '';

        $icon_block  =  ( ! empty( $style_icon ) && $style_icon == 'icon' ) ? '<div class="icon"><i class="' . $icon . '" ' . $icon_style . '></i></div>' : '<div class="news-images "><div class="news-img-bg"><img class="hidden-img" src="' . wp_get_attachment_image_url($news_image, 'full')  . '"></div></div>';

        // border color
        $border_color = ( ! empty( $border_color ) ) ? 'color: ' . $border_color . ';' : '';

        //borders
        $top_border = ( isset( $top_border ) && $top_border == 'yes' ) ? ' top-border ' : '';
        $left_border = ( isset( $left_border ) && $left_border == 'yes' ) ? ' left-border ' : '';
        $right_border = ( isset( $right_border ) && $right_border == 'yes' ) ? ' right-border ' : '';
        $bottom_border = ( isset( $bottom_border ) && $bottom_border == 'yes' ) ? ' bottom-border ' : '';
        $class .= $top_border . $left_border . $right_border . $bottom_border;

        $output = '<div class="featured-block text-' . $align . ' ' . $big_size . ' ' . $class . '" style = " '. $border_color .' ">';

        // Icon
        $output .= $icon_block;

        // Title
        if( ! empty( $title ) ) {
            $output .= '<h6 class="title" ' . $title_style . '>' . $title . '</h6>';
        }

        // Text
        if( ! empty( $text ) ) {
            $output .= '<div class="desc"><p ' . $content_style . '>' . $text . '</p></div>';
        }

        $output .= '</div>';

        return  $output;
    }
}