<?php
/**
 * The tag template file.
 *
 * @package sanjose
 * @since 1.0.0
 *
 */

// Sidebar blog
$sidebar         = sanjose_sidebar_position( 'blog_sidebar' );
$sidebar         = is_bool( $sidebar ) ? 'right' : $sidebar;
$sidebar_visible = ( $sidebar != 'disable' ) ? 'enable-sidebar' : '';

// Blog style
$blog_style = cs_get_option('blog_style');

// Column size
$column_size = ( isset( $blog_style ) && $blog_style == 'vertical' ) ? 'col-md-12' : 'col-sm-6 col-md-4';

$blog_class       = ( isset( $sidebar ) && $sidebar != 'disable' ) ? 'col-md-9 ' : 'col-md-12 ';
$blog_style_class = ( isset( $blog_style ) ) ? ' ' . $blog_style :  'default';
$count_post_likes   = get_post_meta( get_the_ID(), 'count_likes', true );

get_header();

// Banner blog
get_template_part( 'template-parts/content-banner');

?>

<!-- Content blog page -->
<div class="container no-padd-md">
    <div class="row margin-md-50t margin-md-50b margin-lg-110t margin-lg-135b">

        <!-- Left sidebar -->
        <?php if ( is_active_sidebar('sidebar') && $sidebar == 'left' ) : ?>
            <div class="col-md-3">
                <aside class="sidebar blog-sidebar">
                    <?php dynamic_sidebar('sidebar'); ?>
                </aside>
            </div>
        <?php endif; ?>

        <div class="<?php echo esc_attr( $blog_class ); ?>">
            <div class="row blog-list js-load-post <?php echo esc_attr( $blog_style_class . ' ' . $sidebar_visible ); ?>">
                <?php if ( have_posts() ) :

                    while ( have_posts() ): the_post(); ?>

                        <div <?php post_class( $column_size ); ?>>
                            <div class="post-item">
                                <!-- Image post -->
                                <?php
                                if ( class_exists( 'Sanjose_Plugins' ) ) { ?>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="wrapp-img background-wrapp ">
                                            <?php the_post_thumbnail('full', array('class' => 'hidden-img')); ?>
                                        </div>
                                    <?php endif;
                                } else {
                                    if (has_post_thumbnail()) : ?>
                                        <div class="wrapp-img">
                                            <?php the_post_thumbnail('full'); ?>
                                        </div>
                                    <?php endif;
                                }

                                // Has post humbnail
                                $has_post_thumbnail = ( ! has_post_thumbnail() ) ? 'no-thumbnail' : ''; ?>

                                <div class="content-post <?php echo esc_attr( $has_post_thumbnail ); ?>">

                                    <!-- Title post -->
                                    <?php the_title('<h6><a href="' . get_the_permalink() . '">', '</a></h6>'); ?>

                                    <!-- Excerpt post -->
                                    <div class="post-excerpt"><?php the_excerpt(); ?></div>

                                    <!-- Link post -->
                                    <a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read More', 'sanjose'); ?></a>

                                    <!-- Info post -->
                                    <div class="entry-meta">

                                        <ul>
                                            <li>
                                                <?php if ( cs_get_option('enable_human_diff') ) {
                                                    echo human_time_diff(
                                                            get_the_time('U'),
                                                            current_time('timestamp')
                                                        ) . ' ' . esc_html__( 'ago', 'sanjose' );
                                                } else {
                                                    the_time( get_option( 'date_format' ) );
                                                } ?>
                                            </li>
                                            <li>
                                                <?php if ( isset( $blog_style ) && $blog_style == 'vertical' ) :
                                                    echo get_avatar( $post->ID );
                                                    the_author();
                                                endif; ?>

                                                <?php esc_html_e('In','sanjose'); ?>
                                                <?php the_category(', '); ?>
                                            </li>
                                        </ul>

                                        <ul class="info-post">
                                            <li><img src="<?php echo SANJOSE_URI; ?>/assets/images/comment-icon.png" alt=""> <?php echo esc_html( $post->comment_count ); ?></li>
                                            <?php if (  function_exists( 'sanjose_count_post_likes' ) ) {
                                                sanjose_count_post_likes();
                                            } ?>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endwhile;

                else: ?>
                    <div id="sanjose-empty-result">
                        <p><?php esc_html_e('Sorry, no posts matched your criteria.', 'sanjose' ); ?></p>
                        <?php get_search_form( true ); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination blog -->
            <?php 
                $args = array(
                    'prev_text'    => '',
                    'next_text'    => '',
                );
                $paginate_links = paginate_links( $args );
            ?>

            <?php if( $paginate_links ) { ?>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="pagination">
                            <?php echo wp_kses_post( $paginate_links ); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Right sidebar -->
        <?php if ( is_active_sidebar('sidebar') && $sidebar == 'right' && $sidebar != 'left' ) : ?>

            <div class="col-md-3">
                <aside class="sidebar blog-sidebar">
                    <?php dynamic_sidebar('sidebar'); ?>
                </aside>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
