<?php
/*
 * Price Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0
 */

vc_map(
    array(
        'name'                    => __( 'Pricing', 'js_composer' ),
        'base'                    => 'sanjose_pricing',
        'as_parent' 		      => array('only' => 'sanjose_pricing_item'),
        'content_element'         => true,
        'show_settings_on_create' => false,
        'js_view'                 => 'VcColumnView',
        'params'          		  => array(
            array(
                'heading' 	  => __( 'Style pricing', 'js_composer' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'style_pricing',
                'value' 	  => array(
                    __( 'Style 1', 'js_composer' )   => 'default',
                    __( 'Style 2', 'js_composer' )   => 'modern',
                    __( 'Style 3', 'js_composer' )   => 'classic',
                    __( 'Style 4', 'js_composer' )   => 'creative',
                )
            ),
            array(
                'heading'     => __( 'Filters', 'js_composer' ),
                'type'        => 'dropdown',
                'param_name'  => 'filters_switcher',
                'value'       => array(
                    __( 'Disable', 'js_composer' )   => '',
                    __( 'Enable', 'js_composer' )   => 'enable',
                )
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Title price', 'js_composer' ),
                'admin_label' => true,
                'param_name'  => 'title_price',
                'dependency'  => array( 'element' => 'style_pricing', 'value' => 'modern' ),
            ),
            array(
                'type'        => 'textarea',
                'heading'     => __( 'Info price', 'js_composer' ),
                'admin_label' => true,
                'param_name'  => 'info_price'
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

class WPBakeryShortCode_sanjose_pricing extends WPBakeryShortCodesContainer {
    protected function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
            'style_pricing'	   => 'default',
            'title_price'      => '',
            'info_price'       => '',
            'filters_switcher' => '',
            'css'	           => '',
            'el_class'         => ''
        ), $atts ) );

        $class  = ( ! empty( $el_class ) ) ? $el_class : '';
        $class .= vc_shortcode_custom_css_class( $css, ' ' );
        $output = '';

        global $sanjose_pricing_items;
        $sanjose_pricing_items = array();

        do_shortcode( $content );

        if( ! empty( $sanjose_pricing_items ) && count( $sanjose_pricing_items ) > 0 ) {
            $filter_active_class = ($filters_switcher=='enable')? ' filters ' : '';
            $output .= '<div class="sanjose-pricing '. $filter_active_class . $style_pricing . ' ' . $class . '">';

                $output .= '<div class="row">';

                    if ( $style_pricing == 'modern' ) :
                        $output .= '<div class="col-md-12 col-lg-4 padding-md-50b padding-sm-30t padding-md-70t padding-lg-70t">';
                        $output .= ( ! empty( $title_price ) ? '<h2 class="title-price">' . $title_price . '</h2>' : '');
                    endif;

                        if($filters_switcher=='enable') {
                            $output .= '<ul class="select-price">';
                                $output .= '<li class="active" data-filter-price="yearly">' . esc_html__('Yearly','sanjose') . '</li>';
                                $output .= '<li data-filter-price="monthly">' . esc_html__('Monthly','sanjose') . '</li>';
                            $output .= '</ul>';
                        }

                        if ( ! empty( $info_price ) ) :
                            $output .= '<div class="info-price"><p>' . wp_kses_post( $info_price ) . '</p></div>';
                        endif;

                    if ( $style_pricing == 'modern' ) :
                        $output .= '</div>';
                    endif;

                    if ( $style_pricing == 'modern' ) :
                        $output .= '<div class="col-md-12 col-lg-7 col-lg-offset-1">';

                            $flex_container = ( $style_pricing == 'default' ) ? 'flex-wrapp' : '';

                            $output .= '<div class="row ' . $flex_container . '">';
                            foreach ( $sanjose_pricing_items as $key => $item ) {
                                $value = (object) $item['atts'];
                                $ative_class_filter = (!empty($value->active_filter))? 'active-filter' : '';
                                $items = json_decode( urldecode( $value->content_list ), true );

                                // Active item
                                $active = ( isset( $value->active ) && $value->active == 'yes' ) ? 'active' : '';

                                // Select price
                                if(!empty($value->active_filter)) {
                                    $select_pricing = ( isset( $value->select_pricing ) && $value->select_pricing == 'monthly' ) ? 'monthly' : 'yearly';
                                } else {
                                    $select_pricing = '';
                                }

                                $output .= '<div class="col-xs-12 col-sm-6 col-md-6 js-pricing-item no-padd-md" data-price="'. $select_pricing . '">';

                                $output .= '<div class="pricing-item ' . $active . '">';
                                    if(!empty($value->label_active)) {
                                        $output .= '<span class="label-text">'.$value->label_active.'</span>';
                                    }

                                // Title
                                $output .= '<h6>' . esc_html( $value->title ) . '</h6>';

                                // Description
                                if ( $style_pricing == 'modern' ) :
                                    $output .= '<div class="description">' . $value->description . '</div>';
                                endif;

                                // Price
                                if( is_numeric( $value->price ) ) {
                                    $currency = ( ! empty( $value->currency ) ) ? '<sup>' . $value->currency . '</sup>' : '';
                                    $output .= '<h2>' . $currency . esc_html( $value->price ) . '</h2>';
                                }

                                // Description
                                if ( $style_pricing == 'default' ) :
                                    $output .= '<div class="description">' . $value->description . '</div>';
                                endif;

                                // Content list
                                if( ! empty( $items ) ) {
                                    $output .= '<ul>';
                                    foreach ( $items as $item ) {
                                        $output .= '<li>' . $item['title_list'] . '</li>';
                                    }
                                    $output .= '</ul>';
                                }

                                // Links
                                $banner_link = vc_build_link( $value->link );
                                $banner_link_target = ( ! empty( $banner_link['target'] ) ) ? 'target="' . $banner_link['target'] . '"' : '';
                                $output .= ( ! empty( $banner_link['url'] ) ) ? '<a href="' . $banner_link['url'] . '" ' . $banner_link_target . ' class="btn">' . $banner_link['title'] . '</a>' : '';

                                $output .= '</div>';
                                $output .= '</div>';
                            }
                            $output .= '</div>';
                        $output .= '</div>';
                    endif;

                $output .= '</div>';

                if ( $style_pricing == 'default' ||  $style_pricing == 'classic' || $style_pricing == 'creative') :
                    $output .= '<div class="row flex-wrapp">';
                        foreach ( $sanjose_pricing_items as $key => $item ) {
                            $value = (object) $item['atts'];
                            $items = json_decode( urldecode( $value->content_list ), true );

                            // Active item
                            $active = ( isset( $value->active ) && $value->active == 'yes' ) ? 'active' : '';

                            // Select price
                            if(!empty($value->active_filter)) {
                                $select_pricing = ( isset( $value->select_pricing ) && $value->select_pricing == 'monthly' ) ? 'monthly' : 'yearly';
                            } else {
                                $select_pricing = '';
                            }

                            $output .= '<div class="col-xs-12 col-sm-6 col-md-4 js-pricing-item" data-price="' . $select_pricing . '">';
                                if(!empty($value->label_active)) {
                                    $output .= '<span class="label-text">'.$value->label_active.'</span>';
                                }

                                $output .= '<div class="pricing-item ' . $active . '">';

                                    // Title
                                    $output .= '<h6>' . esc_html( $value->title ) . '</h6>';

                                    // Price
                                    if( is_numeric( $value->price ) ) {
                                        $currency = ( ! empty( $value->currency ) ) ? '<sup>' . $value->currency . '</sup>' : '';
                                        $output .= '<h2>' . $currency . esc_html( $value->price ) . '</h2>';
                                    }

                                    // Description
                                    if(!empty($value->description)) {
                                        $output .= '<div class="description">' . $value->description . '</div>';
                                    }

                                    // Content list
                                    if( ! empty( $items ) ) {
                                        $output .= '<ul>';
                                        foreach ( $items as $item ) {
                                            $output .= '<li>' . $item['title_list'] . '</li>';
                                        }
                                        $output .= '</ul>';
                                    }

                                    // Links
                                    $banner_link = vc_build_link( $value->link );
                                    $banner_link_target = ( ! empty( $banner_link['target'] ) ) ? 'target="' . $banner_link['target'] . '"' : '';
                                    $output .= ( ! empty( $banner_link['url'] ) ) ? '<a href="' . $banner_link['url'] . '" ' . $banner_link_target . ' class="btn">' . $banner_link['title'] . '</a>' : '';

                                $output .= '</div>';
                            $output .= '</div>';
                        }
                    $output .= '</div>';
                endif;

            $output .= '</div>';


        }
        return $output;
    }
}

vc_map(
    array(
        'name'            => 'Item',
        'base'            => 'sanjose_pricing_item',
        'as_child' 		  => array('only' => 'sanjose_pricing'),
        'content_element' => true,
        'params'          => array(
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Title', 'js_composer' ),
                'admin_label' => true,
                'param_name'  => 'title'
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Currency', 'js_composer' ),
                'param_name'  => 'currency',
                'value'       => '',
                'description' => __( 'Use currency icons, like $, €...', 'js_composer' )
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Price', 'js_composer' ),
                'param_name'  => 'price',
                'value'		  => ''
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Description', 'js_composer' ),
                'admin_label' => true,
                'param_name'  => 'description'
            ),
            array(
                'type'       => 'param_group',
                'heading'    => __( 'Content List', 'js_composer' ),
                'param_name' => 'content_list',
                'params'     => array(
                    array(
                        'type'        => 'textarea',
                        'heading'     => __( 'Title list', 'js_composer' ),
                        'param_name'  => 'title_list'
                    ),
                ),
                'callbacks' => array(
                    'after_add' => 'vcChartParamAfterAddCallback'
                )
            ),
            array(
                'heading' 	  => __( 'Link', 'js_composer' ),
                'type' 		  => 'vc_link',
                'param_name'  => 'link',
                'value' 	  => '',
            ),
            array(
                'type'        => 'checkbox',
                'heading'     => __( 'Active item?', 'js_composer' ),
                'param_name'  => 'active',
                'value'       => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Label active item', 'js_composer' ),
                'admin_label' => true,
                'param_name'  => 'label_active',
                'dependency'  => array('element' => 'active', 'value' => 'yes'),
            ),
            array(
                'type'        => 'checkbox',
                'heading'     => __( 'Active pricing filter?', 'js_composer' ),
                'param_name'  => 'active_filter',
                'description' => 'Work only when Option Filters in pricing settings enable',
                'value'       => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
            ),
            array(
                'heading' 	  => __( 'Select pricing', 'js_composer' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'select_pricing',
                'value' 	  => array(
                    __( 'Yearly', 'js_composer' )  => 'yearly',
                    __( 'Monthly', 'js_composer' )   => 'monthly'
                ),
                'dependency'  => array('element' => 'active_filter', 'value' => 'yes'),
            ),
        ),
    )
);


class WPBakeryShortCode_sanjose_pricing_item extends WPBakeryShortCode{
    protected function content( $atts, $content = null ) {
        global $sanjose_pricing_items;
        $sanjose_pricing_items[] = array( 'atts' => $atts, 'content' => $content);
        return;
    }
}