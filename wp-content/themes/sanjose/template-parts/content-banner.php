<?php
/**
 * The banner template file.
 *
 * @package sanjose
 * @since 1.0.0
 *
 */

// Banner blog
$banner_blog          = cs_get_option('banner_blog');
$banner_image         = cs_get_option('banner_image');
$banner_blog_subtitle = cs_get_option('banner_blog_subtitle');
$banner_blog_title    = cs_get_option('banner_blog_title');
$banner_link          = cs_get_option('banner_link');

if ( isset( $banner_blog ) && $banner_blog && ! empty( $banner_image ) ) : ?>
    <div class="banner-blog background-wrapp">

        <!-- Background image -->
        <img src="<?php echo esc_url( $banner_image ); ?>" class="hidden-img" alt=" " />

        <!-- Content banner -->
        <div class="banner-blog__content">

            <?php if ( ! empty( $banner_blog_subtitle ) ) : ?>
                <h6><?php echo esc_html( $banner_blog_subtitle ); ?></h6>
            <?php endif;

            if ( ! empty( $banner_blog_title ) ) : ?>
                <h2><?php echo wp_kses_post( $banner_blog_title ); ?></h2>
            <?php endif;

            if ( ! empty( $banner_link['banner_blog_link'] ) && ! empty( $banner_link['banner_blog_link_text'] ) ) : ?>
                <a href="<?php echo esc_html( $banner_link['banner_blog_link'] ); ?>" class="btn"><?php echo esc_html( $banner_link['banner_blog_link_text'] ); ?></a>
            <?php endif; ?>
        </div>

    </div>
<?php endif; ?>