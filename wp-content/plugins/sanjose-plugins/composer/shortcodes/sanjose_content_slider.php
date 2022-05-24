<?php 
/*
 * Content Slider Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0 
 */

vc_map( 
	array(
		'name'                    => __( 'Content slider', 'js_composer' ),
		'base'                    => 'sanjose_content_slider',
		'as_parent' 		      => array('only' => 'sanjose_content_slider_item'),
		'content_element'         => true,
		'show_settings_on_create' => false,
		'js_view'                 => 'VcColumnView',
		'params'          		  => array(
			array(
				'heading' 	  => __( 'Custom slider height', 'js_composer' ),
				'type' 		  => 'dropdown',
				'param_name'  => 'height',
				'value' 	  => array(
					__( 'Default', 'js_composer' ) => 'default',
					__( 'Custom', 'js_composer' )  => 'custom_height'
				)
			),
			array(
				'type' 		  => 'textfield',
				'heading' 	  => __( 'Custom  height', 'js_composer' ),
				'param_name'  => 'custom_height_size',
				'value' 	  => '',
				'description' => __( 'Set only numbers', 'js_composer' ),
				'dependency'  => array( 'element' => 'height', 'value' => 'custom_height' )
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

class WPBakeryShortCode_sanjose_content_slider extends WPBakeryShortCodesContainer {
	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'height'   => 'default',
			'custom_height_size'   => '',
			'css'	   => '',
			'el_class' => ''
		), $atts ) );

		$class  = ( ! empty( $el_class ) ) ? $el_class : '';
		$class .= vc_shortcode_custom_css_class( $css, ' ' );
		$output = '';

		global $sanjose_content_slider_items;
		$sanjose_content_slider_items = array();

		do_shortcode( $content );

        $height_value  = ( ! empty( $custom_height_size ) && is_numeric( $custom_height_size ) ) ? $custom_height_size :  '500px';

		if( ! empty( $sanjose_content_slider_items ) && count( $sanjose_content_slider_items ) > 0 ) { 
			$output .= '<div class="sanjose-slider ' . $class . '" data-height="' . $height_value . '">';
			$output .= '<div class="swiper-container" data-height="' . $height_value . '" data-autoplay="7000" data-touch="1" data-mouse="0" data-slides-per-view="1" data-loop="1" data-speed="1200" data-mode="horizontal">';
			$output .= '<div class="swiper-wrapper" id="swiper">';

			foreach ( $sanjose_content_slider_items as $key => $item ) {
				$value = (object) $item['atts'];
				
				$image = ( ! empty( $value->image ) && is_numeric( $value->image ) ) ? wp_get_attachment_url( $value->image ) : '';
				$link = ( ! empty( $value->button ) ) ? vc_build_link( $value->button ) : '';
				$link_target = ( ! empty( $link['target'] ) ) ? 'target="' . $link['target'] . '"' : ''; 

				$button = ( ! empty( $link['url'] ) && ! empty( $link['title'] ) ) ? '<a href="' . esc_url( $link['url'] ) . '" class="btn" ' . $link_target . '>' . esc_html( $link['title'] ) . '</a>' : '';

				$output .= '<div class="swiper-slide">';

                    $output .= '<img src="' . $image . '" class="hidden-img" alt="" />';
                    $output .= '<div class="overlay"></div>';

                    $output .= '<div class="content-slide">';
                            $output .= ( ! empty( $value->subtitle ) ) ? '<h6 class="subtitle">' . $value->subtitle . '</h6>' : '';
                            $output .= ( ! empty( $value->title ) ) ? '<h2 class="title">' . $value->title . '</h2>' : '';
                        $output .= $button;
            	    $output .= '</div>';

            	$output .= '</div>';
			}

			$output .= '</div>';

			$output .= '<div class="pagination"></div>';

			$output .= '</div>';
			$output .= '</div>';


		}
		return $output;
	}
}

vc_map( 
	array(
		'name'            => 'Item',
		'base'            => 'sanjose_content_slider_item',
		'as_child' 		  => array('only' => 'sanjose_content_slider'),
		'content_element' => true,
		'params'          => array(
			array(
				'type'        => 'textarea',
				'heading'     => __( 'Title', 'js_composer' ),
				'param_name'  => 'title',
				'value'       => ''
			),
			array(
				'type'     	  => 'textarea',
				'heading'     => __( 'Subtitle', 'js_composer' ),
				'param_name'  => 'subtitle',
				'value'    	  => ''
			),
			array(
				'type'        => 'attach_image',
				'heading'     => __( 'Image', 'js_composer' ),
				'param_name'  => 'image'
			),
			array(
				'type' 		  => 'vc_link',
				'heading' 	  => __( 'Button', 'js_composer' ),
				'param_name'  => 'button'
			),
		),
	)
);


class WPBakeryShortCode_sanjose_content_slider_item extends WPBakeryShortCode{
	protected function content( $atts, $content = null ) {
		global $sanjose_content_slider_items;
		$sanjose_content_slider_items[] = array( 'atts' => $atts, 'content' => $content);
		return;
	}
}