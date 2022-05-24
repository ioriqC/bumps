<?php
/*
 * Blog Shortcode
 * Author: Foxthemes
 * Author URI: http://foxthemes.com/
 * Version: 1.0.0
 */

vc_map(
    array(
        'name'            => __( 'Blog', 'js_composer' ),
        'base'            => 'sanjose_blog',
        'description'     => __( 'Posts list', 'js_composer' ),
        'params'          => array(
            array(
                'type' 		  => 'dropdown',
                'heading' 	  => 'Style items',
                'param_name'  => 'style_items',
                'value' 	  => array(
                    'Default'  => 'default',
                    'Modern'   => 'modern',
                    'Vertical' => 'vertical'
                )
            ),
            array(
                'type'        => 'vc_efa_chosen',
                'heading'     => __( 'Custom Categories', 'js_composer' ),
                'param_name'  => 'categories',
                'placeholder' => 'Choose category (optional)',
                'value'       => sanjose_param_values( 'categories' ),
                'std'         => '',
                'admin_label' => true,
                'description' => __( 'You can choose spesific categories for blog, default is all categories', 'js_composer' ),
            ),
            array(
                'type' 		  => 'dropdown',
                'heading' 	  => 'Order by',
                'param_name'  => 'orderby',
                'admin_label' => true,
                'value' 	  => array(
                    'ID' 		    => 'ID',
                    'Author' 	    => 'author',
                    'Post Title'    => 'title',
                    'Date' 		    => 'date',
                    'Last Modified' => 'modified',
                    'Random Order'  => 'rand',
                    'Menu Order'    => 'menu_order'
                )
            ),
            array(
                'type' 		  => 'dropdown',
                'heading' 	  => 'Order type',
                'param_name'  => 'order',
                'value' 	  => array(
                    'Ascending'  => 'ASC',
                    'Descending' => 'DESC'
                )
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __( 'Count items', 'js_composer' ),
                'param_name'  => 'limit',
                'value'       => '',
                'admin_label' => true,
                'description' => __( 'Default 10 items.', 'js_composer' )
            ),
            array(
                'type' 		  => 'dropdown',
                'heading' 	  => 'Pagination style',
                'param_name'  => 'pagination_style',
                'value' 	  => array(
                    'Default'   => 'default',
                    'Load More' => 'load_more',
                )
            ),
            array(
                'type' 		  => 'textfield',
                'heading' 	  => __( 'Extra class name', 'js_composer' ),
                'param_name'  => 'el_class',
                'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
                'value' 	  => ''
            ),
            array(
                'type' 		  => 'css_editor',
                'heading' 	  => __( 'CSS box', 'js_composer' ),
                'param_name'  => 'css',
                'group' 	  => __( 'Design options', 'js_composer' )
            )
        )
    )
);

class WPBakeryShortCode_sanjose_blog extends WPBakeryShortCode{

