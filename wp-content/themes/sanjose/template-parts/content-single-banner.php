<?php
/**
 * The single banner template file.
 *
 * @package sanjose
 * @since 1.0.0
 *
 */
$meta_opt = get_post_meta( get_the_ID(), 'sanjose_post_options', true );


$style_banner_blog = cs_get_option('style_banner');
$title_banner_blog = cs_get_option('title_banner');
$subtitle_banner_blog = cs_get_option('subtitle_banner');
$text_banner_blog = cs_get_option('text_banner');
$type_banner_blog = cs_get_option('type_banner');
$bg_banner_blog = cs_get_option('bg_banner');
$check_paralax_blog = cs_get_option('check_paralax');
$video_url_blog = cs_get_option('video_url');
$image_content_blog = cs_get_option('image_content');
$banner_link_blog = cs_get_option('banner_link');
$first_button_url_blog = cs_get_option('first_button_url');
$first_button_image_blog = cs_get_option('first_button_image');
$second_button_url_blog = cs_get_option('second_button_url');
$second_button_image_blog = cs_get_option('second_button_image');
$mailchimp_form_blog = cs_get_option('mailchimp_form');
$top_gradient_color_blog = cs_get_option('top_gradient_color');
$top_gradient_color_two_blog = cs_get_option('top_gradient_color_two');
$bottom_gradient_color_blog = cs_get_option('bottom_gradient_color');
$bottom_gradient_color_two_blog = cs_get_option('bottom_gradient_color_two');


// images
$bg_banner_detail_blog = ( ! empty ( $meta_opt['bg_banner'] ) ) ? $meta_opt['bg_banner'] : $bg_banner_blog;
$image_content_detail_blog  = ( ! empty( $meta_opt['image_content'] )) ? $meta_opt['image_content'] : $image_content_blog;
$bg_banner     =  wp_get_attachment_image_src( $bg_banner_detail_blog, 'full')[0] ;
$image_content =  wp_get_attachment_image_src( $image_content_detail_blog, 'full')[0];

// Banner post
$style_banner  = ( ! empty( $meta_opt['style_banner'] ) ) ? $meta_opt['style_banner'] : $style_banner_blog;
$type_banner   = ( ! empty( $meta_opt['type_banner'] ) ) ? $meta_opt['type_banner'] : $type_banner_blog;
$banner_class =  ( ! empty( $style_banner ) ) ? $style_banner : '';

$check_paralax_detail_blog = ( ! empty( $check_paralax_blog ) ) ? ' bg_paralax' : '';
$banner_class .= ( ! empty( $meta_opt['check_paralax'] ) ) ? ' bg_paralax' : $check_paralax_detail_blog;
$banner_class .= ( empty( $image_content ) ) ? ' no-image-content' : '';
$banner_class .= ( ! empty( $meta_opt['align'] ) ) ? ' text-' . $meta_opt['align'] : '';

// video params
$video_params = '&rel=0&autoplay=1&controls=0&loop=1&showinfo=0';

// gradients
if( $style_banner == 'style_6' ) {
    $top_gradient_color        = ( ! empty( $meta_opt['top_gradient_color'] ) ) ? $meta_opt['top_gradient_color'] : $top_gradient_color_blog ;
    $top_gradient_color_two        = ( ! empty( $meta_opt['top_gradient_color_two'] ) ) ? $meta_opt['top_gradient_color_two'] : $top_gradient_color_two_blog ;
    $bottom_gradient_color        = ( ! empty( $meta_opt['bottom_gradient_color'] ) ) ? $meta_opt['bottom_gradient_color'] : $bottom_gradient_color_blog ;
    $bottom_gradient_color_two        = ( ! empty( $meta_opt['bottom_gradient_color_two'] ) ) ? $meta_opt['bottom_gradient_color_two'] : $bottom_gradient_color_two_blog ;

    if( empty( $top_gradient_color ) ) {
        $top_gradient_color = '#455eb8';
    }

    if( empty( $top_gradient_color_two ) ) {
        $top_gradient_color_two = '#72c5db';
    }

    if( empty( $bottom_gradient_color ) ) {
        $bottom_gradient_color = '#48d7db';
    }

    if( empty( $bottom_gradient_color_two ) ) {
        $bottom_gradient_color_two = '#17174d';
    }

    $gradient = 'style="background-image: linear-gradient(180deg, ' . $top_gradient_color . ' 0%, ' . $top_gradient_color_two . ' 100%), linear-gradient(to top, ' . $bottom_gradient_color . ' 0%, ' . $bottom_gradient_color_two . ' 91%, ' . $bottom_gradient_color_two . ' 100%);"';
} else {
    $gradient = '';
}

