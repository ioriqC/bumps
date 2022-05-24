<?php 
/*
 * Accordian Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0 
 */

vc_map( 
	array(
		'name'                    => __( 'Accordion', 'js_composer' ),
		'base'                    => 'sanjose_accordian',
		'content_element'         => true,
		'show_settings_on_create' => true,
		'description'             => __( 'Accordian list', 'js_composer'),
		'params' => array(
			array(
				'heading' 	  => __( 'Accordion style', 'js_composer' ),
				'type' 		  => 'dropdown',
				'param_name'  => 'accordion_style',
				'value' 	  => array(
					__( 'Style 1', 'js_composer' )     => '',
					__( 'Style 2', 'js_composer' )     => 'style_2',
					__( 'Style 3', 'js_composer' )     => 'style_3',
				),
			),
			array(
		        'type'       => 'param_group',
		        'heading'    => __( 'Items', 'js_composer' ),
		        'param_name' => 'items',
		        'params'     => array(
		          	array(
						'type' 		  => 'textfield',
						'heading' 	  => __( 'Title', 'js_composer' ),
						'param_name'  => 'title',
						'value' 	  => ''
					),
					array(
				        'type'        => 'checkbox',
				        'heading'     => __( 'Active item?', 'js_composer' ),
				        'param_name'  => 'active',
				        'value'       => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
			      	),
					array(
						'type' 		  => 'textarea',
						'heading' 	  => __( 'Text', 'js_composer' ),
						'param_name'  => 'text'
					),
					array(
						'type' 		  => 'vc_link',
						'heading' 	  => __( 'Button', 'js_composer' ),
						'param_name'  => 'button_link',
					)
		        ),
		        'callbacks' => array(
		          	'after_add' => 'vcChartParamAfterAddCallback'
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

class WPBakeryShortCode_sanjose_accordian extends WPBakeryShortCode{
	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'accordion_style' => '',
			'items' 		  => '',
			'el_class' 		  => '',
			'css' 		  	  => ''
		), $atts ) );

		$output 	= '';
		$items 	  	= json_decode( urldecode( $items ), true );
		$class  	= ( ! empty( $el_class ) ) ? $el_class : '';
		$class 	   .= vc_shortcode_custom_css_class( $css, ' ' );
		$class 	   .= ' '.$accordion_style;

		
		global $accordion;
		$accordion = ( ! empty( $accordion ) ) ? $accordion + 1 : 1;

		if( ! empty( $items ) ) {
			$counter = 0;
			$output .= '<div class="sanjose-accordion ' . $class . '" id="accordion-1' . $counter . $accordion . '" role="tablist" aria-multiselectable="true">';

			foreach ( $items as $item ) {
				if(!empty( $item['button_link'] )) {
                    $button_link = $item['button_link'];
					$button_link = vc_build_link ($button_link);
				}
				$target = (!empty($button_link['target']))? 'target='.$button_link['target'] : '';
			    // Active class
				$active = ( isset( $item['active'] ) && $item['active'] == 'yes' ) ? 'in' : '';
				$active_wrap = ( isset( $item['active'] ) && $item['active'] == 'yes' ) ? 'active' : '';
				$active_title = ( isset( $item['active'] ) && $item['active'] == 'yes' ) ? 'collapsed' : '';
				$active_item = ( isset( $item['active'] ) && $item['active'] == 'yes' ) ? 'true' : 'false';

				$output .= '<div class="panel '.$active_wrap.'">';

                    // Title accordion
                    $output .= '<div class="panel-heading" role="tab" id="headingOne-1' . $counter . $accordion . '">';
                        $output .= '<h5 class="panel-title">';
                            $output .= '<a role="button" data-toggle="collapse" data-parent="#accordion-1' . $counter . $accordion . '" href="#collapseOne-1' . $counter . $accordion . '" aria-expanded="'. $active_item .'" aria-controls="collapseOne-1' . $counter . $accordion . '" class="trans ' . $active_title . '">';
                                $output .= esc_html( $item['title'] );
                                $output .= '<i class="icon fa fa-angle-right"></i>';
                            $output .= '</a>';
                        $output .= '</h5>';
                    $output .= '</div>';

                    // Text accordion
                    $output .= '<div id="collapseOne-1' . $counter . $accordion . '" class="panel-collapse collapse ' . $active . '" role="tabpanel" aria-labelledby="headingOne-1' . $counter . $accordion . '" aria-expanded="'. $active_item .'">';
                        $output .= '<div class="panel-body"><p>';
                            $output .= wp_kses_post( $item['text'] );
                            $output .= '</p>';
                                if(!empty($button_link['url']) && !empty($button_link['title'])) {
                                    $output .= '<div class="text-right"><a class="btn-link" href="'.$button_link['url'].'" '.$target.'>'.$button_link['title'].'</a></div>';
                                }
                        $output .= '</div>';
                    $output .= '</div>';

				$output .= '</div>';

				$counter++;
			}
			
			$output .= '</div>';
			
			return $output;
		}
	}
}