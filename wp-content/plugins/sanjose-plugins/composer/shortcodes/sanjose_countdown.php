<?php
/*
 * Countdown Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0
 */

vc_map(
    array(
        'name'        => __( 'Countdown', 'js_composer' ),
        'base'        => 'sanjose_countdown',
        'params'      => array(
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Percentage', 'js_composer' ),
                'param_name'  => 'number',
                 'description' => __( 'Max value = 100', 'js_composer' ),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Border width', 'js_composer' ),
                'param_name'  => 'border_width'
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Counter width', 'js_composer' ),
                'param_name'  => 'counter_width'
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => __( 'Border color', 'js_composer' ),
                'param_name'  => 'border_color',
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => __( 'Counter color', 'js_composer' ),
                'param_name'  => 'counter_color',
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => __( 'Number color', 'js_composer' ),
                'param_name'  => 'number_color',
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
        ),
        'js_view' => 'VcIconElementView_Backend'
    )
);

class WPBakeryShortCode_sanjose_countdown extends WPBakeryShortCode{
    protected function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
            'number' 			   => '',
            'border_width' 		   => '',
            'counter_width' 	   => '',
            'border_color' 	       => '',
            'counter_color' 	   => '',
            'number_color' 	       => '',
            'el_class' 			   => '',
            'title_font_size' 	   => '',
            'title_color' 		   => '',
            'title_font_family'    => 'default',
            'title_font' 		   => '',
            'css' 				   => ''
        ), $atts ) );

        $google_fonts = new Vc_Google_Fonts;


        $class  = ( ! empty( $el_class ) ) ? $el_class : '';
        $class .= vc_shortcode_custom_css_class( $css, ' ' );


        $title_style 	= '';

        /* Get styles from options */
        $styles = array('title');

        foreach ( $styles as $item ) {

            if( ! empty( ${$item."_font_size"} ) ) {
                ${$item."_style"} = ( is_numeric( ${$item."_font_size"} ) ) ? 'font-size: ' . ${$item."_font_size"} . 'px;' : 'font-size: ' . ${$item."_font_size"} . ';';
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

                ${$item."_font"} = explode( ':', ${$item."_font"}['values']['font_family'] );

                ${$item."_style"} .= 'font-family: ' . ${$item."_font"}[0] . ';';
            }

            ${$item."_style"} = ( ! empty( ${$item."_style"} ) ) ? 'style="' . ${$item."_style"} . '"' : '';

        }

        $border_width  = ( ! empty( $border_width ) ) ? $border_width : '1';
        $counter_width = ( ! empty( $counter_width ) ) ? $counter_width : '4';
        $border_color  = ( ! empty( $border_color ) ) ? $border_color : 'rgba(59,85,230,0.15)';
        $counter_color = ( ! empty( $counter_color ) ) ? $counter_color : '#3b55e6';
        $number_color = ( ! empty( $number_color ) ) ? $number_color : '#3b55e6';

        $output = '';

        if ( ! empty( $number ) && $number<= 100) :
            $output .= '<div class="countdown-item" data-percent="' . $number . '" data-border-width="' . $border_width . '" data-counter-width="' . $counter_width . '" data-size-cirlce="40" data-border-color="' . $border_color . '" data-counter-color="' . $counter_color . '" data-number-color="' . $number_color . '"></div>';
        endif;

        return $output;
    }
}

