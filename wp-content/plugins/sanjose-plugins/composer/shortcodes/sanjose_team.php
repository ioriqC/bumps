<?php
/*
 * Teams Shortcode
 * Author: FOXTHEMES
 * Author URI: http://foxthemes.com
 * Version: 1.0.0
 */
if (function_exists('vc_map')) {
    vc_map(
        array(
            'name'						=> esc_html__( 'Teams', 'js_composer' ),
            'base'						=> 'vc_Team',
            'content_element'			=> true,
            'show_settings_on_create'	=> true,
            'description'				=> esc_html__( '', 'js_composer'),
            'params'					=> array (
                array(
                    'type'        => 'textfield',
                    'heading'     => __( 'Total posts', 'js_composer' ),
                    'param_name'  => 'posts_per_page',
                    'description' => 'Only number'
                ),
                array (
                    'type' => 'textfield',
                    'heading' => 'Extra class name',
                    'param_name' => 'el_class',
                    'description' => 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.',
                    'value' => '',
                ),
                array (
                    'type' => 'css_editor',
                    'heading' => 'CSS box',
                    'param_name' => 'css',
                    'group' => 'Design options',
                ),
            )
            //end params
        )
    );
}
if (class_exists('WPBakeryShortCode')) {
    /* Frontend Output Shortcode */
    class WPBakeryShortCode_vc_Team extends WPBakeryShortCode {
        protected function content( $atts, $content = null ) {
            /* get all params */
            extract( shortcode_atts( array(
                'posts_per_page' => '',
                'el_class'	     => '',
                'css'	         => '',

            ), $atts ) );
            /* get param class */
            $wrap_class  = !empty( $el_class ) ? $el_class : '';
            /* get custum css as class*/
            $wrap_class .= vc_shortcode_custom_css_class( $css, ' ' );
            // start output


            ob_start();
            if (!empty($posts_per_page) && is_numeric($posts_per_page)) {
                $posts_per_page = (int)  $posts_per_page;
            }

            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

            $args = array(
                'posts_per_page'      => $posts_per_page,
                'post_type'      	  => 'team',
                'paged'      	      => $paged
            );
            $teams = new WP_Query( $args );

            wp_localize_script(
                'sanjose-main',
                'load_more_team',
                array(
                    'ajaxurl'          => admin_url('admin-ajax.php'),
                    'startPage'        => 1,
                    'maxPage'          => $teams->max_num_pages,
                    'nextLink'         => next_posts( 0, false)
                )
            ); ?>

            <div class="row sanjose-team-wrap  js-load-team <?php echo esc_attr( $wrap_class );?>">

                <?php while ( $teams->have_posts() ) {
                    $teams->the_post();
                    $team_position = get_post_meta( get_the_ID(), 'sanjose_team_options', true );?>
                    <div class="col-sm-4 col-md-4">
                        <div class="sanjose-team-item">
                            <div class="sanjose-team-img">
                                <?php  the_post_thumbnail('large', array( 'class' => 'hidden-img' ));?>
                            </div>
                            <div class="sanjose-team-info">
                                <?php the_title('<h3 class="sanjose-team-name">','</h3>'); ?>
                                <span class="sanjose-team-position"><?php echo esc_html( $team_position['position'] ); ?></span>
                            </div>
                        </div>
                    </div>
                <?php } wp_reset_postdata(); ?>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <span id="load-more" class="load-btn load-btn-team"><?php esc_html_e('MORE','sanjose'); ?></span>
                </div>
            </div>

            <?php return ob_get_clean();

        }
    }
}
