<?php
/*
 * Product slideshow Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0
 */

vc_map(
    array(
        'name'                    => __( 'Product slideshow', 'js_composer' ),
        'base'                    => 'sanjose_product_slideshow',
        'as_parent' 		      => array('only' => 'sanjose_product_slideshow_item'),
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

class WPBakeryShortCode_sanjose_product_slideshow extends WPBakeryShortCodesContainer {
    protected function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
            'css'	   => '',
            'el_class' => ''
        ), $atts ) );

        $class  = ( ! empty( $el_class ) ) ? $el_class : '';
        $class .= vc_shortcode_custom_css_class( $css, ' ' );
        $output = '';

        global $sanjose_product_slideshow_items;
        $sanjose_product_slideshow_items = array();

        do_shortcode( $content );

        $output .= '<div class="container">';
            $output .= '<div class="row sanjose-product-slideshow ' . $class . '">';

                $output .= '<div class="col-md-10 col-md-offset-1">';
                    if( ! empty( $sanjose_product_slideshow_items ) && count( $sanjose_product_slideshow_items ) > 0 ) {

                        $counter = 1;
                        foreach ( $sanjose_product_slideshow_items as $key => $item ) {

                            $active = ( $counter === 1 ) ? 'active' : '';

                            $output .= '<div class="product-content ' . $active . '">';

                                $value = (object) $item['atts'];

                                $image 	 = ( ! empty( $value->image ) && is_numeric( $value->image ) ) ? wp_get_attachment_url( $value->image ) : 'http://sanjose/wp-content/uploads/2017/05/headphone_red_18x18.png';
                                $output .= '<img src="' . esc_url( $image ) . '" alt=""/>';

                                // Product info
                                if ( ! empty( $value->first_info_title ) ) :
                                    $output .= '<div class="info-item left top">';
                                        $output .= '<div class="info-content">' . esc_html( $value->first_info_title ) . '</div>';
                                        $output .= '<div class="indicator">';
                                            $output .= '<div class="info-icon"></div>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                endif;

                                if ( ! empty( $value->second_info_title ) ) :
                                    $output .= '<div class="info-item right top">';
                                        $output .= '<div class="info-content">' . esc_html( $value->second_info_title ) . '</div>';
                                        $output .= '<div class="indicator">';
                                            $output .= '<div class="info-icon"></div>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                endif;

                                if ( ! empty( $value->third_info_title ) ) :
                                    $output .= '<div class="info-item left bottom">';
                                        $output .= '<div class="info-content">' . esc_html( $value->third_info_title ) . '</div>';
                                        $output .= '<div class="indicator">';
                                            $output .= '<div class="info-icon"></div>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                endif;

                                if ( ! empty( $value->fourth_info_title ) ) :
                                    $output .= '<div class="info-item right bottom">';
                                        $output .= '<div class="info-content">' . esc_html( $value->fourth_info_title ) . '</div>';
                                        $output .= '<div class="indicator">';
                                            $output .= '<div class="info-icon"></div>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                endif;

                            $output .= '</div>';

                            $counter++;
                        }

                    }
                $output .= '</div>';

                $output .= '<div class="col-md-12">';
                    $output .= '<ul class="pagination-product">';
                        if( ! empty( $sanjose_product_slideshow_items ) && count( $sanjose_product_slideshow_items ) > 0 ) {

                            $counter = 1;
                            foreach ( $sanjose_product_slideshow_items as $key => $item ) {
                                $value = (object) $item['atts'];

                                // Color pagination item
                                $pagination_item_color = ( ! empty( $value->pagination_item_color ) ) ? 'style="background-color:' . $value->pagination_item_color . '"' : '';

                                // Active item
                                $active = ( $counter === 1 ) ? 'active' : '';

                                $output .= '<li class="tab-item ' . $active . '" ' . $pagination_item_color . '>';

                                $output .= ( ! empty( $value->title ) ) ? '<h6 class="title">' . $value->title . '</h6>' : '';

                                $output .= '</li>';

                                $counter++;
                            }

                        }
                    $output .= '</ul>';
                $output .= '</div>';

            $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}

vc_map(
    array(
        'name'            => 'Item',
        'base'            => 'sanjose_product_slideshow_item',
        'as_child' 		  => array('only' => 'sanjose_product_slideshow'),
        'content_element' => true,
        'params'          => array(
            array(
                'type'        => 'attach_image',
                'heading'     => __( 'Image', 'js_composer' ),
                'param_name'  => 'image'
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => __( 'Pagination item color', 'js_composer' ),
                'param_name'  => 'pagination_item_color',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'First info title', 'js_composer' ),
                'param_name'  => 'first_info_title',
                'value'       => ''
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Second info title', 'js_composer' ),
                'param_name'  => 'second_info_title',
                'value'       => ''
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Third info title', 'js_composer' ),
                'param_name'  => 'third_info_title',
                'value'       => ''
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Fourth info title', 'js_composer' ),
                'param_name'  => 'fourth_info_title',
                'value'       => ''
            ),
        ),
    )
);


class WPBakeryShortCode_sanjose_product_slideshow_item extends WPBakeryShortCode{
    protected function content( $atts, $content = null ) {
        global $sanjose_product_slideshow_items;
        $sanjose_product_slideshow_items[] = array( 'atts' => $atts, 'content' => $content);
        return;
    }
}