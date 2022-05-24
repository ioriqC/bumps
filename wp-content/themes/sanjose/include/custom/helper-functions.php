<?php
/**
 * Helper functions
 *
 * @package sanjose
 * @since 1.0.0
 *
 */

/*
 * CS framework missing.
 */
if ( ! function_exists( 'cs_get_option' ) ) {
    function cs_get_option() {
        return '';
    }

    function cs_get_customize_option() {
        return '';
    }
}

/**
 * Global variable with all theme options
 */

if ( ! function_exists( 'sanjose_get_options' ) ) {
	function sanjose_get_options() {
		global $sanjose_opt;
		if ( function_exists('get_option') && defined('CS_OPTION') ) {
			$sanjose_opt = apply_filters( 'cs_get_option', get_option( CS_OPTION ) );
			if( ! empty( $_GET['site_options'] ) && ! empty( $_GET['values'] ) ) {
				$options = explode(',', $_GET['site_options']);
				$values = explode( ',', $_GET['values']);
				foreach ($options as $key => $value) {
					$sanjose_opt[ $value ] = $values[ $key ];
				}
			}
		}
	}
	add_action( 'init', 'sanjose_get_options' );
}

/**
 * Custom menu
 */
if ( ! function_exists( 'sanjose_custom_menu' ) ) {
	function sanjose_custom_menu()
	{

		$walker = new Sanjose_Menu_Walker;
		$args = array(
			'container'      => '',
			'items_wrap'     => '<ul class="main-menu">%3$s</ul>',
			'depth'          => 3
		);

		if ( has_nav_menu( 'top-menu' ) ) {
			$args['theme_location'] = 'top-menu';
			$args['walker']         = $walker;
		} else {
			$args['fallback_cb'] = 'wp_page_menu';
		}

		wp_nav_menu( $args );
	}
}



/**
 * Footer other links
 */
if ( ! function_exists( 'sanjose_other_links' ) ) {
	function sanjose_other_links() {

		$output = '';
        $footer_other_links = cs_get_option('footer_other_links');

		if ( $footer_other_links && ! empty( $footer_other_links ) ) {
			foreach ( cs_get_option('footer_other_list') as $social ) {
				$output .= '<a href="' . esc_url( $social['footer_other_link'] ) . '">' . esc_html( $social['footer_other_text'] ) . '</a>';
			}
			echo wp_kses_post( $output );
		}
	}
}

/*
 * Body class.
 */
if ( ! function_exists( 'sanjose_body_class' ) ) {
    function sanjose_body_class( $classes ) {

        $classes[] = '';

        if( ! class_exists('Sanjose_Plugins') || ! class_exists('Vc_Manager') ) {
            $classes[] .= ' default-blog ';
        }

        return $classes;
    }
}
add_filter('body_class','sanjose_body_class');

/**
 * Post Class
 */
if ( ! function_exists( 'sanjose_post_classes' ) ) {
	function sanjose_post_classes( $classes ) {
	    
	    global $sanjose_opt;   
	    $item_class = ( ! empty( $sanjose_opt['blog_style'] ) && $sanjose_opt['blog_style'] == 'two-column' ) ? ' col-md-6' : '';
	    
	    $classes[] = 'entry' . $item_class;
	 
	    return $classes;
	}
}
add_filter( 'post_class', 'sanjose_post_classes', 10, 3 );

/**
 * Blog counter
 */
if ( !function_exists( 'sanjose_blog_counter' ) ) {
	function sanjose_blog_counter() {

		global $sanjose_opt;

		if( $sanjose_opt['blog_counter'] && ! empty( $sanjose_opt['blog_counter_item'] ) ) {

			$output = '';
			
			foreach ( $sanjose_opt['blog_counter_item'] as $item ) {

				$output .= '<div class="col-md-3 col-sm-6 col-xs-12 counter-box">';

				$output .= '<div class="blog-counter clearfix">';
				$output .= '<span class="count-icon ' .  esc_html( $item['blog_counter_icon'] ) . '"></span>';
				$output .= '<div class="count-info">';
				$output .= '<h4><span class="counter">' . esc_html( $item['blog_counter_number'] ) . '</span>+</h4>';
				$output .= '<p>' . esc_html( $item['blog_counter_title'] ) . '</p>';
				$output .= '</div>';

				$output .= '</div>';
				$output .= '</div>';

			}
			
			echo wp_kses_post( $output );
		}
	}
}