// Custom styles
$title_style = $subtitle_style = $text_style = '';

// title
$title_font_size   = ( ! empty( $meta_opt['title_font_size'] ) ) ? $meta_opt['title_font_size'] : '';
$title_font        = ( ! empty( $meta_opt['title_font'] ) ) ? $meta_opt['title_font'] : '';
$title_color       = ( ! empty( $meta_opt['title_color'] ) ) ? $meta_opt['title_color'] : '';
$title_font_switch = ( ! empty( $meta_opt['title_font_switch'] ) ) ? $meta_opt['title_font_switch'] : '';

// subtile
$subtitle_font_size   = ( ! empty( $meta_opt['subtitle_font_size'] ) ) ? $meta_opt['subtitle_font_size'] : '';
$subtitle_font        = ( ! empty( $meta_opt['subtitle_font'] ) ) ? $meta_opt['subtitle_font'] : '';
$subtitle_color       = ( ! empty( $meta_opt['subtitle_color'] ) ) ? $meta_opt['subtitle_color'] : '';
$subtitle_font_switch = ( ! empty( $meta_opt['subtitle_font_switch'] ) ) ? $meta_opt['subtitle_font_switch'] : '';

// text
$text_font_size   = ( ! empty( $meta_opt['text_font_size'] ) ) ? $meta_opt['text_font_size'] : '';
$text_font        = ( ! empty( $meta_opt['text_font'] ) ) ? $meta_opt['text_font'] : '';
$text_color       = ( ! empty( $meta_opt['text_color'] ) ) ? $meta_opt['text_color'] : '';
$text_font_switch = ( ! empty( $meta_opt['text_font_switch'] ) ) ? $meta_opt['text_font_switch'] : '';

$styles_content = array('title', 'subtitle', 'text');

foreach ($styles_content as $item) {
    if ( ! empty( ${$item."_font"}['family'] ) && ${$item."_font_switch"}  == 'custom' ) {
        ${$item."_style"} = 'font-family:' . ${$item."_font"}['family']  . '; ' . "\n\r";
        ${$item."_style"} .= 'font-weight:' . (int)${$item."_font"}['variant']  . '; ' . "\n\r";
        ${$item."_style"} .= 'font-style:' .   preg_replace('/[0-9]+/', '', ${$item."_font"}['variant']). '; ' . "\n\r";


        if ( ${$item."_font_switch"}  == 'custom' ) {
            wp_enqueue_style( 'sanjose_header_typography', '//fonts.googleapis.com/css?family=' . ${$item."_font"}['family']  . ':' . ${$item."_font"}['variant'] );
        }
    }
    if ( ${$item."_font_switch"}  == 'custom' ) {
        ${$item."_style"} .= ( ! empty( ${$item."_color"} ) ) ? 'color: ' . ${$item."_color"} . ';' : '';
        ${$item."_style"} .= ( ! empty( ${$item."_font_size"} ) ) ? 'font-size: ' . ${$item."_font_size"} . 'px;' : '';
        ${$item."_style"} = ( ! empty( ${$item."_style"} ) ) ? 'style="' . ${$item."_style"} . '"' : '';
    }
}

$image_content_title_banner_blog  = ( ! empty( $meta_opt['title_banner'] )) ? $meta_opt['title_banner'] : $title_banner_blog;
$image_content_subtitle_banner_blog  = ( ! empty( $meta_opt['subtitle_banner'] )) ? $meta_opt['subtitle_banner'] : $subtitle_banner_blog;
$image_content_text_banner_blog  = ( ! empty( $meta_opt['text_banner'] ) ) ? $meta_opt['text_banner'] : $text_banner_blog;

