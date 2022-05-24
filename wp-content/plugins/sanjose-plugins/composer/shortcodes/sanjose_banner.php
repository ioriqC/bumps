<?php
/*
 * Banner Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0 
 */

vc_map(
    array(
        'name' => __('Banner', 'js_composer'),
        'base' => 'sanjose_banner',
        'params' => array(
            array(
                'heading' => __('Banner style', 'js_composer'),
                'type' => 'dropdown',
                'param_name' => 'banner_style',
                'value' => array(
                    __('Style 1', 'js_composer') => 'style_1',
                    __('Style 2', 'js_composer') => 'style_2',
                    __('Style 3', 'js_composer') => 'style_3',
                    __('Style 4', 'js_composer') => 'style_4',
                    __('Style 5', 'js_composer') => 'style_5',
                    __('Style 6', 'js_composer') => 'style_6',
                ),
            ),
            array(
                'type' => 'textarea',
                'heading' => __('Title', 'js_composer'),
                'param_name' => 'title',
            ),
            array(
                'type' => 'textarea',
                'heading' => __('Subtitle', 'js_composer'),
                'param_name' => 'subtitle',
                'value' => '',
                'dependency' => array('element' => 'banner_style', 'value_not_equal_to' => array('style_3', 'style_5')),
            ),
            array(
                'type' => 'textarea',
                'heading' => __('Text', 'js_composer'),
                'param_name' => 'text',
                'value' => '',
            ),
            array(
                'heading' => __('Type banner', 'js_composer'),
                'type' => 'dropdown',
                'param_name' => 'type_banner',
                'value' => array(
                    __('Image', 'js_composer') => 'image',
                    __('Video', 'js_composer') => 'video',
                    __('Particles', 'js_composer') => 'particles',
                ),
                'dependency' => array('element' => 'banner_style', 'value_not_equal_to' => 'style_4'),
            ),
            array(
                'type' => 'attach_image',
                'heading' => __('Image', 'js_composer'),
                'param_name' => 'image',
                'dependency' => array('element' => 'type_banner', 'value' => 'image'),
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Enable paralax effect', 'js_composer'),
                'param_name' => 'check_paralax',
                'dependency' => array('element' => 'type_banner', 'value' => 'image'),
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Video url', 'js_composer'),
                'param_name' => 'video_url',
                'value' => '',
                'dependency' => array('element' => 'type_banner', 'value' => 'video'),
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Mailchimp form', 'js_composer'),
                'param_name' => 'mailchimp_form',
                'value' => '',
                'dependency' => array('element' => 'banner_style', 'value' => 'style_5'),
            ),
            array(
                'type' => 'attach_image',
                'heading' => __('Content Image', 'js_composer'),
                'param_name' => 'image_content',
                'dependency' => array('element' => 'banner_style', 'value' => array('style_1', 'style_2')),
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => __( 'Image video', 'js_composer' ),
                'param_name'  => 'image_video_bg',
                'dependency' => array('element' => 'banner_style', 'value' => 'style_2'),
            ),
            array(
                'heading' => __('Link', 'js_composer'),
                'type' => 'vc_link',
                'param_name' => 'link',
                'value' => '',
                'dependency' => array('element' => 'banner_style', 'value_not_equal_to' => array('style_5', 'style_2')),
                'group' => __('Buttons', 'js_composer')
            ),
            array(
                'heading' => __('Position button', 'js_composer'),
                'type' => 'checkbox',
                'param_name' => 'position_btn',
                'value' => '',
                'dependency' => array('element' => 'banner_style', 'value_not_equal_to' => array('style_5', 'style_2')),
                'group' => __('Buttons', 'js_composer')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Extra class name', 'js_composer'),
                'param_name' => 'el_class',
                'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer'),
                'value' => ''
            ),
            /* Buttons style 2 */
            array(
                'type' => 'href',
                'heading' => 'First button url',
                'param_name' => 'first_button_url',
                'admin_label' => true,
                'value' => '',
                'dependency' => array('element' => 'banner_style', 'value' => 'style_2'),
                'group' => __('Buttons', 'js_composer')
            ),
            array(
                'type' => 'attach_image',
                'heading' => __('First button image', 'js_composer'),
                'param_name' => 'first_button_image',
                'dependency' => array('element' => 'banner_style', 'value' => 'style_2'),
                'group' => __('Buttons', 'js_composer')
            ),
            array(
                'type' => 'href',
                'heading' => 'Second button url',
                'param_name' => 'second_button_url',
                'admin_label' => true,
                'value' => '',
                'dependency' => array('element' => 'banner_style', 'value' => 'style_2'),
                'group' => __('Buttons', 'js_composer')
            ),
            array(
                'type' => 'attach_image',
                'heading' => __('Second button image', 'js_composer'),
                'param_name' => 'second_button_image',
                'dependency' => array('element' => 'banner_style', 'value' => 'style_2'),
                'group' => __('Buttons', 'js_composer')
            ),
            /* Style tab */
            array(
                'heading' => __('Enable custom height', 'js_composer'),
                'type' => 'dropdown',
                'param_name' => 'custom_height',
                'value' => array(
                    __('Disable', 'js_composer') => 'disable',
                    __('Enable', 'js_composer') => 'enable',
                ),
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'textarea',
                'heading' => __('Custom height', 'js_composer'),
                'param_name' => 'custom_height_value',
                'value' => '',
                'dependency' => array('element' => 'custom_height', 'value' => 'enable'),
                'group' => __('Style', 'js_composer')
            ),
            array(
                'heading' => __('Block align', 'js_composer'),
                'type' => 'dropdown',
                'param_name' => 'align',
                'value' => array(
                    __('Center', 'js_composer') => 'center',
                    __('Left', 'js_composer') => 'left',
                    __('Right', 'js_composer') => 'right'
                ),
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Title font size', 'js_composer'),
                'param_name' => 'title_font_size',
                'value' => '',
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Title color', 'js_composer'),
                'param_name' => 'title_color',
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Title font family', 'js_composer'),
                'param_name' => 'title_font_family',
                'value' => array(
                    __('Default', 'js_composer') => 'default',
                    __('Custom', 'js_composer') => 'custom'
                ),
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'title_font',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => __('Select font family.', 'js_composer'),
                        'font_style_description' => __('Select font styling.', 'js_composer'),
                    ),
                ),
                'dependency' => array('element' => 'title_font_family', 'value' => 'custom'),
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Subtitle font size', 'js_composer'),
                'param_name' => 'subtitle_font_size',
                'value' => '',
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Subtitle color', 'js_composer'),
                'param_name' => 'subtitle_color',
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Subtitle font family', 'js_composer'),
                'param_name' => 'subtitle_font_family',
                'value' => array(
                    __('Default', 'js_composer') => 'default',
                    __('Custom', 'js_composer') => 'custom'
                ),
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'subtitle_font',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => __('Select font family.', 'js_composer'),
                        'font_style_description' => __('Select font styling.', 'js_composer'),
                    ),
                ),
                'dependency' => array('element' => 'subtitle_font_family', 'value' => 'custom'),
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Text font size', 'js_composer'),
                'param_name' => 'text_font_size',
                'value' => '',
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Text color', 'js_composer'),
                'param_name' => 'text_color',
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Text font family', 'js_composer'),
                'param_name' => 'text_font_family',
                'value' => array(
                    __('Default', 'js_composer') => 'default',
                    __('Custom', 'js_composer') => 'custom'
                ),
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'text_font',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => __('Select font family.', 'js_composer'),
                        'font_style_description' => __('Select font styling.', 'js_composer'),
                    ),
                ),
                'dependency' => array('element' => 'text_font_family', 'value' => 'custom'),
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Button color', 'js_composer'),
                'param_name' => 'button_color',
                'group' => __('Style', 'js_composer')
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Button text color', 'js_composer'),
                'param_name' => 'button_text_color',
                'group' => __('Style', 'js_composer')
            ),
            /* Gradient colors */
            array(
                'type' => 'colorpicker',
                'heading' => __('Top gradient color 1', 'js_composer'),
                'param_name' => 'top_gradient_color',
                'group' => __('Gradient colors', 'js_composer'),
                'value' => '#455eb8',
                'dependency' => array('element' => 'banner_style', 'value' => 'style_6'),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Top gradient color 2', 'js_composer'),
                'param_name' => 'top_gradient_color_two',
                'value' => '#72c5db',
                'group' => __('Gradient colors', 'js_composer'),
                'dependency' => array('element' => 'banner_style', 'value' => 'style_6'),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Bottom gradient color 1', 'js_composer'),
                'param_name' => 'bottom_gradient_color',
                'group' => __('Gradient colors', 'js_composer'),
                'value' => '#48d7db',
                'dependency' => array('element' => 'banner_style', 'value' => 'style_6'),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Bottom gradient color 2', 'js_composer'),
                'param_name' => 'bottom_gradient_color_two',
                'group' => __('Gradient colors', 'js_composer'),
                'value' => '#17174d',
                'dependency' => array('element' => 'banner_style', 'value' => 'style_6'),
            ),
            /* CSS editor */
            array(
                'type' => 'css_editor',
                'heading' => __('CSS box', 'js_composer'),
                'param_name' => 'css',
                'group' => __('Design options', 'js_composer')
            )
        )
    )
);