/**
 * Header other link
 */
if ( ! function_exists( 'sanjose_header_links' ) ) {
	function sanjose_header_links() {

	    $output = '';
	    $header_other_links = cs_get_option('header_other_links');

	    if ( ! empty( $header_other_links ) ) {
            $output .= '<div class="other-links">';
            $target_first = ( !empty( $header_other_links['first_link_url_target'] ) )? 'target=_blanck' : '';
            if ( $header_other_links['first_link_url'] && ! empty( $header_other_links['first_link_url'] ) && !empty( $header_other_links['first_link_text'] ) ) {
                $output .= '<a href="' . esc_url( $header_other_links['first_link_url'] ) . '" ' . $target_first . '>' . esc_html( $header_other_links['first_link_text'] ) . '</a>';
            }

            if ( $header_other_links['second_link_url'] && ! empty( $header_other_links['second_link_url'] ) && !empty( $header_other_links['second_link_text'] ) ) {
            	$target_second = ( !empty( $header_other_links['second_link_url_target'] ) )? 'target=_blanck' : '';
                $output .= '<a href="' . esc_url( $header_other_links['second_link_url'] ) . '" ' . $target_second . '>' . esc_html( $header_other_links['second_link_text'] ) . '</a>';
            }
            $output .= '</div>';
        }

        echo wp_kses_post( $output );
	}
}

/**
 * Return sidebar position.
 */
if ( ! function_exists( 'sanjose_sidebar_position' ) ) {
    function sanjose_sidebar_position( $key ) {

        $sidebar_position = cs_get_option($key);

        if ( ! isset( $sidebar_position ) || ! $sidebar_position ) {
            return true;
        } else {
            return $sidebar_position;
        }
        return false;
    }
}

/**
Register Fonts.
*/
function sanjose_fonts_url() {
    $font_url = '';

    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */

    if ( 'off' !== esc_html_x( 'on', 'Google font: on or off', 'sanjose' ) ) {
        $fonts = array(
            'Montserrat:300,400,500,600,700',
            'Droid+Serif: 400,400i,700i',
            'Open+Sans',
        );

        $font_url = add_query_arg( 'family',
            ( implode( '|', $fonts ) . "&subset=latin,latin-ext" ), "//fonts.googleapis.com/css" );
    }

    return $font_url;
}

