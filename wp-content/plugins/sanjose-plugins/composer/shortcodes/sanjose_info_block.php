<?php 
/*
 * Testimonials Slider Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0 
 */

vc_map( 
	array(
		'name'                    => __( 'Information block', 'js_composer' ),
		'base'                    => 'sanjose_info_block',
		'as_parent' 		      => array('only' => 'sanjose_info_block_item'),
		'content_element'         => true,
		'show_settings_on_create' => false,
		'js_view'                 => 'VcColumnView',
		'params'          		  => array(

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

class WPBakeryShortCode_sanjose_info_block extends WPBakeryShortCodesContainer {
	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'css'	         => '',
			'el_class'       => '',
		), $atts ) );

		$class  = ( ! empty( $el_class ) ) ? $el_class : '';
		$class .= vc_shortcode_custom_css_class( $css, ' ' );

		$output = '';

		global $sanjose_info_block_items;
		$sanjose_info_block_items = array();
		do_shortcode( $content );

		if( ! empty( $sanjose_info_block_items ) && count( $sanjose_info_block_items ) > 0 ) {

			$output .= '<ul class="sanjose-info-block ' . $class . '">';
				foreach ( $sanjose_info_block_items as $key => $item ) {
					$value = (object) $item['atts'];

					if( isset($value->align_content) && $value->align_content=='right') {
						$col_class = 'col-md-6 col-md-pull-6';
						$col_content_class = 'col-md-5 col-md-offset-1 col-md-push-6';
					} else {
						$col_class = 'col-md-6';
						$col_content_class = 'col-md-6';
					}
					$output .= '<li class="item-info">';
						$output .= '<div class="row">';
							
							$image = ( ! empty( $value->image ) && is_numeric( $value->image ) ) ? wp_get_attachment_url( $value->image ) : '';
							$output .= '<div class=" '.$col_content_class.'">';
								$output .= '<div class="info-wrap">';
									if(!empty($value->title)) {
										$output .= '<h1 class="title"><span class="counter-list js-count-list">01</span>'.wp_kses_post($value->title).'</h1>';
									}
									if(!empty($value->description)) {
										$output .= '<p class="desc">'.wp_kses_post($value->description).'</p>';
									}
								$output .= '</div>';
							$output .= '</div>';
							$output .= '<div class=" '.$col_class.'">';
								$output .= '<img class="img" src="'.$image.'" alt="image" style="height: 400px; min-width: 100%">';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</li>';
				}
			$output .= '</ul>';
		}
		return $output;
	}
}

vc_map( 
	array(
		'name'            => 'Information Block Item',
		'base'            => 'sanjose_info_block_item',
		'as_child' 		  => array('only' => 'sanjose_info_block'),
		'content_element' => true,
		'params'          => array(
			array(
				'type'        => 'textarea',
				'heading'     => __( 'Title', 'js_composer' ),
				'admin_label' => true,
				'param_name'  => 'title'
			),
			array(
				'type'        => 'textarea',
				'heading'     => __( 'Description', 'js_composer' ),
				'admin_label' => true,
				'param_name'  => 'description'
			),
			array(
				'type'        => 'attach_image',
				'heading'     => __( 'Image', 'js_composer' ),
				'param_name'  => 'image',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => __( 'Select align content', 'js_composer' ),
				'param_name'  => 'align_content',
				'value'		  => array(
					'left'  => 'left',
					'right' => 'right',
				),
			),

		)
	)
);


class WPBakeryShortCode_sanjose_info_block_item extends WPBakeryShortCode{
	protected function content( $atts, $content = null ) {
		global $sanjose_info_block_items;
		$sanjose_info_block_items[] = array( 'atts' => $atts, 'content' => $content);
		return;
	}
}