class WPBakeryShortCode_sanjose_banner extends WPBakeryShortCode
{
    protected function content($atts, $content = null)
    {

        extract(shortcode_atts(array(
            'title' => '',
            'subtitle' => '',
            'text' => '',
            'image_content' => '',
            'type_banner' => 'image',
            'image' => '',
            'video_url' => '',
            'mailchimp_form' => '',
            'check_paralax' => '',
            'link' => '',
            'position_btn' => '',
            'image_video_bg' => '',
            'banner_style' => 'style_1',
            'el_class' => '',
            'first_button_url' => '',
            'first_button_image' => '',
            'second_button_url' => '',
            'second_button_image' => '',
            'custom_height' => 'disable',
            'custom_height_value' => '',
            'align' => 'center',
            'title_font_size' => '',
            'title_color' => '',
            'button_text_color' => '',
            'title_font_family' => 'default',
            'title_font' => '',
            'subtitle_font_size' => '',
            'button_color' => '',
            'subtitle_color' => '',
            'subtitle_font_family' => 'default',
            'subtitle_font' => '',
            'text_font_size' => '',
            'text_color' => '',
            'text_font_family' => 'default',
            'text_font' => '',
            'top_gradient_color' => '#455eb8',
            'top_gradient_color_two' => '#72c5db',
            'bottom_gradient_color ' => '#48d7db',
            'bottom_gradient_color_two' => '#17174d',
            'css' => ''
        ), $atts));

        wp_enqueue_script( 'sanjose_youtube', 'https://www.youtube.com/iframe_api', '', true );

        $google_fonts = new Vc_Google_Fonts;
        if ($banner_style == 'style_6') {
            if (empty($top_gradient_color)) {
                $top_gradient_color = '#455eb8';
            }
            if (empty($top_gradient_color_two)) {
                $top_gradient_color_two = '#72c5db';
            }
            if (empty($bottom_gradient_color)) {
                $bottom_gradient_color = '#48d7db';
            }
            if (empty($bottom_gradient_color_two)) {
                $bottom_gradient_color_two = '#17174d';
            }
            $gradient = ' background-image: linear-gradient(180deg, ' . $top_gradient_color . ' 0%, ' . $top_gradient_color_two . ' 100%), linear-gradient(to top, ' . $bottom_gradient_color . ' 0%, ' . $bottom_gradient_color_two . ' 91%, ' . $bottom_gradient_color_two . ' 100%);';
        } else {
            $gradient = '';
        }

        $class = (!empty($el_class)) ? $el_class : '';
        $class .= vc_shortcode_custom_css_class($css, ' ');
        $class .= (isset($banner_style) && $banner_style == 'style_1') ? ' style_1' : ' ' . $banner_style;
        $class .= ' text-' . $align;
        $class .= $check_paralax ? ' bg_paralax ' : '';

        $title_style = '';
        $subtitle_style = '';
        $text_style = '';
        $styles = array('title', 'subtitle', 'text');

        foreach ($styles as $item) {

            if (!empty(${$item . "_font_size"})) {
                ${$item . "_style"} = (is_numeric(${$item . "_font_size"})) ? 'font-size: ' . ${$item . "_font_size"} . 'px;' : 'font-size: ' . ${$item . "_font_size"} . ';';
                ${$item . "_style"} .= (is_numeric(${$item . "_font_size"})) ? 'line-height: ' . ${$item . "_font_size"} . 'px;' : 'line-height: ' . ${$item . "_font_size"} . ';';
            }
            ${$item . "_style"} .= (!empty(${$item . "_color"})) ? 'color: ' . ${$item . "_color"} . ';' : '';

            if (${$item . "_font_family"} == 'custom') {
                ${$item . "_font"} = $google_fonts->_vc_google_fonts_parse_attributes($atts, ${$item . "_font"});

                $subsets = '';
                $settings = get_option('wpb_js_google_fonts_subsets');
                if (is_array($settings) && !empty($settings)) {
                    $subsets = '&subset=' . implode(',', $settings);
                }

                wp_enqueue_style('vc_google_fonts_' . vc_build_safe_css_class(${$item . "_font"}['values']['font_family']), '//fonts.googleapis.com/css?family=' . ${$item . "_font"}['values']['font_family'] . $subsets);

                $google_fonts_family = explode(':', ${$item . "_font"}['values']['font_family']);
                ${$item . "_style"} .= 'font-family:' . $google_fonts_family[0] . ';';
                $google_fonts_styles = explode(':', ${$item . "_font"}['values']['font_style']);
                ${$item . "_style"} .= 'font-weight:' . $google_fonts_styles[1] . ';';
                ${$item . "_style"} .= 'font-style:' . $google_fonts_styles[2] . ';';
            }

            ${$item . "_style"} = (!empty(${$item . "_style"})) ? 'style="' . ${$item . "_style"} . '"' : '';

        }


        // Custom height
        $custom_height_value = (isset($custom_height) && $custom_height == 'enable') ? 'height:' . $custom_height_value . 'px;' : '';


        // Image
        $image = (!empty($image) && is_numeric($image)) ? wp_get_attachment_url($image) : '';

        // Image content
        $image_content = (!empty($image_content) && is_numeric($image_content)) ? wp_get_attachment_url($image_content) : '';

        // Title
        $title = (!empty($title)) ? '<h2 ' . $title_style . ' class="title">' . $title . '</h2>' : '';

        // Subtitle
        $subtitle = (!empty($subtitle)) ? '<h6 class="subtitle" ' . $subtitle_style . '>' . $subtitle . '</h6>' : '';

        // Text
        $text = (!empty($text)) ? '<p ' . $text_style . '>' . $text . '</p>' : '';

        // Links
        $banner_link = vc_build_link($link);
        $banner_link_target = (!empty($banner_link['target'])) ? 'target="' . $banner_link['target'] . '"' : '';

        // Button shadow
        $button_text_color_i = (!empty($button_text_color)) ? "color : $button_text_color" : '';
        $button_text_color = (!empty($button_text_color)) ? "$button_text_color" : '';
        $button_color_background = ( ! empty( $button_color ) ) ? 'background-color: ' . $button_color . ' ;' : '' ;
        $button = (!empty($banner_link['url'])) ? '<a data-color="' . $button_color .  '" data-text-color="'. $button_text_color .'" href="' . $banner_link['url'] . '" ' . $banner_link_target . ' class="btn" style="'. $button_color_background .'  border-color: ' . $button_color . '; ' . $button_text_color_i . '">' . $banner_link['title'] . '</a>' : '';

        // No image content
        $no_image_content = (empty($image_content)) ? 'no-image-content' : '';

        $output = '';

        $output .= '<div class="iframe-video banner-video youtube play sanjose-video-banner sanjose-banner ' . $class . ' ' . $no_image_content . '" style=" ' . $custom_height_value . ' ' . $gradient . ' " data-type-start="click">';

        if (isset($banner_style) && $banner_style !== 'style_4' && isset($type_banner) && $type_banner == 'image' && !empty($image)) {
            $output .= '<img src="' . $image . '" class="hidden-img" alt=" " />';
        } elseif (isset($banner_style) && $banner_style !== 'style_4' && isset($type_banner) && $type_banner == 'video') {

            $video_params = array(
                'enablejsapi' => 1,
                'autoplay' => 1,
                'loop' => 1,
                'controls' => 0,
                'showinfo' => 0,
                'start' => 0,
                'end' => 0,
                'modestbranding' => 0,
                'rel' => 0,
            );


            if (!empty($video_url)) {
                $output .= '<div class="video-iframe video_popup fluid-width-video-wrapper" style="background-image:url(' . wp_get_attachment_url($image_video_bg) . ')">';
                $output .= str_replace("?feature=oembed", "?feature=oembed&" . http_build_query($video_params), wp_oembed_get($video_url));
                $output .= '</div>';
            }
        } elseif (isset($banner_style) && $banner_style !== 'style_4' && isset($type_banner) && $type_banner == 'particles') {
            $output .= '<div id="particles-js"></div>';
        }

        if (isset($banner_style) && $banner_style != 'style_2') :
            $output .= '<div class="content-banner">';

            // Subtitle Banner
            if (!empty($subtitle) && $banner_style != 'style_5') :
                $output .= $subtitle;
            endif;

            // Title Banner
            if (!empty($title)) :
                $output .= $title;
            endif;

            // Content Banner
            if (!empty($text)) :
                $output .= '<div>' . wp_kses_post($text) . '</div>';
            endif;

            // Mailchimp form
            if (!empty($mailchimp_form)) {
                $output .= do_shortcode($mailchimp_form);
            }

            // Button Banner
            if (!empty($banner_link['url']) && !empty($banner_link['title']) && $banner_style != 'style_5' &&   empty( $position_btn ) ) :
                $output .= $button;
            endif;

            $output .= '</div>';
        endif;

        if (isset($banner_style) && $banner_style == 'style_2') {

            $output .= '<div class="container no-padd-md">';
            $output .= '<div class="row">';
            $output .= '<div class="col-md-7">';
            $output .= '<div class="content-banner" >';

			if ( isset($type_banner) && $type_banner == 'video' ) {
				$output .= '<div class="video-content">
                            <a href="#" class="play-button"></a>
                        </div>';
			}

            // Subtitle Banner
            if (!empty($subtitle)) :
                $output .= $subtitle;
            endif;

            // Title Banner
            if (!empty($title)) :
                $output .= $title;
            endif;

            // Content Banner
            if (!empty($text)) :
                $output .= wp_kses_post($text);
            endif;

            // Button Banner
            if (!empty($banner_link['url']) && !empty($banner_link['title']) && $banner_style != 'style_5' && !empty( $position_btn )) :
                $output .= $button;
            endif;

            // Buttons Banner
            $output .= '<div class="list-button">';
            if (!empty($first_button_url) && !empty($first_button_image)) :
                $first_button_image = (!empty($first_button_image)) ? 'style="background-image:url(' . wp_get_attachment_url($first_button_image) . ')"' : '';
                $output .= '<a href="' . esc_url($first_button_url) . '" ' . $first_button_image . '></a>';
            endif;

            if (!empty($second_button_url) && !empty($second_button_image)) :
                $second_button_image = (!empty($second_button_image)) ? 'style="background-image:url(' . wp_get_attachment_url($second_button_image) . ')"' : '';
                $output .= '<a href="' . esc_url($second_button_url) . '" ' . $second_button_image . '></a>';
            endif;
            $output .= '</div>';

            $output .= '</div>';
            $output .= '</div>';
            $output .= '<div class="col-md-5">';
            $output .= '<div class="wrapp-img">';

	        if(!empty($image_content)) {
		        $output .= '<img src="' . $image_content . '" class="img-responsive" alt=" " />';
	        }

            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        }

        if (isset($banner_style) && $banner_style == 'style_1') :
            $output .= '<div class="absolute-img">';
            if ( ! empty( $banner_link['url'] ) && !empty($banner_link['title']) && !empty( $position_btn ) ) :
                $output .= $button;
            endif;

            if(!empty($image_content)){
            $output .= '<img src="' . $image_content . '" class="img-responsive" alt=" " />';
            }


            $output .= '</div>';
        endif;

        $output .= '</div>';

        return $output;
    }
}