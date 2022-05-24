<?php
/*
 * Slideshow Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0
 */

vc_map(
    array(
        'name'                    => __( 'Slideshow', 'js_composer' ),
        'base'                    => 'sanjose_slideshow',
        'as_parent' 		      => array('only' => 'sanjose_slideshow_item'),
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

class WPBakeryShortCode_sanjose_slideshow extends WPBakeryShortCodesContainer {
    protected function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
            'css'	   => '',
            'el_class' => ''
        ), $atts ) );

        $class  = ( ! empty( $el_class ) ) ? $el_class : '';
        $class .= vc_shortcode_custom_css_class( $css, ' ' );
        $output = '';

        global $sanjose_slideshow_items;
        $sanjose_slideshow_items = array();

        do_shortcode( $content );

        if( ! empty( $sanjose_slideshow_items ) && count( $sanjose_slideshow_items ) > 0 ) { ?>

            <div class="owl-carousel phone-wrapp">
                <?php foreach ( $sanjose_slideshow_items as $key => $item ) {
                    $value = (object) $item['atts'];

                    $image = ( ! empty( $value->image ) && is_numeric( $value->image ) ) ? wp_get_attachment_url( $value->image ) : ''; ?>

                    <div class="slider-item">
                        <img src="<?php echo esc_url($image); ?>" class="hidden-img" alt="">
                    </div>

                <?php } ?>
            </div>

        <?php }
        return $output;
    }
}

vc_map(
    array(
        'name'            => 'Item',
        'base'            => 'sanjose_slideshow_item',
        'as_child' 		  => array('only' => 'sanjose_slideshow'),
        'content_element' => true,
        'params'          => array(
            array(
                'type'        => 'attach_image',
                'heading'     => __( 'Image', 'js_composer' ),
                'param_name'  => 'image'
            ),
        ),
    )
);


class WPBakeryShortCode_sanjose_slideshow_item extends WPBakeryShortCode{
    protected function content( $atts, $content = null ) {
        global $sanjose_slideshow_items;
        $sanjose_slideshow_items[] = array( 'atts' => $atts, 'content' => $content);
        return;
    }
}