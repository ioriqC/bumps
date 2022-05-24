<?php
/*
 * Text block Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0
 */

vc_map(
    array(
        'name'        => __( 'FAQ Info', 'js_composer' ),
        'base'        => 'sanjose_faq_info',
        'params'      => array(
            array(
                'type'        => 'textarea',
                'heading'     => __( 'Title', 'js_composer' ),
                'admin_label' => true,
                'param_name'  => 'title'
            ),
            array(
                'type' 		  => 'textarea',
                'heading'     => __( 'Text', 'js_composer' ),
                'param_name'  => 'text',
                'value' 	  => ''
            ),
            array(
                'type' 		 => 'vc_link',
                'heading' 	 => __( 'Button', 'js_composer' ),
                'param_name' => 'button'
            ),
            array(
                'heading' 	  => __( 'Style button', 'js_composer' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'style_button',
                'value' 	  => array(
                    __( 'Style 1', 'js_composer' ) => 'default',
                    __( 'Style 2', 'js_composer' ) => 'modern',
                ),
            ),
            array(
                'heading' 	  => __( 'Content align', 'js_composer' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'content_align',
                'value' 	  => array(
                    __( 'Left', 'js_composer' )   => 'left',
                    __( 'Center', 'js_composer' ) => 'center',
                    __( 'Right', 'js_composer' )  => 'right'
                ),
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
                'type'        => 'colorpicker',
                'heading'     => __( 'Background color', 'js_composer' ),
                'param_name'  => 'bg_color',
                'group' 	  => __( 'Style', 'js_composer' )
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Title font size', 'js_composer' ),
                'param_name'  => 'title_font_size',
                'value'       => '',
                'group' 	  => __( 'Style', 'js_composer' )
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => __( 'Title color', 'js_composer' ),
                'param_name'  => 'title_color',
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
                'heading'     => __( 'Text font size', 'js_composer' ),
                'param_name'  => 'text_font_size',
                'value'       => '',
                'group' 	  => __( 'Style', 'js_composer' )
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => __( 'Text color', 'js_composer' ),
                'param_name'  => 'text_color',
                'group' 	  => __( 'Style', 'js_composer' )
            ),
            array(
                'type' 		 => 'dropdown',
                'heading' 	 => __( 'Text font family', 'js_composer' ),
                'param_name' => 'text_font_family',
                'value' 	 => array(
                    __( 'Default',  'js_composer' ) => 'default',
                    __( 'Custom',   'js_composer' ) => 'custom'
                ),
                'group' 	 => __( 'Style', 'js_composer' )
            ),
            array(
                'type' 		 => 'google_fonts',
                'param_name' => 'text_font',
                'value' 	 => '',
                'settings'   => array(
                    'fields' => array(
                        'font_family_description' => __( 'Select font family.', 'js_composer' ),
                        'font_style_description'  => __( 'Select font styling.', 'js_composer' ),
                    ),
                ),
                'dependency' => array( 'element' => 'text_font_family', 'value' => 'custom' ),
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

class WPBakeryShortCode_sanjose_faq_info extends WPBakeryShortCode{
    protected function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
            'title' 			 => '',
            'text' 			     => '',
            'button'             => '',
            'style_button'       => 'default',
            'content_align'      => 'left',
            'el_class' 			 => '',
            'bg_color' 	         => '',
            'title_font_size' 	 => '',
            'title_color' 		 => '',
            'title_font_family'  => 'default',
            'title_font' 	     => '',
            'text_font_size'     => '',
            'text_color' 	     => '',
            'text_font_family'   => 'default',
            'text_font' 	     => '',
            'css' 			     => ''
        ), $atts ) );

        $google_fonts = new Vc_Google_Fonts;

        $class  = ( ! empty( $el_class ) ) ? $el_class : '';
        $class .= vc_shortcode_custom_css_class( $css, ' ' );

        $output = '';

        $content_align = ' text-' . $content_align;

        $title_style   = '';
        $text_style    = '';

        /* Get styles from options */
        $styles = array('title', 'text');

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

        $bg_color = ( ! empty( $bg_color ) ) ? 'style="background-color:' . $bg_color . '"' : '';

        $output .= '<div class="sanjose-faq-info ' . $class . $content_align . '" ' . $bg_color . '>';

        // Title
        $output .= ( ! empty( $title ) ) ? '<h6 ' . $title_style . '>' . wp_kses_post( $title ) . '</h6>' : '';

        // Text
        $output .= ( ! empty( $text ) )  ? '<div><p ' . $text_style . '>' . wp_kses_post( $text ) . '</p></div>' : '';

        // Button
        $button = vc_build_link( $button );

        $style_button = ( isset( $style_button ) && $style_button == 'default' ) ? 'default' : $style_button;

        if( ! empty( $button['url'] ) && ! empty( $button['title'] ) ) {
            $output .= '<a href="' . esc_url( $button['url'] ) . '" class="link ' . $style_button . '">' . esc_html( $button['title'] ) . '</a>';
        }

        $output .= '</div>';

        return $output;
    }
}