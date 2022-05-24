<?php
/*
 * Portfolio Shortcode
 * Version: 1.0.0
 */

vc_map( array(
    'name'            => __( 'Portfolio', 'js_composer' ),
    'base'            => 'sanjose_portfolio',
    'description'     => __( 'Portfolio list', 'js_composer' ),
    'params'          => array(
        array(
            'type'        => 'vc_efa_chosen',
            'heading'     => __( 'Custom Categories', 'js_composer' ),
            'param_name'  => 'categories',
            'placeholder' => 'Choose category (optional)',
            'value'       => function_exists ( 'sanjose_categories' ) ? sanjose_categories( 'portfolio', 'portfolio-category' ) : '',
            'std'         => '',
            'admin_label' => true,
            'description' => __( 'You can choose spesific categories for portfolio, default is all categories', 'js_composer' ),
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
                'Menu Order'    => 'menu_order',
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
            'type' 		  => 'dropdown',
            'heading' 	  => 'Style protfolio',
            'param_name'  => 'style_portfolio',
            'value' 	  => array(
                'Default'    => 'default',
                'Home'       => 'home'
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



        /* Filter settings */
        array(
            'type'        => 'dropdown',
            'heading'     => __( 'Filter', 'js_composer' ),
            'param_name'  => 'filter_style',
            'value'       => array(
                'Hidden'  	=> 'hidden',
                'Show'  	=> 'show'
            ),
            'group' 	  => 'Filter settings'
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => __( 'Align', 'js_composer' ),
            'param_name'  => 'filter_align',
            'value'       => array(
                'Center'  	=> 'center',
                'Left'  	=> 'left',
                'Right'  	=> 'right'
            ),
            'dependency'  => array( 'element' => 'filter_style', 'value' => 'show' ),
            'group' 	  => 'Filter settings'
        ),
    )
));




class WPBakeryShortCode_sanjose_portfolio extends WPBakeryShortCode{

    protected function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
            'categories' 			  => '',
            'style_portfolio' 	      => 'default',
            'orderby' 				  => 'ID',
            'order' 				  => 'ASC',
            'limit' 				  => '',
            'filter_style' 			  => 'hidden',
            'filter_align' 			  => 'center'
        ), $atts ) );


        /* FOR PORTFOLIO  FILTERS */
        $limit = ( ! empty( $limit ) && is_numeric( $limit ) ) ? $limit : 10;

        // add filter align
        $filter_styles = ' text-' . $filter_align;

        // get $categories
        if ( empty($categories) || $categories == 'all'){
            // get all category potfolio
            $categories = array();
            $terms = get_terms('portfolio-category', 'orderby=ID&hide_empty=0');
            foreach($terms as $term){
                $categories[] = $term->slug;
            }
        } else {
            $categories = explode( ',', $categories );
        }

        // params output
        $args = array(
            'posts_per_page' => $limit,
            'post_type'   	 => 'portfolio',
            'orderby'   	 => $orderby,
            'order'   		 => $order,
            'tax_query' 	 => array(
                array(
                    'taxonomy'  => 'portfolio-category',
                    'field'     => 'slug',
                    'terms'     => $categories
                )
            )
        );
        if ( empty( $style_home ) ) {
            $sizes_items = array('col-md-7 col-sm-7 col-xs-12 ', 'col-md-5 col-sm-5 col-xs-12 ', 'col-md-3 col-sm-3 col-xs-12 ', 'col-md-6 col-sm-6 col-xs-12 ', 'col-md-3 col-sm-3 col-xs-12 ', 'col-md-5 col-sm-5 col-xs-12 ', 'col-md-7 col-sm-7 col-xs-12');
        }else {
            $sizes_items = array( 'col-md-4 col-xs-12');
        }
        $counter = 0;
        $count = count( $sizes_items );

        // get portfolio posts
        $portfolio = new WP_Query( $args );

        if( $portfolio->have_posts() ) {
            // start output
            ob_start(); ?>

            <div class="izotope-container sanjose-portfolio">
                <?php if( $filter_style != 'hidden' ) { ?>
                    <div class="container">
                        <div class="row">
                            <!-- Filter portfolio -->
                            <div class="col-xs-12 wrap-tabs ">
                                <ul class="filters <?php echo esc_attr( $filter_styles ); ?>" id="filters">
                                    <li class="but activbut" data-filter="*"><?php echo esc_html__('All', 'sanjose' ); ?></li>
                                    <?php foreach ( $categories as $category_slug ) {
                                        $category = get_term_by('slug', $category_slug, 'portfolio-category'); ?>
                                        <?php
                                            if ( ! empty( $category->slug ) && ! empty( $category->name ) ) { ?>
                                                <li class="but" data-filter=".<?php echo esc_html( $category->slug ); ?>"><?php echo esc_html( $category->name ); ?></li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ( isset( $style_portfolio ) && $style_portfolio == 'default'){ ?>
                    <div class="portfolio-list row">

                        <?php while ( $portfolio->have_posts() ) : $portfolio->the_post();
                            setup_postdata( $portfolio );

                            $terms = get_the_terms( $portfolio->ID , 'portfolio-category' );
                            // add attribute item
                            $post_slug_category = array();
                            $post_item_attr = '';
                            foreach ($terms as $term) {
                                $post_slug_category[] = $term->name;
                                $post_item_attr .= $term->slug . ' ';
                            }

                            $counter = ( $counter >= $count ) ? 0 : $counter;
                            $item_class = $sizes_items[$counter];

                            ?>

                            <div class="item  <?php echo esc_attr( $item_class . ' '  . $post_item_attr ); ?>" data-src="<?php echo get_the_post_thumbnail_url(null, 'full');?>">

                                <div class="img-wrapp">
                                    <a class="hover-img" href="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $portfolio->ID ) );?>">
                                        <?php the_post_thumbnail('full', array('class'=>'hidden-img')); ?>
                                    </a>
                                    <div class="content-item">
                                        <div class="wrap-href">
                                            <span class="rotate"><a href="<?php the_permalink(); ?>"><i class="ion-link"></i></a></span>
                                            <span><i class="ion-android-search"></i></span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        <?php $counter++; endwhile; wp_reset_postdata(); ?>
                    </div>
                    <?php } else { ?>
                        <div class="container">
                            <div class="row portfolio-list prague_grid prague_count_col3 prague_gap_col15" data-columns="prague_count_col3" data-gap="prague_gap_col15">
                            <?php while ( $portfolio->have_posts() ) : $portfolio->the_post();
                                setup_postdata( $portfolio );

                                $terms = get_the_terms( $portfolio->ID , 'portfolio-category' );
                                // add attribute item
                                $post_slug_category = array();
                                $post_item_attr = '';
                                foreach ($terms as $term) {
                                    $post_slug_category[] = $term->name;
                                    $post_item_attr .= $term->slug . ' ';
                                }

                                $counter = ( $counter >= $count ) ? 0 : $counter;
                                $item_class = $sizes_items[$counter];
                                $meta_opt = get_post_meta( get_the_ID(), 'sanjose_post_options', true );
                                ?>
                                <div class="item <?php echo esc_attr( $post_item_attr ); ?> portfolio-item-wrapp">
                                    <div class="portfolio-item">
                                        <div class="project-grid-wrapper">
                                                <?php if ( ! empty( $meta_opt['page_url'] ) ): ?>
                                                     <a target="_blank" class="project-grid-item-img-link" href="<?php echo esc_attr( $meta_opt['page_url'] ); ?>">
                                                 <?php endif; ?>
                                                <div class="project-grid-item-img lg-medium">
                                                    <img src="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $portfolio->ID ), 'full' );?>">
                                                    <div class="project-grid-item-overlay"></div>
                                                </div>
                                            </a>
                                            <div class="project-grid-item-content">
                                                <h4 class="project-grid-item-title">
                                                    <?php if ( ! empty( $meta_opt['page_url'] ) ): ?>
                                                        <a target="_blank" href="<?php echo esc_attr( $meta_opt['page_url'] ); ?>"><?php the_title(); ?></a>
                                                    <?php endif; ?>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        <?php $counter++; endwhile; wp_reset_postdata(); ?>
                            </div>
                        </div>
                <?php }  ?>

            </div>

            <?php return ob_get_clean();
        }

    } // end function content

}