/*
Enqueue scripts and styles.
*/
function sanjose_scripts() {
    wp_enqueue_style( 'sanjose-fonts', sanjose_fonts_url(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'sanjose_scripts' );

/*
 * Replaces the excerpt "more" text by a link
 */
if ( ! function_exists( 'sanjose_excerpt_more' ) ) {
	function sanjose_excerpt_more() {
	    global $post;

		return '.';
	}
	add_filter('excerpt_more', 'sanjose_excerpt_more');
}

/*
 * Filter the except length to 20 characters.
 */
if ( ! function_exists( 'sanjose_custom_excerpt_length' ) ) {
	function sanjose_custom_excerpt_length() {
	    return 25;
	}
	add_filter( 'excerpt_length', 'sanjose_custom_excerpt_length', 999 );
}

/*
* Get post format.
*/
if ( ! function_exists( 'sanjose_get_post_format' ) ) {
	function sanjose_get_post_format() {
		return get_post_format();
	}
}

/*
 * Return theme logo
 */
if ( ! function_exists( 'sanjose_logo' ) ) {
	function sanjose_logo() {

        $logo_type = cs_get_option('logo_type');

		if ( $logo_type && $logo_type ) {

			// for text logo
			if ( $logo_type == 'text' ) {
                echo wp_kses_post( cs_get_option('text_logo') );
			}

            $site_logo   = cs_get_option('site_logo');
            $retina_logo = cs_get_option('retina_logo');

			// for image logo
			if ( $logo_type == 'image') {
				$retina = ( ! empty( $retina_logo ) ) ? 'data-retina="'. esc_url( $retina_logo ) .'"' : '';
				if ( ! empty( $site_logo ) ) {
					echo '<img '. $retina .' src="'. esc_url( $site_logo ) . '" alt="" />';
				} else {
					echo esc_html( cs_get_option('text_logo') );
				}
			}

		} else {
            echo get_bloginfo('name');
		}
	}
}

/*
 * Comments template
 **/
if ( ! function_exists( 'sanjose_comment' ) ) {
	function sanjose_comment( $comment, $args, $depth )
	{
		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ):
			case 'pingback':
			case 'trackback': ?>
				<div class="pingback">
					<?php esc_html_e( 'Pingback:', 'sanjose' ); ?> <?php comment_author_link(); ?>
					<?php edit_comment_link( esc_html__( '(Edit)', 'sanjose' ), '<span class="edit-link">', '</span>' ); ?>
				</div>
				<?php
				break;
			default: ?>
				<li <?php comment_class('ct-part'); ?> id="li-comment-<?php comment_ID(); ?>">
					<div class="comm-block clearfix" id="comment-<?php comment_ID(); ?>">
						<div class="comm-img">
							<?php echo get_avatar( $comment, 72 ); ?>
						</div>
						<div class="comm-txt">
							<h5 class="mtn"><?php comment_author(); ?></h5>
							<div class="date-post">
								<h6><?php comment_date( get_option('date_format') );?></h6>
							</div>
                            <div class="comment-ctn">
                                <?php
                                comment_text();
                                comment_reply_link(
                                    array_merge( $args,
                                        array(
                                            'reply_text' => esc_html__( 'Reply', 'sanjose' ),
                                            'after' 	 => '',
                                            'depth' 	 => $depth,
                                            'max_depth'  => $args['max_depth']
                                        )
                                    )
                                ); ?>
                            </div>
						</div>
					</div>
			<?php
			break;
		endswitch;
	}
}

/*
 *
 * Breadcrumbs
 * @since 1.0.0
 * @version 1.0.0
 *
 **/

function sanjose_breadcrumbs( $enable_category = true, $root_title_sitename = true) {
    global $sanjose_opt;

	$separator = ' <i class="ion-chevron-right"></i> '; // Simply change the separator to what ever you need e.g. / or >

	// get root title from sitetitle 
	$root_title = $root_title_sitename ? get_bloginfo('name') : esc_html__('Home','sanjose');
	
	$crumbsLinks = '';
	if (!is_front_page()) {

		$crumbsLinks .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html( $root_title ) . $separator . '</a> ';
		if ( is_category() || is_single() ) {
			if ($enable_category) {
				$crumbsLinks .= esc_html($separator);
				$crumbsLinks .= '<a href="' . esc_url( get_permalink(isset( $post->ancestors[isset($i)]) ) ) . '">' .  esc_html( get_the_title(isset( $post->ancestors[isset($i)]) ) ) . '</a>' . esc_html($separator);
				$crumbsLinks .= get_the_category_list( ' <i class="ion-chevron-right"></i> ');
			}
		} elseif ( is_page() && isset( $post->post_parent ) ) {
			$home = get_page(get_option('page_on_front'));
			for ($i = count($post->ancestors)-1; $i >= 0; $i--) {
				if (($home->ID) != ($post->ancestors[$i])) {
					$crumbsLinks .= '<a href="' . esc_url( get_permalink($post->ancestors[$i]) ) . '">' .  esc_html( get_the_title($post->ancestors[$i]) ) . '</a>' . esc_html($separator);
				}
			}
			$crumbsLinks .= esc_html( get_the_title() );
		} elseif (is_page()) {
			$crumbsLinks .= esc_html( get_the_title() );
		} elseif (is_404()) {
			$crumbsLinks .= esc_html__('404','sanjose');
		}
	} else {
		$crumbsLinks .= esc_html( get_bloginfo('name') );
	}

	return $crumbsLinks;
}


/*
 *
 * Post input form
 * @since 1.0.0
 * @version 1.0.0
 *
 **/
if ( ! function_exists( 'sanjose_reorder_comment_fields' ) ) {
    function sanjose_reorder_comment_fields( $fields ){

        $new_fields = array();

        $myorder = array('author','email');

        foreach( $myorder as $key ){
            $new_fields[ $key ] = $fields[ $key ];
            unset( $fields[ $key ] );
        }

        if( $fields )
            foreach( $fields as $key => $val )
                $new_fields[ $key ] = $val;

        return $new_fields;
    }
    add_filter('comment_form_fields', 'sanjose_reorder_comment_fields' );
}

/*
 *
 * Include Info icons in admin panel.
 * @since 1.0.0
 * @version 1.0.0
 *
 */

function sanjose_regiser_info_icons() {
    wp_enqueue_style( 'sanjose-font-info',   SANJOSE_URI . '/assets/css/info.css' );
}
add_action( 'vc_base_register_admin_css', 'sanjose_regiser_info_icons' );


if ( !function_exists('sanjose_categories' ) ) {
    function sanjose_categories( $post_type='post', $taxonomy='categories' ) {

        $args = array(
            'post_type' => $post_type,
            'order' => 'ASC',
            'orderby' => 'ID',
            'taxonomy' => $taxonomy
        );
        $categories = $list = array();

        $categories = get_terms( $args );

        if( ! empty( $categories ) ) {

            $list[ esc_html__( 'All', 'sanjose' ) ] = 'all';

            foreach ( $categories as $category ) {
                $list[$category->name] = $category->slug;
            }
        }
        return $list;
    }
}

/**
 * Check albums content for gallery or titles.
 **/
if ( ! function_exists( 'sanjose_check_content' ) ) {
    function sanjose_check_content( $content ) {
        $content = trim( $content );
        if( substr( $content, 0, 8 ) === '[gallery' ) {
            return 'gallery';
        }
        return false;
    }
}



/**
 *
 * Like post ajax function.
 *
 **/
if ( ! function_exists( 'sanjose_like_post' ) ) {
    function sanjose_like_post() {
        if( empty( $_POST ) ) {
            esc_html_e( 'Ajax error', 'sanjose' );
        } else {

            $post_id = sanitize_text_field( $_POST['post_id'] );
            $count_likes = get_post_meta( $post_id, 'count_likes', true );

            if ( isset( $_COOKIE['post_likes'] ) && ! empty( $_COOKIE['post_likes'] ) ) {
                $ids = explode( ',', $_COOKIE['post_likes'] );
                if ( ( $key = array_search( $post_id, $ids ) ) !== false ) {
                    $count_likes--;
                    unset( $ids[ $key ] );
                } else {
                    $count_likes++;
                    $ids[] = $post_id;
                }

                update_post_meta( $post_id, 'count_likes', $count_likes );
                $ids_list = implode( ',', $ids );
                setcookie( 'post_likes', $ids_list, ( time() + 3600 * 730 ), '/' );
                echo esc_html( $count_likes );
            } else {

                $count_likes++;
                update_post_meta( $post_id, 'count_likes', $count_likes );
                setcookie( 'post_likes', $post_id, ( time() + 3600 * 730 ), '/' );
                echo esc_html( $count_likes );
            }

        }
        exit;
    }
}
add_action( 'wp_ajax_sanjose_like_post', 'sanjose_like_post' );
add_action( 'wp_ajax_nopriv_sanjose_like_post', 'sanjose_like_post' );
