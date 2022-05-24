<?php 
/*
 * Contact form Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0 
 */

vc_map(
  	array(
	    'name'        => __( 'Contact form', 'js_composer' ),
	    'base'        => 'sanjose_form',
	    'params'      => array(
	      	array(
				'heading' 	  => __( 'Select form', 'js_composer' ),
				'type' 		  => 'dropdown',
				'param_name'  => 'form',
				'value' 	  => sanjose_get_cf7_forms()
			),
			array(
				'type' 		  => 'textfield',
				'heading' 	  => __( 'Extra class name', 'js_composer' ),
				'param_name'  => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
				'value' 	  => ''
			),
			array(
				'type' 		  => 'css_editor',
				'heading' 	  => __( 'CSS box', 'js_composer' ),
				'param_name'  => 'css',
				'group' 	  => __( 'Design options', 'js_composer' )
			)
	    )
  	)
);

class WPBakeryShortCode_sanjose_form extends WPBakeryShortCode{
	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
		    'form' 				=> 'none',
		    'el_class' 			=> '',
		    'css' 				=> ''
		), $atts ) );

		if( $form != 'none' ) {
			$class  	   = ( ! empty( $el_class ) ) ? $el_class : '';
			$class 		  .= vc_shortcode_custom_css_class( $css, ' ' );

			$output	= '<div class="sanjose-contact-form ' . $class . '">';
			$output	.= do_shortcode( '[contact-form-7 id="' . $form . '"]' );;
			$output	.= '</div>';

			return  $output;
		}
	}
}