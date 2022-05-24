<?php
/**
 * Main Visual composer manager.
 * @var Vc_Manager - instance of composer management.
 */
global $vc_manager;
$vc_manager->setIsAsTheme();
$vc_manager->disableUpdater();
$vc_manager->setEditorDefaultPostTypes( array( 'page', 'portfolio' ) );
$vc_manager->automapper()->setDisabled();
/*
 * Multiple Select.
 */
function vc_efa_chosen($settings, $value) {

    $css_option = vc_get_dropdown_option( $settings, $value );
    $value = explode( ',', $value );
    
    $output  = '<select name="'. $settings['param_name'] .'" data-placeholder="'. $settings['placeholder'] .'" multiple="multiple" class="wpb_vc_param_value wpb_chosen chosen wpb-input wpb-efa-select '. $settings['param_name'] .' '. $settings['type'] .' '. $css_option .'" data-option="'. $css_option .'">';

    foreach ( $settings['value'] as $values => $option ) {
        $selected = ( in_array( $option, $value ) ) ? ' selected="selected"' : '';
        $output .= '<option value="'. $option .'"'. $selected .'>'.htmlspecialchars( $values ).'</option>';
    }

    $output .= '</select>' . "\n";
     
    return $output;  
}
vc_add_shortcode_param('vc_efa_chosen', 'vc_efa_chosen');

function sanjose_remove_elements( $e = array() ) {
    if ( ! empty( $e ) ) {
        foreach ( $e as $key => $remmove_this ) {
            vc_remove_element( 'vc_' . $remmove_this );
        }
    }
}
add_action( 'admin_init', 'sanjose_remove_elements', 10);

$s_elements = array( 'wp_text', 'tta_pageable', 'btn', 'line_chart', 'round_chart', 'tta_accordion', 'tta_tour', /*'tta_tabs', */'cta', 'tabs', 'tab', 'accordion', 'accordion_tab', 'custom_heading', 'clients', 'column_text', 'widget_sidebar', 'toggle', 'images_carousel', 'carousel', 'tour', 'gallery', 'posts_slider', 'posts_grid', 'teaser_grid', 'separator', 'text_separator', 'message', 'facebook', 'tweetmeme', 'googleplus', 'pinterest', /*'single_image', */'button', 'toogle', 'button2', 'cta_button', 'cta_button2', 'video', 'gmaps', 'flickr', 'progress_bar', 'raw_html', 'raw_js', 'pie', 'wp_search', 'wp_meta', 'wp_recentcomments', 'wp_calendar', 'wp_pages', 'wp_custommenu', 'wp_posts', 'wp_links', 'wp_categories', 'wp_archives', 'wp_rss', 'basic_grid', 'media_grid', 'masonry_grid', 'masonry_media_grid', 'icon', 'wp_tagcloud' );
vc_remove_element( 'client', 'testimonial' );
// sanjose_remove_elements( $s_elements );

function cr_get_row_offset( $pref, $suf, $max = 50, $step = 5 ){
    $ar = array();
    for ($i=0; $i < $max + $step; $i += $step ) {
        $ar[$i . 'px'] = $pref . '-' . $i . $suf;
    }
    return array_merge(array( 'Default'  => 'none' ), $ar );
}