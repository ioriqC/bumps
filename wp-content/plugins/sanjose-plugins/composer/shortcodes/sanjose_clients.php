<?php
/*
 * Clients Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0
 */

vc_map(
    array(
        'name'                    => __( 'Clients', 'js_composer' ),
        'base'                    => 'sanjose_clients',
        'content_element'         => true,
        'show_settings_on_create' => true,
        'params' => array(
            array (
                'param_name' => 'clients_style',
                'type' => 'dropdown',
                'description' => '',
                'heading' => 'Clients style',
                'value' =>
                    array (
                        'Corporate'       => 'corporate',
                        'All information' => 'all-information',
                    ),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => 'Title',
                'param_name'  => 'title',
                'admin_label' => true,
                'value'       => '',
                'dependency' => array( 'element' => 'clients_style', 'value' => 'all-information' ),
            ),

            array(
                'type'       => 'param_group',
                'heading'    => __( 'Item clients', 'js_composer' ),
                'param_name' => 'items_all',
                'params'     => array(
                    array(
                        'type'        => 'attach_image',
                        'heading'     => __( 'Image', 'js_composer' ),
                        'param_name'  => 'image'
                    ),
                    array(
                        'type'        => 'href',
                        'heading'     => 'Url',
                        'param_name'  => 'logo_link',
                        'admin_label' => true,
                        'value'       => '',
                    ),

                    array(
                        'type'        => 'textfield',
                        'heading'     => 'Title hover',
                        'param_name'  => 'title_hover',
                        'admin_label' => true,
                        'value'       => '',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => 'Description hover',
                        'param_name'  => 'descriptioin_hover',
                        'admin_label' => true,
                        'value'       => '',
                    ),

                ),
                'dependency' => array( 'element' => 'clients_style', 'value' => 'all-information' ),
                'callbacks' => array(
                    'after_add' => 'vcChartParamAfterAddCallback'
                )
            ),

            array(
                'type'       => 'param_group',
                'heading'    => __( 'Logos', 'js_composer' ),
                'param_name' => 'items',
                'params'     => array(
                    array(
                        'type'        => 'attach_image',
                        'heading'     => __( 'Image', 'js_composer' ),
                        'param_name'  => 'image'
                    ),
                    array(
                        'type'        => 'href',
                        'heading'     => 'Url',
                        'param_name'  => 'logo_link',
                        'admin_label' => true,
                        'value'       => '',
                    ),
                ),
                'dependency' => array( 'element' => 'clients_style', 'value' => 'corporate' ),
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

class WPBakeryShortCode_sanjose_clients extends WPBakeryShortCode{
    protected function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
            'title'         => '',
            'items_all'     => '',
            'clients_style' => 'corporate',
            'items'         => '',
            'el_class'      => '',
            'css' 	        => ''
        ), $atts ) );

        $output = '';
        $items 	= json_decode( urldecode( $items ), true );
        $items_all 	= json_decode( urldecode( $items_all ), true );
        $class  = ( ! empty( $el_class ) ) ? $el_class : '';
        $class 	.= vc_shortcode_custom_css_class( $css, ' ' );
        if ( isset( $clients_style ) && $clients_style == 'corporate'){

            if( ! empty( $items ) ) {

                $output .= '<div class="sanjose-clients clearfix ' . $class . '">';

                    foreach ( $items as $item ) {

                        $image 	= ( ! empty( $item['image'] ) && is_numeric( $item['image'] ) ) ? wp_get_attachment_url( $item['image'] ) : '';

                        if( ! empty( $image ) ) {

                            // Image client
                            $logo = '<img src="' . esc_url( $image ) . '" alt=""/>';

                            $output .= '<div class="clients-item">';
                            if( ! empty( $item['logo_link'] ) ) {
                                $output .= '<a href=' . esc_url( $item['logo_link'] ) . '>';
                                    $output .= $logo;
                                $output .= '</a>';
                            } else {
                                $output .= $logo;
                            }
                            $output .= '</div>';
                        }
                    }

                $output .= '</div>';

                return $output;
            }
        }else{
            $output .= '<div class="row sanjose-clients-all-information">';
            if ( !empty( $title ) ):
                $output .= '<h3 class="sanjose-clients-title">' . $title . '</h3>';
            endif;
                if ( ! empty( $items_all ) ){
                    foreach ( $items_all as $item_all ) {

                        $image 	= ( ! empty( $item_all['image'] ) && is_numeric( $item_all['image'] ) ) ? wp_get_attachment_url( $item_all['image'] ) : '';
                        $output .= '<div class="col-sm-3 col-md-3">';
                            $output .= '<div class="sanjose-wrap-info">';
                                $output .= '<img src="' . esc_url( $image ) . '" alt="' . esc_url( $image ) . '" class="hidden-img sanjose-clients-img">';
                                $output .= '<div class="sanjose-container">';
                                    $output .= '<div class="sanjose-text-content">';
                                        $output .= '<h1 class="sanjose-title-clients">' . $item_all['title_hover'] . '</h1>';
                                        $link_logo = ( !empty( $item_all['logo_link'] ) )? $item_all['logo_link'] : '';
                                        $output .= '<a href="' . esc_url( $link_logo ) . '" class="sanjose-decs-clients">' . $item_all['descriptioin_hover'] . '</a>';
                                    $output .= '</div>';
                                $output .= '</div>';
                            $output .= '</div>';
                        $output .= '</div>';
                    }
                }
            $output .= '</div>';
            return $output;
        }
    }
}