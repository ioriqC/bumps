<?php
/*
 * Timeline Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0
 */

vc_map(
    array(
        'name'                    => __( 'Timeline', 'js_composer' ),
        'base'                    => 'sanjose_timeline',
        'as_parent' 		      => array('only' => 'sanjose_timeline_item'),
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

class WPBakeryShortCode_sanjose_timeline extends WPBakeryShortCodesContainer {
    protected function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
            'css'	   => '',
            'el_class' => ''
        ), $atts ) );

        $class  = ( ! empty( $el_class ) ) ? $el_class : '';
        $class .= vc_shortcode_custom_css_class( $css, ' ' );
        $output = '';

        global $sanjose_timeline_items;
        $sanjose_timeline_items = array();

        do_shortcode( $content );

        $output .= '<div class="container time-line">';
        $output .= '<div class="row sanjose-timeline ' . $class . '">';

        $output .= '<div class="col-md-7">';
        if( ! empty( $sanjose_timeline_items ) && count( $sanjose_timeline_items ) > 0 ) {

            $counter = 1;
            foreach ( $sanjose_timeline_items as $key => $item ) {

                $active = ( $counter === 1 ) ? 'active' : '';

                $output .= '<div id="tab-content-' . $counter . '" class="tab-content ' . $active . '">';

                $value = (object) $item['atts'];

                $images = explode(',', $value->images);

                $output .= '<div class="swiper-container" data-autoplay="7000" data-touch="1" data-mouse="0" data-slides-per-view="1" data-loop="1" data-speed="1200" data-mode="horizontal">';
                $output .= '<div class="swiper-wrapper">';

                foreach ( $images as $key => $image_id ) :
                    if ( ! empty( $image_id ) ) :

                        $img_url = wp_get_attachment_url( $image_id );

                        $output .= '<div class="swiper-slide">';
                        $output .= '<img src="' . esc_url( $img_url ) . '" class="hidden-img" alt="" />';
                        $output .= '</div>';

                    endif;
                endforeach;

                $output .= '</div>';

                // Pagination
                $output .= '<div class="pagination"></div>';

                $output .= '</div>';

                $output .= '</div>';

                $counter++;
            }

        }
        $output .= '</div>';

        $output .= '<div class="col-md-4 col-md-offset-1">';
        $output .= '<div class="timeline-border"><span class="timeline-scale"></span></div>';
        $output .= '<ul class="tabs-header">';
        if( ! empty( $sanjose_timeline_items ) && count( $sanjose_timeline_items ) > 0 ) {

            $counter = 1;
            foreach ( $sanjose_timeline_items as $key => $item ) {

                $active = ( $counter === 1 ) ? 'active highlited' : '';

                $output .= '<li class="tab-item ' . $active . ' " data-content="#tab-content-' . $counter . '">';

                $value = (object) $item['atts'];

                $output .= '<span class="counter">' . $counter . ' </span>';
                $output .= ( ! empty( $value->title ) ) ? '<h6 class="title">' . $value->title . '</h6>' : '';
                $output .= ( ! empty( $item['content'] ) ) ? '<p>' . wp_kses_post( $item['content'] ) . '</p>' : '';

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
        'base'            => 'sanjose_timeline_item',
        'as_child' 		  => array('only' => 'sanjose_timeline'),
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
                'heading'     => __( 'Text', 'js_composer' ),
                'param_name'  => 'content',
                'holder'      => 'div',
                'value'    	  => ''
            ),
            array(
                'type'        => 'attach_images',
                'heading'     => __( 'Images', 'js_composer' ),
                'param_name'  => 'images'
            ),
        ),
    )
);


class WPBakeryShortCode_sanjose_timeline_item extends WPBakeryShortCode{
    protected function content( $atts, $content = null ) {
        global $sanjose_timeline_items;
        $sanjose_timeline_items[] = array( 'atts' => $atts, 'content' => $content);
        return;
    }
}
