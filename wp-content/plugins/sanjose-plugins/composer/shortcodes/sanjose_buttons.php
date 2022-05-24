<?php
/*
 * Button block Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0
 */

vc_map(
    array(
        'name'        => __( 'Buttons', 'js_composer' ),
        'base'        => 'sanjose_buttons',
        'description' => __( 'Buttons', 'js_composer'),
        'params'      => array(
            array(
                'heading' 	  => __( 'Style button', 'js_composer' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'style_btn',
                'value' 	  => array(
                    __('Default', 'js_composer')            => 'default',
                    __('Transparent', 'js_composer')        => 'transparent',
                    __('Background Image', 'js_composer')   => 'background-img',
                    __('Custom style', 'js_composer')       => 'custom_style',
                ),
            ),
            array(
                'heading' 	  => __( 'Button color', 'js_composer' ),
                'type' 		  => 'colorpicker',
                'param_name'  => 'button_color_transparent',
                'value' 	  => '',
                'dependency'  => array( 'element' => 'style_btn', 'value' => 'custom_style' ),
            ),
            array(
                'heading' 	  => __( 'Button color text', 'js_composer' ),
                'type' 		  => 'colorpicker',
                'param_name'  => 'button_color_text',
                'value' 	  => '',
                'dependency'  => array( 'element' => 'style_btn', 'value' => 'custom_style' ),
            ),
            array(
                'heading' 	  => __( 'Link', 'js_composer' ),
                'type' 		  => 'vc_link',
                'param_name'  => 'link',
                'value' 	  => '',
                'dependency'  => array( 'element' => 'style_btn', 'value' => array('default', 'transparent', 'custom_style') ),
            ),
            array(
                'type'        => 'href',
                'heading'     => 'Button url',
                'param_name'  => 'button_url',
                'admin_label' => true,
                'value'       => '',
                'dependency'  => array( 'element' => 'style_btn', 'value' => 'background-img' ),
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => __( 'Button image', 'js_composer' ),
                'param_name'  => 'button_image',
                'dependency'  => array( 'element' => 'style_btn', 'value' => 'background-img' ),
            ),
            array(
                'type' 		  => 'textfield',
                'heading' 	  => __( 'Extra class name', 'js_composer' ),
                'param_name'  => 'el_class',
                'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
                'value' 	  => ''
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

class WPBakeryShortCode_sanjose_buttons extends WPBakeryShortCode{
    protected function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
            'style_btn'			=> 'default',
            'link'				=> '',
            'button_color_transparent'=> '',
            'button_color_text' => '',
            'button_url'		=> '',
            'button_image'	    => '',
            'el_class' 			=> '',
            'css' 			    => ''
        ), $atts ) );

        $class  = ( ! empty( $el_class ) ) ? $el_class : '';
        $class .= vc_shortcode_custom_css_class( $css, ' ' );

        $output = '';

        $style_btn = ( isset( $style_btn ) && $style_btn == 'default' ) ? 'default' : $style_btn;

        $button_link = vc_build_link( $link );
        $button_link_target = ( ! empty( $button_link['target'] ) ) ? 'target="' . $button_link['target'] . '"' : '';

        $output .= ( ! empty( $button_link['url'] ) && ! empty( $button_link['title'] ) ) ? '<a href="' . $button_link['url'] . '" class="button ' . $style_btn . ' '. $class . '" ' . $button_link_target . ' style="background-color:'. $button_color_transparent .'; border-color:'.$button_color_transparent.'; color:'. $button_color_text .';">' . $button_link['title'] . ' </a>' : '';

        if ( ! empty( $button_url ) && ! empty( $button_image ) ) :
            $button_image = ( ! empty( $button_image ) ) ? 'style="background-image:url(' . wp_get_attachment_url( $button_image ) . ')"' : '';
            $output .= '<a href="' . esc_url( $button_url ) . '" class="button ' . $style_btn . ' '. $class . '" ' . $button_image . '></a>';
        endif;

        return $output;
    }
}