    protected function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
            'style_items'          => 'default',
            'categories'           => '',
            'orderby' 	           => 'ID',
            'order' 	           => 'ASC',
            'limit' 	           => '',
            'pagination_style' 	   => 'default',
            'el_class' 	           => '',
            'css' 		           => ''
        ), $atts ) );

        /* Custom styles */

        $class  	= ( ! empty( $el_class ) ) ? $el_class : '';
        $class 	   .= vc_shortcode_custom_css_class( $css, ' ' );

        /* FOR BLOG CONTENT */

        // get $categories
        if ( empty( $categories ) ){
            // get all category blog
            $categories = array();
            $terms = get_categories();
            foreach($terms as $term){
                $categories[] = $term->slug;
            }
        } else {
            $categories = explode( ',', $categories );
        }

        // Style items
        $style_items = ( isset( $style_items ) && $style_items == 'default' ) ? 'default' : $style_items;

        // Column size
        $column_size = ( isset( $style_items ) && $style_items == 'vertical' ) ? 'col-md-12' : 'col-sm-6 col-md-4';

        // Pagination style
        $pagination_style = ( isset( $pagination_style ) && $pagination_style == 'default' ) ? 'default' : 'load_more';

        // params output
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        $args = array(
            'posts_per_page' => $limit,
            'post_type'   	 => 'post',
            'orderby'   	 => $orderby,
            'order'   		 => $order,
            'paged'          => $paged,
            'tax_query' 	 => array(
                array(
                    'taxonomy'  => 'category',
                    'field'     => 'slug',
                    'terms'     => $categories
                )
            )
        );

        // get blog posts
        $posts = new WP_Query( $args );

        if( isset( $pagination_style ) && $pagination_style == 'load_more' ) {
            wp_localize_script(
                'sanjose-main',
                'load_more_post',
                array(
                    'ajaxurl'          => admin_url('admin-ajax.php'),
                    'startPage'        => 1,
                    'maxPage'          => $posts->max_num_pages,
                    'nextLink'         => next_posts( 0, false)
                )
            );
        }

        // start output
        ob_start(); ?>
        <div class="row blog-list js-load-post <?php echo esc_attr( $style_items . ' ' . $class ); ?>">
           

            <?php // Blog posts
            if ( $posts->have_posts() ) :

                while ( $posts->have_posts() ) : $posts->the_post();
                global $post; ?>

                    <div <?php post_class( $column_size ); ?>>
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

                                <?php if ( isset( $style_items ) && $style_items == 'modern' ) : ?>
                                    <ul class="modern-info">
                                        <li>
                                            <i class="fa fa-clock-o"></i>
                                            <?php the_time( get_option( 'date_format' ) ); ?>
                                        </li>

                                        <?php if ( has_category() ) : ?>
                                            <li>
                                                <?php the_category(', '); ?>
                                            </li>
                                        <?php endif; ?>

                                    </ul>
                                <?php endif; ?>

                                <!-- Title post -->
                                <?php if ( isset( $style_items ) && $style_items == 'modern' ) { ?>
                                    <h6><a href="<?php get_the_permalink(); ?>"><?php echo mb_strimwidth( get_the_title(), 0, 25, '' ); ?></a></h6>
                                <?php } else {
                                    the_title('<h6><a href="' . get_the_permalink() . '">', '</a></h6>');
                                } ?>

                                <!-- Excerpt post -->
                                <div class="post-excerpt"><?php the_excerpt(); ?></div>

                                <!-- Link post -->
                                <?php if ( isset( $style_items ) && $style_items != 'vertical' ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read More', 'sanjose'); ?></a>
                                <?php endif; ?>

                                <!-- Info post -->
                                <div class="entry-meta">

                                    <?php if ( isset( $style_items ) && $style_items == 'default' ) { ?>
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
                                                <?php if ( isset( $style_items ) && $style_items == 'vertical' ) :
                                                    echo get_avatar( get_the_ID() );
                                                    the_author();
                                                endif; ?>

                                                <?php esc_html_e('In','sanjose'); ?>
                                                <?php the_category(', '); ?>
                                            </li>
                                        </ul>
                                    <?php } elseif ( isset( $style_items ) && $style_items == 'vertical' ) {

                                        echo get_avatar( get_the_ID() ); ?>
                                        <ul>
                                            <li>
                                                <?php the_author(); ?>
                                            </li>
                                            <li>
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
                                                <i><?php esc_html_e('In','sanjose'); ?></i>
                                                <?php the_category(', '); ?>
                                            </li>
                                        </ul>
                                    <?php } ?>

                                    <?php if ( isset( $style_items ) && $style_items != 'vertical' ) : ?>
                                        <?php $count_post_likes   = get_post_meta( get_the_ID(), 'count_likes', true );
                                        $post_likes = ( isset( $count_post_likes) && $count_post_likes >= 1 )  ? $count_post_likes : 1 ;
                                        ?>
                                        <ul class="info-post">
                                            <li><img src="<?php echo SANJOSE_URI; ?>/assets/images/comment-icon.png" alt=""> <?php echo esc_html( $post->comment_count ); ?></li>
                                            <li><img src="<?php echo SANJOSE_URI; ?>/assets/images/heart-icon.png" alt=""><span class="count-likes"><?php  echo esc_html( $post_likes ); ?></span></li>
                                        </ul>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </div>

                    <?php endwhile; wp_reset_postdata();
            else: ?>
                <div id="sanjose-empty-result">
                    <p><?php esc_html_e('Sorry, no posts matched your criteria.', 'sanjose' ); ?></p>
                    <?php get_search_form( true ); ?>
                </div>
            <?php endif; ?>

        </div>

        <!-- Pagination blog -->
        <?php if ( isset( $pagination_style ) && $pagination_style == 'load_more' &&  $posts->max_num_pages > 1 ) { ?>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <span id="load-more" class="load-btn"><?php esc_html_e('Read All Stories','sanjose'); ?></span>
                </div>
            </div>
        <?php } else {
            $args = array(
                'total'     => $posts->max_num_pages,
                'prev_text'    => esc_html__('', 'sanjose'),
                'next_text'    => esc_html__('', 'sanjose'),
            ); ?>

            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="pagination">
                        <?php $paginate_links = paginate_links( $args ); ?>
                        <?php echo wp_kses_post( $paginate_links ); ?>
                    </div>
                </div>
            </div>

        <?php } ?>

        <?php return ob_get_clean();

    } // end function content


}
