<?php get_header();
$bg_images = cs_get_option('bg_images_search');
$background_color = cs_get_option('bg_color_search');
$bg_style= cs_get_option('bg_style_search');
$img_url = wp_get_attachment_image_src( $bg_images, 'full' )[0];
$background_image = "background-image: url( $img_url )";

$type_bg = (  $bg_style == 'color' ) ? "background-color: $background_color ;": $background_image;
?>

<div class="container-fluid">
    <div class="row">
        <section class="search-banner" style=" <?php echo esc_attr( $type_bg );?>;">
            <div class="content-banner">
                <p><?php printf( esc_html__( 'Search Results for: %s', 'sanjose' ), get_search_query() ); ?></p>
                <?php get_search_form(); ?>
            </div>
        </section>
    </div>
</div>

    <div class="container no-padd-md">
        <div class="row margin-md-50t margin-md-50b margin-lg-110t margin-lg-135b">
            <div class="col-md-12">
                <div class="row blog-list default">
                    <?php if ( have_posts() ) : ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <div <?php post_class( 'col-md-4' ); ?>>
                                <div class="post-item">

                                    <!-- Image post -->
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <div class="wrapp-img background-wrapp">
                                            <?php the_post_thumbnail('full', array('class'=>'hidden-img')); ?>
                                        </div>
                                    <?php endif;

                                    // Has post humbnail
                                    $has_post_thumbnail = ( ! has_post_thumbnail() ) ? 'no-thumbnail' : ''; ?>

                                    <div class="content-post <?php echo esc_attr( $has_post_thumbnail ); ?>">

                                        <!-- Title post -->
                                        <?php the_title('<h6><a href="' . get_the_permalink() . '">', '</a></h6>'); ?>

                                        <!-- Excerpt post -->
                                        <div class="post-excerpt"><p><?php the_excerpt(); ?></p></div>

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

                    else : ?>

                        <header class="latest-post no-result">
                            <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'sanjose'); ?></p>
                        </header>

                    <?php endif; ?>
                </div>
            </div>

            <?php // Pagination Search
            if ( class_exists( 'Sanjose_Plugins' ) ) {
                $args = array(
                    'prev_text'    => '',
                    'next_text'    => '',
                );
            } else {
                $args = array(
                    'prev_text'    => esc_html__('Prev post', 'sanjose'),
                    'next_text'    => esc_html__('Next post', 'sanjose'),
                );
            }
            ?>

            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="pagination">
                        <?php $paginate_links = paginate_links( $args );
                        echo wp_kses_post( $paginate_links ); ?>
                    </div>
                </div>
            </div>
    </div>
</div>

<?php get_footer();