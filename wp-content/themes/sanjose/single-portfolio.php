<?php
/**
 * Single Portfolio
 *
 * @package sanjose
 * @since 1.0.0
 *
 */

get_header();

while ( have_posts() ): the_post();

$portfolio_desc = get_post_meta( get_the_ID(), 'sanjose_portfolio_options', true ); ?>
<div <?php post_class(); ?> >

    <?php
    /* Get page content */
    $page_content = get_the_content();
    /* Check if gallery on first position */
    $check_gallery = sanjose_check_content( $page_content );

    if( $check_gallery == 'gallery' ) {
        /* Remove gallery from first position */
        $split_content = explode( ']', $page_content );
        $page_content = str_replace( $split_content[0] . ']', '', $page_content );
    }

    $page_content = wpautop( $page_content );
    get_template_part( 'template-parts/content-single-banner');
    ?>
    <div class="container wrapper-portfolio">
    <div class="row">
        <!-- Content post -->
        <div class="col-md-6">

            <!-- Image albums post -->
            <?php if( get_post_gallery() ) { ?>
                <div class="slider-gallery">
                    <div class="lightgallery">
                        <a href="#">
                            <div class="gallery-slide-preview js-preview-gallery"></div>
                        </a>
                    </div>

                    <div class="swiper-container" data-autoplay="0" data-touch="1" data-mouse="0" data-speed="1000" data-slides-per-view="responsive" data-xs-slides="1" data-sm-slides="3" data-md-slides="3" data-lg-slides="4"  data-add-slides="4" data-loop="1" data-mode="horizontal">
                        <div class="swiper-wrapper">
                            <?php
                                // Gallery albums post
                                $gallery = get_post_gallery(get_the_ID(), false);
                                $ids = explode(',', $gallery['ids']);

                                foreach ( $ids as $item ) { ?>
                                    <div class="swiper-slide lightgallery">
                                        <a href="<?php echo wp_get_attachment_url( $item ); ?>">
                                            <div class="portfolio_bg-slide" style="background-image: url( <?php echo wp_get_attachment_url( $item ); ?> );"></div>
                                        </a>
                                    </div>
                                <?php } ?>
                        </div>
                        <div class="arrow slide-prev">
                            <span class="ion-chevron-right"></span>
                        </div>
                        <div class="arrow slide-next">
                            <span class="ion-chevron-left"></span>
                        </div>
                        <div class="pagination hide"></div>
                    </div>

                </div>
            <?php } else{
                the_post_thumbnail();
            } ?>

        </div>
        <div class="col-md-6">
            <div class="wrap-portfolio-content">
                <?php the_title('<h1 class="title-portfolio">','</h1>'); ?>
                <div class="projects-section">
                    <?php echo do_shortcode( $page_content ); ?>
                </div>


                <?php
                if ( ! empty( $portfolio_desc['sanjose_text'] ) ):
                    foreach ( $portfolio_desc['sanjose_text'] as $portfolio_item ) :?>
                        <div class="col-md-4">
                            <h2 class="portfolio-subtitle"><?php echo esc_html( $portfolio_item['title'] ); ?></h2>
                            <p class="portfolio-description"><?php echo esc_html( $portfolio_item['description'] ); ?></p>
                        </div>
                <?php endforeach;
                endif;?>
                <div class="col-lg-8 col-md-12">
                    <div class="links-section">
                        <?php
                        $next_post = get_next_post();
                        $prev_post = get_previous_post();
                        ?>

                        <?php if ( ! empty( $prev_post ) ):
                            $pag_prev = ( empty( $next_post ) ) ? 'no-next-post': '';
                            ?>
                            <div class="pag pag-prev <?php echo esc_attr( $pag_prev ); ?>">
                                <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="link prev-post"> <?php esc_html_e('PREV ENTRY ', 'sanjose'); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $next_post ) ):
                            $pag_next = ( empty ( $prev_post ) ) ? 'no-prev-post': ''; ?>
                            <div class="pag pag-next <?php echo esc_attr( $pag_next ); ?>">
                                <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="link next-post"><?php esc_html_e('NEXT ENTRY', 'sanjose'); ?> </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>