if ( ! empty( $image_content_title_banner_blog ) || ! empty( $image_content_subtitle_banner_blog ) || ! empty( $image_content_text_banner_blog ) || $bg_banner ) : ?>
    <div class="sanjose-banner banner-blog banner-post background-wrapp <?php echo esc_attr( $banner_class ); ?>" <?php echo wp_kses_post( $gradient ); ?>>
        <!-- Background image -->
        <?php if ( $style_banner != 'style_4' && $type_banner == 'image' && ! empty( $bg_banner ) ) : ?>
            <img src="<?php echo esc_url( $bg_banner ); ?>" class="hidden-img" alt="image" />
        <?php endif; ?>

        <div class="container sanjose-container">

            <!-- Video -->
            <?php
            $style_video_url_blog  = ( ! empty( $meta_opt['video_url'] ) ) ? $meta_opt['video_url'] : $video_url_blog;
            if ( $style_banner != 'style_4' && $type_banner == 'video' && ! empty( $style_video_url_blog ) ) :
                $video = str_replace("?feature=oembed", "?" . trim( $video_params,'&' ), wp_oembed_get( $meta_opt['video_url'] ) ); ?>
                <div class="video-iframe">
                    <?php echo wp_kses_post( $video ); ?>
                </div>
            <?php endif; ?>

            <!-- Particles -->
            <?php if ( $style_banner != 'style_4' && $type_banner == 'particles' ) : ?>
                <div id="particles-js"></div>
            <?php endif; ?>

            <!-- Content banner -->
            <div class="banner-blog__content content-banner">
                
                <?php if ( $type_banner != 'style_3' && $type_banner != 'style_5' && ! empty( $image_content_subtitle_banner_blog ) ) : ?>
                    <h6 class="subtitle" <?php echo esc_url( $subtitle_style ); ?>><?php echo esc_html( $image_content_subtitle_banner_blog ); ?></h6>
                <?php endif;

                if ( ! empty( $image_content_title_banner_blog ) ) : ?>
                    <h2 class="title" <?php echo esc_url( $title_style ); ?>><?php echo wp_kses_post( $image_content_title_banner_blog ); ?></h2>
                <?php endif;

                if ( ! empty( $image_content_text_banner_blog  ) ) : ?>
                    <p <?php echo esc_attr( $text_style ); ?>><?php echo wp_kses_post( $image_content_text_banner_blog ); ?></p>
                <?php endif;

                // Mailchimp form

                $mailchimp_form_banner_blog  = ( ! empty( $meta_opt['mailchimp_form'] ) ) ? $meta_opt['mailchimp_form'] : $mailchimp_form_blog;
                if ( $style_banner == 'style_5' && ! empty( $mailchimp_form_banner_blog ) ) :
                    echo do_shortcode( $mailchimp_form_banner_blog );
                endif;

                // Button link
                if ( $style_banner != 'style_5' ) :

                    $link_form_banner_blog  = ( ! empty( $meta_opt['banner_link'] ) ) ? $meta_opt['banner_link'] : $banner_link_blog;
                    $banner_link = ( ! empty( $link_form_banner_blog ) ) ? $link_form_banner_blog : '';
                    if ( ! empty( $banner_link['banner_post_link'] ) && ! empty( $banner_link['banner_post_link_text'] ) ) : ?>
                        <a href="<?php echo esc_url( $banner_link['banner_post_link'] ); ?>" class="btn"><?php echo esc_html( $banner_link['banner_post_link_text'] ); ?></a>
                    <?php endif; 
                endif;
                
                // Image Buttons
                if ( $style_banner == 'style_2' ) : ?>
                    <?php
                    $first_button_url_blog_bunner = ( ! empty( $meta_opt['first_button_url'] ) ) ? $meta_opt['first_button_url'] : $first_button_url_blog;
                    $first_button_image_bunner    = ( ! empty( $meta_opt['first_button_image'] ) ) ? $meta_opt['first_button_image'] : $first_button_image_blog;
                    $second_button_url_blog_bunner = ( ! empty( $meta_opt['second_button_url'] ) ) ? $meta_opt['second_button_url'] : $second_button_url_blog;
                    $first_button_image_blog_bunner = ( ! empty( $meta_opt['second_button_image'] ) ) ? $meta_opt['second_button_image'] : $first_button_image_blog;

                    ?>
                    <div class="list-button">
                        <?php if ( ! empty( $first_button_url_blog_bunner ) && ! empty( $meta_opt['first_button_image'] ) ) : ?>
                            <a href="<?php echo esc_url( $first_button_url_blog_bunner ); ?>" style="background-image: url( <?php echo wp_get_attachment_url($first_button_image_bunner); ?>);"></a>
                        <?php endif;
                        if ( ! empty( $second_button_url_blog_bunner ) && ! empty( $first_button_image_blog_bunner ) ) : ?>
                            <a href="<?php echo esc_url( $second_button_url_blog_bunner ); ?>" style="background-image: url( <?php echo wp_get_attachment_url( $first_button_image_blog_bunner ); ?>);"></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>

            <?php if ( ( $style_banner == 'style_1' || $style_banner == 'style_2') && ! empty( $image_content ) ): ?>
                <div class="absolute-img">
                    <img src="<?php echo esc_url( $image_content ); ?>" alt="image">
                </div>
            <?php endif; ?>
        </div>

    </div>
<?php endif; ?>