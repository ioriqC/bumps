<?php 
/*
 * Contact info Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0 
 */

vc_map( 
	array(
		'name'                    => __( 'Contact info block', 'js_composer' ),
		'base'                    => 'sanjose_contact_info',
		'content_element'         => true,
		'show_settings_on_create' => true,
		'params' => array(
			array(
				'type' 		  => 'textfield',
				'heading' 	  => __( 'Title', 'js_composer' ),
				'param_name'  => 'title'
			),
			array(
				'type'       => 'param_group',
				'heading'    => __( 'Items', 'js_composer' ),
				'param_name' => 'items',
				'params'     => array(
					array(
						'type' 		  => 'textarea',
						'heading' 	  => __( 'Text', 'js_composer' ),
						'param_name'  => 'text'
					),
					array(
						'type' 		  => 'textfield',
						'heading' 	  => __( 'URL', 'js_composer' ),
						'param_name'  => 'url',
						'value' 	  => ''
					),
				),
				'callbacks' => array(
					'after_add' => 'vcChartParamAfterAddCallback'
				)
			),
			array(
				'heading' 	  => __( 'Align', 'js_composer' ),
				'type' 		  => 'dropdown',
				'param_name'  => 'block_align',
				'value' 	  => array(
					__( 'Left', 'js_composer' ) => 'left',
					__( 'Center', 'js_composer' ) => 'center',
					__( 'Right', 'js_composer' ) => 'right'
				)
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
		) //end params
	)
);

class WPBakeryShortCode_sanjose_contact_info extends WPBakeryShortCode{
	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'title' 	    => '',
			'block_align'   => 'left',
			'items' 	    => '',
			'el_class' 	    => '',
			'css' 		    => ''
		), $atts ) );

		$output 	= '';
		$items 	  	= json_decode( urldecode( $items ), true );
		$class  	= ( ! empty( $el_class ) ) ? $el_class : '';
		$class 	   .= vc_shortcode_custom_css_class( $css, ' ' );
		$class 	   .= ' text-' . $block_align;

		if( ! empty( $items ) ) {
			$output .= '<div class="contact-info ' . $class . '">';
                if( ! empty( $title ) ) {
                    $output .= '<h6 class="title">' . $title . '</h6>';
                }
                $output .= '<div class="contact-item">';
                    $output .= '<ul>';
                    foreach ( $items as $item ) {
                        if( ! empty( $item['text'] ) ) {
                            if( ! empty( $item['url'] ) ) {
                                $output .= '<li><a href="' . esc_url( $item['url'] ) . '">' . $item['text'] . '</a></li>';
                            } else {
                                $output .= '<li>' . $item['text'] . '</li>';
                            }
                        }
                    }
                    $output .= '</ul>';
                $output .= '</div>';
			$output .= '</div>';
			
			return $output;
		}
	}
}