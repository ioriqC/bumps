<?php
/**
 * Index Page
 *
 * @package sanjose
 * @since 1.0.0
 *
 */

get_header();

while ( have_posts() ):
	the_post();
	$content = get_the_content();

	if ( ! strpos( $content, 'vc_' ) ): ?>

        <div class="container no-padd-md">
            <div class="row margin-md-50t margin-md-50b margin-lg-110t margin-lg-85b">

                <div class="post-detail col-md-12">

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

                    if(function_exists( 'cs_framework_init' ) ){ ?>
                        <ul class="entry-post">
                            <li><img src="<?php echo SANJOSE_URI; ?>/assets/images/comment-icon.png" alt=" "> <?php echo esc_html( $post->comment_count ); ?></li>
		                    <?php if ( function_exists( 'sanjose_count_post_likes' ) ) {
			                    sanjose_count_post_likes();
		                    } ?>
                        </ul>
                    <?php } ?>

                    <!-- Category, Tags -->

                    <ul class="list-category">
                        <?php if ( has_category() ) : ?>
                            <li><?php the_category(','); ?></li>
                        <?php endif;

                        if ( has_tag() ) : ?>
                            <li><?php the_tags('Tags: ',', ',''); ?></li>
                        <?php endif; ?>
                    </ul>

                    <!-- Post content -->
                    <div class="entry">

                        <?php the_content(); ?>

                        <div class="entry-meta clearfix">
                            <?php  if(function_exists( 'cs_framework_init' ) ){ ?>
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
                            <?php }
                            if ( class_exists('Sanjose_Plugins') ) {
                            sanjose_share_links();
                        } ?>

                        </div>

                    </div>

                    <?php wp_link_pages(); ?>

                    <!-- Post comments -->
                    <?php if ( comments_open() || get_comments_number() ): ?>
                        <div class="post-comments">
                            <?php comments_template( '', true ); ?>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>

	<?php else: ?>

		<div class="container no-padd-md">
			<?php the_content(); ?>
		</div>

	<?php endif; ?>	

<?php endwhile; ?>

<?php get_footer(); ?>
