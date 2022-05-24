<?php
/**
 * Single Page
 *
 * @package sanjose
 * @since 1.0.0
 *
 */

get_header();

// Sidebar post
$sidebar     = sanjose_sidebar_position( 'post_sidebar' );
$sidebar     = ( isset( $sidebar ) ) ? $sidebar : 'right';
$blog_class  = ( isset( $sidebar ) && $sidebar === 'disable' ) ? 'col-md-12' : 'col-md-9';

// Information post
$meta_opt = get_post_meta( get_the_ID(), 'sanjose_post_options', true );

// Banner post
get_template_part( 'template-parts/content-single-banner');

?>

<?php while ( have_posts() ): the_post(); ?>
    <div class="container no-padd-md">
        <div class="row margin-sm-50t margin-sm-50b margin-lg-110t margin-lg-85b">

            <!-- Left sidebar -->
            <?php if ( is_active_sidebar('sidebar') && $sidebar == 'left' && class_exists('Sanjose_Plugins') ) : ?>
                <div class="col-md-3">
                    <aside class="sidebar blog-sidebar">
                        <?php dynamic_sidebar('sidebar'); ?>
                    </aside>
                </div>
            <?php endif; ?>

            <div class="post-detail <?php echo esc_attr( $blog_class ); ?>">

                <!-- Image post -->
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="wrapp-img background-wrapp">
	                    <?php the_post_thumbnail('full', array('class' => 'hidden-img')); ?>
                    </div>
                <?php endif;

                // info post
                if ( ! empty( $meta_opt['info_post'] ) ) : ?>
                    <h6 class="info-post"><?php echo esc_html( $meta_opt['info_post'] ); ?></h6>
                <?php endif;

                // Title post
                the_title('<h2 class="title-post">', '</h2>');
                ?>
	            <?php if ( ( comments_open() || get_comments_number()) && function_exists( 'cs_framework_init' )): ?>

                <ul class="entry-post">
                    <li><img src="<?php echo SANJOSE_URI; ?>/assets/images/comment-icon.png" alt=""> <?php echo esc_html( $post->comment_count ); ?></li>
                    <?php if (  function_exists( 'sanjose_count_post_likes' ) ) {
                        sanjose_count_post_likes();
                    } ?>
                </ul>
	            <?php endif; ?>
                <!-- Category, Tags -->

                <ul class="list-category">
                    <?php if ( has_category() ) :

                        if(!function_exists( 'cs_framework_init' ) ){ ?>
                            <li><?php esc_html_e('Categories: ', 'sanjose'); the_category(', '); ?></li>
                       <?php }else{ ?>
                            <li><?php the_category(', '); ?></li>
                        <?php } ?>
                    <?php endif;

                    if ( has_tag() ) : ?>
                        <li><?php the_tags('Tags: ',', ',''); ?></li>
                    <?php endif; ?>
                </ul>

                <!-- Post content -->
                <div class="entry">

                    <?php the_content(); ?>

                    <div class="entry-meta clearfix">
                        <span class="date">
                            <?php if ( cs_get_option('enable_human_diff') ) {
                                echo human_time_diff(
                                        get_the_time('U'),
                                        current_time('timestamp')
                                    ) . ' ' . esc_html__( 'ago', 'sanjose' );
                            } else {
                                the_time( get_option( 'date_format' ) );
                            } ?>
                        </span>

                        <?php if ( class_exists('Sanjose_Plugins') ) {
                            sanjose_share_links();
                        } ?>

                    </div>

                </div>

                <?php wp_link_pages( 'link_before=<span>&link_after=</span>&before=<div class="pagination posts-pag"> &after=</div>' );; ?>

                <!-- Post comments -->
                <?php if ( comments_open() || get_comments_number() ): ?>
                    <div class="post-comments">
                        <?php comments_template( '', true ); ?>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Right sidebar -->
            <?php if ( is_active_sidebar('sidebar') && $sidebar == 'right' && $sidebar != 'left' || ! class_exists('Sanjose_Plugins') ) : ?>

                <div class="col-md-3">
                    <aside class="sidebar blog-sidebar">
                        <?php dynamic_sidebar('sidebar'); ?>
                    </aside>
                </div>

            <?php endif; ?>

        </div>
    </div>

<?php endwhile; ?>

<?php get_footer(); ?>
