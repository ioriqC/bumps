<?php 
/*
 * Testimonials Slider Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0 
 */

vc_map( 
	array(
		'name'                    => __( 'Testimonials slider', 'js_composer' ),
		'base'                    => 'sanjose_testimonials_slider',
		'as_parent' 		      => array('only' => 'sanjose_testimonials_slider_item'),
		'content_element'         => true,
		'show_settings_on_create' => false,
		'js_view'                 => 'VcColumnView',
		'params'          		  => array(
			array(
				'heading' 	  => __( 'Style', 'js_composer' ),
				'type' 		  => 'dropdown',
				'param_name'  => 'style_content',
				'description' => __( 'Modern style does not include next fields: Author , Position.', 'js_composer' ),
				'value' 	  => array(
					__( 'Default', 'js_composer' )  => 'default',
					__( 'Modern', 'js_composer' )   => 'modern',
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

class WPBakeryShortCode_sanjose_testimonials_slider extends WPBakeryShortCodesContainer {
	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'style_content'  => 'default',
			'css'	         => '',
			'el_class'       => ''
		), $atts ) );

		$class  = ( ! empty( $el_class ) ) ? $el_class : '';
		$class .= vc_shortcode_custom_css_class( $css, ' ' );
		$style_content = ( isset( $style_content ) ) ? $style_content : 'default';
		$count_slide    = ( isset( $style_content ) && $style_content == 'modern' ) ? '1' : '3';
		$count_slide_md = ( isset( $style_content ) && $style_content == 'modern' ) ? '1' : '3';
		$count_slide_sm = ( isset( $style_content ) && $style_content == 'modern' ) ? '1' : '1';

		$data_canter = ( isset( $style_content ) && $style_content == 'default' ) ? 'data-center="1"' : '';
		$height_value  = 'auto';
		$output = '';

		global $sanjose_testimonials_slider_items;
		$sanjose_testimonials_slider_items = array();

		do_shortcode( $content );

		if( ! empty( $sanjose_testimonials_slider_items ) && count( $sanjose_testimonials_slider_items ) > 0 ) { 
			$output .= '<div class="sanjose-testimonials-slider ' . $style_content .  ' ' . $class . '">';

                $output .= '<div class="swiper-container" data-autoplay="0" data-touch="1" data-mouse="0" data-speed="1000" data-slides-per-view="responsive" data-xs-slides="1" data-sm-slides="' . $count_slide_sm . '" data-md-slides="' . $count_slide_md .  '" data-height="' . $height_value . '" data-lg-slides="' . $count_slide . '" ' . $data_canter . ' data-add-slides="' . $count_slide . '" data-loop="1" data-mode="horizontal">';

                    // Pagination Slider
                    if ( isset( $style_content ) && $style_content == 'modern' ) {
                        $pagination_class = 'wpc-pagination-img';

                        $display_arrow = ( count( $sanjose_testimonials_slider_items ) > 1 ) ? '' : 'style="display:block";';
                        $output .= '<div class="pagination ' . $pagination_class . '" ' . $display_arrow . '></div>';
                    }

                    $output .= '<div class="swiper-wrapper">';

                        $counter = 0;
                        foreach ( $sanjose_testimonials_slider_items as $key => $item ) {
                            $value = (object) $item['atts'];

                            // Avatar
                            $avatar = ( ! empty( $value->avatar ) && is_numeric( $value->avatar ) ) ? wp_get_attachment_url( $value->avatar ) : '';

                            $pagination_img = '';
                            if ( isset( $style_content ) && $style_content == 'modern' ) {
                                $pagination_img   = 'data-numb-slide="' . $counter . '" data-img-slide="' . $avatar . '"';
                            }

                            $output .= '<div class="swiper-slide" ' . $pagination_img . '>';

                                if( $style_content == 'modern' ) {

                                    $output .= '<div class="content-slide">';

                                        /* Content */
                                        $output .= ( ! empty( $value->text ) ) ? '<div class="content"><p>' . $value->text . '</p></div>' : '';

                                        /* Stars */

                                        if ($value->stars != 'none') {
                                            $output .= '<div class="rating">';
                                            for ($i = 0; $i < 5; $i++) {
                                                if ($i < $value->stars) {
                                                    if ((floatval($value->stars) - $i) == 0.5) {
                                                        $star_class = 'half';
                                                    } else {
                                                        $star_class = 'full';
                                                    }
                                                } else {
                                                    $star_class = 'empty';
                                                }
                                                $output .= '<span class="star ' . esc_attr($star_class) . '"></span>';
                                            }
                                            $output .= '</div>';
                                        }

                                    $output .= '</div>';

                                } else {

                                    $output .= '<div class="content-slide">';

                                        /* Content */
                                        $output .= ( ! empty( $value->text ) ) ? '<div class="content"><p>' . $value->text . '</p></div>' : '';

                                        $output .= ( ! empty( $value->avatar ) ) ? '<div class="wrapp-img"><img src="' . $avatar . '" class="hidden-img" alt=""></div>' : '';

                                        /* Title */
                                        $output .= ( ! empty( $value->author ) ) ? '<h5 class="author">' . $value->author . '</h5>' : '';
                                        // var_dump(empty( $value->author ));

                                        /* Position */
                                        $output .= ( ! empty( $value->position ) ) ? '<span class="position">' . $value->position . '</span>' : '';

                                    $output .= '</div>';
                                }

                            $output .= '</div>';
                            $counter++;
                        }

                    $output .= '</div>';

                    $output .= '<div class="slide-prev"></div>';
                    $output .= '<div class="slide-next"></div>';

                    // Pagination Slider
                    if ( isset( $style_content ) && $style_content == 'default' ) {
                        $display_arrow = ( count( $sanjose_testimonials_slider_items ) > 1 ) ? '' : 'style="display:none";';
                        $output .= '<div class="pagination" ' . $display_arrow . '></div>';
                    }

                $output .= '</div>';
			$output .= '</div>';

		}
		return $output;
	}
}

vc_map( 
	array(
		'name'            => 'Item',
		'base'            => 'sanjose_testimonials_slider_item',
		'as_child' 		  => array('only' => 'sanjose_testimonials_slider'),
		'content_element' => true,
		'params'          => array(
			array(
				'type'        => 'attach_image',
				'heading'     => __( 'Image(signature)', 'js_composer' ),
				'param_name'  => 'avatar',
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Author', 'js_composer' ),
				'admin_label' => true,
				'param_name'  => 'author'
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Position', 'js_composer' ),
				'admin_label' => true,
				'param_name'  => 'position'
			),
			array(
				'type' 		  => 'textarea',
				'heading'     => __( 'Content', 'js_composer' ),
				'param_name'  => 'text',
				'value' 	  => ''
			),
            array(
                'heading' 	  => __( 'Stars', 'js_composer' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'stars',
                'value' 	  => array(
                    'None' => 'none',
                    '0.5'  => '0.5',
                    '1'	   => '1',
                    '1.5'  => '1.5',
                    '2'    => '2',
                    '2.5'  => '2.5',
                    '3'    => '3',
                    '3.5'  => '3.5',
                    '4'    => '4',
                    '4.5'  => '4.5',
                    '5'    => '5'
                ),
                'description' => __( 'Only for style modern', 'js_composer' ),
            ),
		)
	)
);


class WPBakeryShortCode_sanjose_testimonials_slider_item extends WPBakeryShortCode{
	protected function content( $atts, $content = null ) {
		global $sanjose_testimonials_slider_items;
		$sanjose_testimonials_slider_items[] = array( 'atts' => $atts, 'content' => $content);
		return;
	}
}