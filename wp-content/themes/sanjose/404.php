<?php
/**
 * 404 Page template.
 *
 * @package sanjose
 * @since 1.0.0
 *
 */
get_header();

$bg_images = cs_get_option('bg_images');
$background_color = cs_get_option('bg_color');
$bg_style= cs_get_option('bg_style');
$img_url = wp_get_attachment_image_src( $bg_images, 'full' )[0];
$background_image = "background-image: url( $img_url )";

$type_bg = (  $bg_style == 'color' ) ? "background-color: $background_color ;": $background_image;
?>

<div class="page-404" style=" <?php echo esc_attr( $type_bg );?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-404__content">

                    <?php if( ! empty( cs_get_option('error_title') ) ) { ?>
                        <h1 class="title"><?php echo esc_html( cs_get_option('error_title') ); ?></h1>
                    <?php } else { ?>
                        <h1 class="title"><?php esc_html_e('404 error','sanjose'); ?></h1>
                    <?php }

                    if( ! empty( cs_get_option('error_content') ) ) { ?>
                        <p><?php echo wp_kses_post( cs_get_option('error_content') ); ?></p>
                    <?php } else { ?>
                        <p><?php esc_html_e('Looks like page do not exist','sanjose'); ?></p>
                    <?php }	 ?>

                    <a class="button default" href="<?php echo esc_url( home_url( '/' ) );?>"><?php esc_html_e('Go Home', 'sanjose'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
