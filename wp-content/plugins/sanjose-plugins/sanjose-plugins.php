<?php
/*
Plugin Name: SanJose Plugins
Plugin URI: import.foxthemes.me/plugins/sanjose/sanjose-plugins.zip
Author: Foxthemes
Author URI: https://foxthemes.me
Version: 1.0.5
Description: Includes Portfolio Custom Post Types and Visual Composer Shortcodes
Text Domain: sanjose
*/

// add in constant name path
defined( 'EF_ROOT' )   or define( 'EF_ROOT',   dirname(__FILE__) );
defined( 'T_URI' )     or define( 'T_URI',     get_template_directory_uri() );
defined( 'T_PATH' )    or define( 'T_PATH',    get_template_directory() );
defined( 'T_IMG' )	   or define( 'T_IMG',	   T_URI . '/assets/images' );
defined( 'FUNC_PATH' ) or define( 'FUNC_PATH', T_PATH . '/include' );

// Custom widgets Integration
require_once EF_ROOT . '/widgets.php';
// Custom post type
require_once EF_ROOT . '/post-type.php';

// Importer demo data
require_once EF_ROOT . '/importer/index.php';

require dirname( __FILE__ ) .'/plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://import.foxthemes.me/wp-update/?action=get_metadata&slug=sanjose-plugins', //Metadata URL.
	__FILE__, //Full path to the main plugin file.
	'sanjose-plugins' //Plugin slug. Usually it's the same as the name of the directory.
);

if( ! class_exists( 'Sanjose_Plugins' ) ) {

	class Sanjose_Plugins {

		private $assets_js;

		public function __construct() { 
			$this->assets_js = plugins_url('/composer/js', __FILE__);

			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {

				require_once( WP_PLUGIN_DIR . '/js_composer/js_composer.php');

				add_action( 'admin_init', array($this, 'wpc_plugin_init') );
				add_action( 'wp', array($this, 'wpc_plugin_init') );
			}
		}

		//include custom map 
		public function wpc_plugin_init(){

			require_once( EF_ROOT .'/composer/init.php');

			foreach( glob( EF_ROOT . '/'. 'composer/shortcodes/sanjose_*.php' ) as $shortcode ) {
				require_once(EF_ROOT .'/'. 'composer/shortcodes/'. basename( $shortcode ) );
			}

			foreach( glob( EF_ROOT . '/'. 'composer/shortcodes/vc_*.php' ) as $shortcode ) {
				require_once(EF_ROOT .'/'. 'composer/shortcodes/'. basename( $shortcode ) );
			}
			
		}

	} // end of class

	// Framework for theme options.
	require_once( EF_ROOT .'/cs-framework/cs-framework.php');

	define( 'CS_ACTIVE_FRAMEWORK', true );
	define( 'CS_ACTIVE_METABOX',   true );
	define( 'CS_ACTIVE_TAXONOMY',  false );
	define( 'CS_ACTIVE_SHORTCODE', false );
	define( 'CS_ACTIVE_CUSTOMIZE', false );

	new Sanjose_Plugins;

} // end of class_exists


/**
 *
 * Get all Contact form 7 forms.
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'sanjose_get_cf7_forms' ) ) {
	function sanjose_get_cf7_forms() {
		$cf7_forms = array( '- Select form -' => 'none' );

		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
		}

		if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
			global $wpdb;

			$db_cf7froms = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'wpcf7_contact_form'");
			if( $db_cf7froms ) {
				foreach ( $db_cf7froms as $cform ) {
					$cf7_forms[$cform->post_title] = $cform->ID;
				}
			}
		}

		return $cf7_forms;
	}
}


if ( ! function_exists( 'sanjose_count_post_likes' ) ) {
    function sanjose_count_post_likes() {
        $count_post_likes   = get_post_meta( get_the_ID(), 'count_likes', true );
        $post_likes = ( isset( $count_post_likes) && $count_post_likes >= 1 )  ? $count_post_likes : 0 ;
        $output = '<li><img src="' . SANJOSE_URI . '/assets/images/heart-icon.png" alt=" ">' . $post_likes . '</li>';
        echo $output;
    }
}

/**
 *
 * Get categories functions. Return array lists
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'sanjose_param_values' ) ) {
	function sanjose_param_values( $post_type = 'terms', $query_args = array() ) {

		$list = array();

		//check type
		switch( $post_type ) {

			case 'posts': // get posts

				$posts = get_posts( $query_args );
				if ( ! empty( $posts ) ) {

					foreach ( $posts as $post ) {
						$list[ $post->post_title ] = $post->post_name;
					}

				} else {
					$list[ esc_html__( 'not found posts','wpc' ) ] = '';
				}

			break;

			case 'terms': // get terms

				$taxonomies = ! empty( $query_args['taxonomies'] ) ? $query_args['taxonomies'] : 'portfolio-category';

				$terms = get_terms( $taxonomies, $query_args );
				if ( ! empty( $terms ) ) {
					foreach ( $terms as $key => $term ) {
						$list[$term->name] = $term->slug;
					}
				} else {
					$list[ esc_html__( 'not found terms or terms empty', 'wpc' ) ] = '';
				}

			break;

			case 'categories': // get categories

				$categories = get_categories( $query_args );
				if ( ! empty( $categories ) ) {

					if(is_array($categories)){
						foreach ( $categories as $category ) {
							$list[$category->name] = $category->slug;
						}
					} else {
						$list[ esc_html__( 'categories not is array', 'wpc' ) ] = '';
					}

				} else {

					$list[ esc_html__( 'not found categories', 'wpc' ) ] = '';

				}

			break;

		}

		// return array
		return $list;
	}
}

/**
 *
 * Info icons array.
 * @since 1.0.0
 * @version 1.0.0
 *
 */

if ( ! function_exists( 'sanjose_info_icons' ) ) {
    function sanjose_info_icons() {
        return array(
            array('icon-info-1'  => 'icon-info-1'),
            array('icon-info-2'  => 'icon-info-2'),
            array('icon-info-3'  => 'icon-info-3'),
            array('icon-info-4'  => 'icon-info-4'),
            array('icon-info-5'  => 'icon-info-5'),
            array('icon-info-6'  => 'icon-info-6'),
            array('icon-info-7'  => 'icon-info-7'),
            array('icon-info-8'  => 'icon-info-8'),
            array('icon-info-9'  => 'icon-info-9'),
            array('icon-info-10' => 'icon-info-10'),
            array('icon-info-11' => 'icon-info-11'),
            array('icon-info-12' => 'icon-info-12'),
            array('icon-featured-technical-support' => 'icon-featured-technical-support'),
            array('icon-featured-velocity' => 'icon-featured-velocity'),
            array('icon-featured-medal'    => 'icon-featured-medal'),
            array('icon-featured-coding'   => 'icon-featured-coding'),
            array('icon-featured-bar-chart'=> 'icon-featured-bar-chart'),
        );
    }
}

/**
 * Share links.
 */

function sanjose_share_links() {

    $output = '';
    $output .= '<ul class="social-list">
        <li><button data-share="http://twitter.com/home?status=' . get_the_permalink() . '&amp;t=' . get_the_title() . '" class="twitter"><i class="fa fa-twitter"></i></button></li>
        <li><button data-share="http://www.facebook.com/sharer.php?u=' . get_the_permalink() . '&amp;t=' . get_the_title() . '" class="facebook"><i class="fa fa-facebook"></i></button></li>
        <li><button data-share="https://plus.google.com/share?url=' . get_the_permalink() . '&amp;t=' . get_the_title() . '" class="google"><i class="fa fa-google-plus"></i></button></li>
    </ul>';

    echo $output;
}


/**
 *
 * element values post, page, categories
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'sanjose_element_values' ) ) {
    function sanjose_element_values( $type = '', $query_args = array() ) {

        $options = array();

        switch ( $type ) {

            case 'pages':
            case 'page':
                $pages = get_pages( $query_args );

                if ( ! empty( $pages ) ) {
                    foreach ( $pages as $page ) {
                        $options[ $page->post_title ] = $page->ID;
                    }
                }
                break;

            case 'posts':
            case 'post':
                $posts = get_posts( $query_args );

                if ( ! empty( $posts ) ) {
                    foreach ( $posts as $post ) {
                        $options[ $post->post_title ] = $post->ID  /*lcfirst( $post->post_title )*/;
                    }
                }
                break;

            case 'tags':
            case 'tag':

                $tags = get_terms( $query_args['taxonomies'] );
                if ( ! empty( $tags ) ) {
                    foreach ( $tags as $tag ) {
                        $options[ $tag->name ] = $tag->term_id;
                    }
                }
                break;

            case 'terms': // get terms

                $taxonomies = ! empty( $query_args['taxonomies'] ) ? $query_args['taxonomies'] : 'team-category';
                $terms = get_terms( $taxonomies, $query_args );
                if ( ! empty( $terms ) ) {
                    foreach ( $terms as $key => $term ) {
                        $options[$term->name] = $term->slug;
                    }
                } else {
                    $options[ esc_html__( 'not found terms or terms empty', 'fcampaign' ) ] = '';
                }
                break;

            case 'categories':
            case 'category':

                $categories = get_categories( $query_args );

                if ( ! empty( $categories ) ) {

                    if ( is_array( $categories ) ) {
                        foreach ( $categories as $category ) {
                            $options[ $category->name ] = $category->term_id;
                        }
                    }

                }
                break;

            case 'custom':
            case 'callback':

                if ( is_callable( $query_args['function'] ) ) {
                    $options = call_user_func( $query_args['function'], $query_args['args'] );
                }

                break;

        }

        return $options;

    }
}


/**
 *
 * ION icons array.
 * @since 1.0.0
 * @version 1.0.0
 *
 */

if ( ! function_exists( 'sanjose_ion_icons' ) ) {
    function sanjose_ion_icons() {
        return array(
            array('ion-alert-circled'=>'ion-alert-circled'),
            array('ion-alert'=>'ion-alert'),
            array('ion-android-add-circle'=>'ion-android-add-circle'),
            array('ion-android-add'=>'ion-android-add'),
            array('ion-android-alarm-clock'=>'ion-android-alarm-clock'),
            array('ion-android-alert'=>'ion-android-alert'),
            array('ion-android-apps'=>'ion-android-apps'),
            array('ion-android-archive'=>'ion-android-archive'),
            array('ion-android-arrow-back'=>'ion-android-arrow-back'),
            array('ion-android-arrow-down'=>'ion-android-arrow-down'),
            array('ion-android-arrow-dropdown-circle'=>'ion-android-arrow-dropdown-circle'),
            array('ion-android-arrow-dropdown'=>'ion-android-arrow-dropdown'),
            array('ion-android-arrow-dropleft-circle'=>'ion-android-arrow-dropleft-circle'),
            array('ion-android-arrow-dropleft'=>'ion-android-arrow-dropleft'),
            array('ion-android-arrow-dropright-circle'=>'ion-android-arrow-dropright-circle'),
            array('ion-android-arrow-dropright'=>'ion-android-arrow-dropright'),
            array('ion-android-arrow-dropup-circle'=>'ion-android-arrow-dropup-circle'),
            array('ion-android-arrow-dropup'=>'ion-android-arrow-dropup'),
            array('ion-android-arrow-forward'=>'ion-android-arrow-forward'),
            array('ion-android-arrow-up'=>'ion-android-arrow-up'),
            array('ion-android-attach'=>'ion-android-attach'),
            array('ion-android-bar'=>'ion-android-bar'),
            array('ion-android-bicycle'=>'ion-android-bicycle'),
            array('ion-android-boat'=>'ion-android-boat'),
            array('ion-android-bookmark'=>'ion-android-bookmark'),
            array('ion-android-bulb'=>'ion-android-bulb'),
            array('ion-android-bus'=>'ion-android-bus'),
            array('ion-android-calendar'=>'ion-android-calendar'),
            array('ion-android-call'=>'ion-android-call'),
            array('ion-android-camera'=>'ion-android-camera'),
            array('ion-android-cancel'=>'ion-android-cancel'),
            array('ion-android-car'=>'ion-android-car'),
            array('ion-android-cart'=>'ion-android-cart'),
            array('ion-android-chat'=>'ion-android-chat'),
            array('ion-android-checkbox-blank'=>'ion-android-checkbox-blank'),
            array('ion-android-checkbox-outline-blank'=>'ion-android-checkbox-outline-blank'),
            array('ion-android-checkbox-outline'=>'ion-android-checkbox-outline'),
            array('ion-android-checkbox'=>'ion-android-checkbox'),
            array('ion-android-checkmark-circle'=>'ion-android-checkmark-circle'),
            array('ion-android-clipboard'=>'ion-android-clipboard'),
            array('ion-android-close'=>'ion-android-close'),
            array('ion-android-cloud-circle'=>'ion-android-cloud-circle'),
            array('ion-android-cloud-done'=>'ion-android-cloud-done'),
            array('ion-android-cloud-outline'=>'ion-android-cloud-outline'),
            array('ion-android-cloud'=>'ion-android-cloud'),
            array('ion-android-color-palette'=>'ion-android-color-palette'),
            array('ion-android-compass'=>'ion-android-compass'),
            array('ion-android-contact'=>'ion-android-contact'),
            array('ion-android-contacts'=>'ion-android-contacts'),
            array('ion-android-contract'=>'ion-android-contract'),
            array('ion-android-create'=>'ion-android-create'),
            array('ion-android-delete'=>'ion-android-delete'),
            array('ion-android-desktop'=>'ion-android-desktop'),
            array('ion-android-document'=>'ion-android-document'),
            array('ion-android-done-all'=>'ion-android-done-all'),
            array('ion-android-done'=>'ion-android-done'),
            array('ion-android-download'=>'ion-android-download'),
            array('ion-android-drafts'=>'ion-android-drafts'),
            array('ion-android-exit'=>'ion-android-exit'),
            array('ion-android-expand'=>'ion-android-expand'),
            array('ion-android-favorite-outline'=>'ion-android-favorite-outline'),
            array('ion-android-favorite'=>'ion-android-favorite'),
            array('ion-android-film'=>'ion-android-film'),
            array('ion-android-folder-open'=>'ion-android-folder-open'),
            array('ion-android-folder'=>'ion-android-folder'),
            array('ion-android-funnel'=>'ion-android-funnel'),
            array('ion-android-globe'=>'ion-android-globe'),
            array('ion-android-hand'=>'ion-android-hand'),
            array('ion-android-hangout'=>'ion-android-hangout'),
            array('ion-android-happy'=>'ion-android-happy'),
            array('ion-android-home'=>'ion-android-home'),
            array('ion-android-image'=>'ion-android-image'),
            array('ion-android-laptop'=>'ion-android-laptop'),
            array('ion-android-list'=>'ion-android-list'),
            array('ion-android-locate'=>'ion-android-locate'),
            array('ion-android-lock'=>'ion-android-lock'),
            array('ion-android-mail'=>'ion-android-mail'),
            array('ion-android-map'=>'ion-android-map'),
            array('ion-android-menu'=>'ion-android-menu'),
            array('ion-android-microphone-off'=>'ion-android-microphone-off'),
            array('ion-android-microphone'=>'ion-android-microphone'),
            array('ion-android-more-horizontal'=>'ion-android-more-horizontal'),
            array('ion-android-more-vertical'=>'ion-android-more-vertical'),
            array('ion-android-navigate'=>'ion-android-navigate'),
            array('ion-android-notifications-none'=>'ion-android-notifications-none'),
            array('ion-android-notifications-off'=>'ion-android-notifications-off'),
            array('ion-android-notifications'=>'ion-android-notifications'),
            array('ion-android-open'=>'ion-android-open'),
            array('ion-android-options'=>'ion-android-options'),
            array('ion-android-people'=>'ion-android-people'),
            array('ion-android-person-add'=>'ion-android-person-add'),
            array('ion-android-person'=>'ion-android-person'),
            array('ion-android-phone-landscape'=>'ion-android-phone-landscape'),
            array('ion-android-phone-portrait'=>'ion-android-phone-portrait'),
            array('ion-android-pin'=>'ion-android-pin'),
            array('ion-android-plane'=>'ion-android-plane'),
            array('ion-android-playstore'=>'ion-android-playstore'),
            array('ion-android-print'=>'ion-android-print'),
            array('ion-android-radio-button-off'=>'ion-android-radio-button-off'),
            array('ion-android-radio-button-on'=>'ion-android-radio-button-on'),
            array('ion-android-refresh'=>'ion-android-refresh'),
            array('ion-android-remove-circle'=>'ion-android-remove-circle'),
            array('ion-android-remove'=>'ion-android-remove'),
            array('ion-android-restaurant'=>'ion-android-restaurant'),
            array('ion-android-sad'=>'ion-android-sad'),
            array('ion-android-search'=>'ion-android-search'),
            array('ion-android-send'=>'ion-android-send'),
            array('ion-android-settings'=>'ion-android-settings'),
            array('ion-android-share-alt'=>'ion-android-share-alt'),
            array('ion-android-share'=>'ion-android-share'),
            array('ion-android-star-half'=>'ion-android-star-half'),
            array('ion-android-star-outline'=>'ion-android-star-outline'),
            array('ion-android-star'=>'ion-android-star'),
            array('ion-android-stopwatch'=>'ion-android-stopwatch'),
            array('ion-android-subway'=>'ion-android-subway'),
            array('ion-android-sunny'=>'ion-android-sunny'),
            array('ion-android-sync'=>'ion-android-sync'),
            array('ion-android-textsms'=>'ion-android-textsms'),
            array('ion-android-time'=>'ion-android-time'),
            array('ion-android-train'=>'ion-android-train'),
            array('ion-android-unlock'=>'ion-android-unlock'),
            array('ion-android-upload'=>'ion-android-upload'),
            array('ion-android-volume-down'=>'ion-android-volume-down'),
            array('ion-android-volume-mute'=>'ion-android-volume-mute'),
            array('ion-android-volume-off'=>'ion-android-volume-off'),
            array('ion-android-volume-up'=>'ion-android-volume-up'),
            array('ion-android-walk'=>'ion-android-walk'),
            array('ion-android-warning'=>'ion-android-warning'),
            array('ion-android-watch'=>'ion-android-watch'),
            array('ion-android-wifi'=>'ion-android-wifi'),
            array('ion-aperture'=>'ion-aperture'),
            array('ion-archive'=>'ion-archive'),
            array('ion-arrow-down-a'=>'ion-arrow-down-a'),
            array('ion-arrow-down-b'=>'ion-arrow-down-b'),
            array('ion-arrow-down-c'=>'ion-arrow-down-c'),
            array('ion-arrow-expand'=>'ion-arrow-expand'),
            array('ion-arrow-graph-down-left'=>'ion-arrow-graph-down-left'),
            array('ion-arrow-graph-down-right'=>'ion-arrow-graph-down-right'),
            array('ion-arrow-graph-up-left'=>'ion-arrow-graph-up-left'),
            array('ion-arrow-graph-up-right'=>'ion-arrow-graph-up-right'),
            array('ion-arrow-left-a'=>'ion-arrow-left-a'),
            array('ion-arrow-left-b'=>'ion-arrow-left-b'),
            array('ion-arrow-left-c'=>'ion-arrow-left-c'),
            array('ion-arrow-move'=>'ion-arrow-move'),
            array('ion-arrow-resize'=>'ion-arrow-resize'),
            array('ion-arrow-return-left'=>'ion-arrow-return-left'),
            array('ion-arrow-return-right'=>'ion-arrow-return-right'),
            array('ion-arrow-right-a'=>'ion-arrow-right-a'),
            array('ion-arrow-right-b'=>'ion-arrow-right-b'),
            array('ion-arrow-right-c'=>'ion-arrow-right-c'),
            array('ion-arrow-shrink'=>'ion-arrow-shrink'),
            array('ion-arrow-swap'=>'ion-arrow-swap'),
            array('ion-arrow-up-a'=>'ion-arrow-up-a'),
            array('ion-arrow-up-b'=>'ion-arrow-up-b'),
            array('ion-arrow-up-c'=>'ion-arrow-up-c'),
            array('ion-asterisk'=>'ion-asterisk'),
            array('ion-at'=>'ion-at'),
            array('ion-backspace-outline'=>'ion-backspace-outline'),
            array('ion-backspace'=>'ion-backspace'),
            array('ion-bag'=>'ion-bag'),
            array('ion-battery-charging'=>'ion-battery-charging'),
            array('ion-battery-empty'=>'ion-battery-empty'),
            array('ion-battery-full'=>'ion-battery-full'),
            array('ion-battery-half'=>'ion-battery-half'),
            array('ion-battery-low'=>'ion-battery-low'),
            array('ion-beaker'=>'ion-beaker'),
            array('ion-beer'=>'ion-beer'),
            array('ion-bluetooth'=>'ion-bluetooth'),
            array('ion-bonfire'=>'ion-bonfire'),
            array('ion-bookmark'=>'ion-bookmark'),
            array('ion-bowtie'=>'ion-bowtie'),
            array('ion-briefcase'=>'ion-briefcase'),
            array('ion-bug'=>'ion-bug'),
            array('ion-calculator'=>'ion-calculator'),
            array('ion-calendar'=>'ion-calendar'),
            array('ion-camera'=>'ion-camera'),
            array('ion-card'=>'ion-card'),
            array('ion-cash'=>'ion-cash'),
            array('ion-chatbox-working'=>'ion-chatbox-working'),
            array('ion-chatbox'=>'ion-chatbox'),
            array('ion-chatboxes'=>'ion-chatboxes'),
            array('ion-chatbubble-working'=>'ion-chatbubble-working'),
            array('ion-chatbubble'=>'ion-chatbubble'),
            array('ion-chatbubbles'=>'ion-chatbubbles'),
            array('ion-checkmark-circled'=>'ion-checkmark-circled'),
            array('ion-checkmark-round'=>'ion-checkmark-round'),
            array('ion-checkmark'=>'ion-checkmark'),
            array('ion-chevron-down'=>'ion-chevron-down'),
            array('ion-chevron-left'=>'ion-chevron-left'),
            array('ion-chevron-right'=>'ion-chevron-right'),
            array('ion-chevron-up'=>'ion-chevron-up'),
            array('ion-clipboard'=>'ion-clipboard'),
            array('ion-clock'=>'ion-clock'),
            array('ion-close-circled'=>'ion-close-circled'),
            array('ion-close-round'=>'ion-close-round'),
            array('ion-close'=>'ion-close'),
            array('ion-closed-captioning'=>'ion-closed-captioning'),
            array('ion-cloud'=>'ion-cloud'),
            array('ion-code-download'=>'ion-code-download'),
            array('ion-code-working'=>'ion-code-working'),
            array('ion-code'=>'ion-code'),
            array('ion-coffee'=>'ion-coffee'),
            array('ion-compass'=>'ion-compass'),
            array('ion-compose'=>'ion-compose'),
            array('ion-connection-bars'=>'ion-connection-bars'),
            array('ion-contrast'=>'ion-contrast'),
            array('ion-crop'=>'ion-crop'),
            array('ion-cube'=>'ion-cube'),
            array('ion-disc'=>'ion-disc'),
            array('ion-document-text'=>'ion-document-text'),
            array('ion-document'=>'ion-document'),
            array('ion-drag'=>'ion-drag'),
            array('ion-earth'=>'ion-earth'),
            array('ion-easel'=>'ion-easel'),
            array('ion-edit'=>'ion-edit'),
            array('ion-egg'=>'ion-egg'),
            array('ion-eject'=>'ion-eject'),
            array('ion-email-unread'=>'ion-email-unread'),
            array('ion-email'=>'ion-email'),
            array('ion-erlenmeyer-flask-bubbles'=>'ion-erlenmeyer-flask-bubbles'),
            array('ion-erlenmeyer-flask'=>'ion-erlenmeyer-flask'),
            array('ion-eye-disabled'=>'ion-eye-disabled'),
            array('ion-eye'=>'ion-eye'),
            array('ion-female'=>'ion-female'),
            array('ion-filing'=>'ion-filing'),
            array('ion-film-marker'=>'ion-film-marker'),
            array('ion-fireball'=>'ion-fireball'),
            array('ion-flag'=>'ion-flag'),
            array('ion-flame'=>'ion-flame'),
            array('ion-flash-off'=>'ion-flash-off'),
            array('ion-flash'=>'ion-flash'),
            array('ion-folder'=>'ion-folder'),
            array('ion-fork-repo'=>'ion-fork-repo'),
            array('ion-fork'=>'ion-fork'),
            array('ion-forward'=>'ion-forward'),
            array('ion-funnel'=>'ion-funnel'),
            array('ion-gear-a'=>'ion-gear-a'),
            array('ion-gear-b'=>'ion-gear-b'),
            array('ion-grid'=>'ion-grid'),
            array('ion-hammer'=>'ion-hammer'),
            array('ion-happy-outline'=>'ion-happy-outline'),
            array('ion-happy'=>'ion-happy'),
            array('ion-headphone'=>'ion-headphone'),
            array('ion-heart-broken'=>'ion-heart-broken'),
            array('ion-heart'=>'ion-heart'),
            array('ion-help-buoy'=>'ion-help-buoy'),
            array('ion-help-circled'=>'ion-help-circled'),
            array('ion-help'=>'ion-help'),
            array('ion-home'=>'ion-home'),
            array('ion-icecream'=>'ion-icecream'),
            array('ion-image'=>'ion-image'),
            array('ion-images'=>'ion-images'),
            array('ion-information-circled'=>'ion-information-circled'),
            array('ion-information'=>'ion-information'),
            array('ion-ionic'=>'ion-ionic'),
            array('ion-ios-alarm-outline'=>'ion-ios-alarm-outline'),
            array('ion-ios-alarm'=>'ion-ios-alarm'),
            array('ion-ios-albums-outline'=>'ion-ios-albums-outline'),
            array('ion-ios-albums'=>'ion-ios-albums'),
            array('ion-ios-americanfootball-outline'=>'ion-ios-americanfootball-outline'),
            array('ion-ios-americanfootball'=>'ion-ios-americanfootball'),
            array('ion-ios-analytics-outline'=>'ion-ios-analytics-outline'),
            array('ion-ios-analytics'=>'ion-ios-analytics'),
            array('ion-ios-arrow-back'=>'ion-ios-arrow-back'),
            array('ion-ios-arrow-down'=>'ion-ios-arrow-down'),
            array('ion-ios-arrow-forward'=>'ion-ios-arrow-forward'),
            array('ion-ios-arrow-left'=>'ion-ios-arrow-left'),
            array('ion-ios-arrow-right'=>'ion-ios-arrow-right'),
            array('ion-ios-arrow-thin-down'=>'ion-ios-arrow-thin-down'),
            array('ion-ios-arrow-thin-left'=>'ion-ios-arrow-thin-left'),
            array('ion-ios-arrow-thin-right'=>'ion-ios-arrow-thin-right'),
            array('ion-ios-arrow-thin-up'=>'ion-ios-arrow-thin-up'),
            array('ion-ios-arrow-up'=>'ion-ios-arrow-up'),
            array('ion-ios-at-outline'=>'ion-ios-at-outline'),
            array('ion-ios-at'=>'ion-ios-at'),
            array('ion-ios-barcode-outline'=>'ion-ios-barcode-outline'),
            array('ion-ios-barcode'=>'ion-ios-barcode'),
            array('ion-ios-baseball-outline'=>'ion-ios-baseball-outline'),
            array('ion-ios-baseball'=>'ion-ios-baseball'),
            array('ion-ios-basketball-outline'=>'ion-ios-basketball-outline'),
            array('ion-ios-basketball'=>'ion-ios-basketball'),
            array('ion-ios-bell-outline'=>'ion-ios-bell-outline'),
            array('ion-ios-bell'=>'ion-ios-bell'),
            array('ion-ios-body-outline'=>'ion-ios-body-outline'),
            array('ion-ios-body'=>'ion-ios-body'),
            array('ion-ios-bolt-outline'=>'ion-ios-bolt-outline'),
            array('ion-ios-bolt'=>'ion-ios-bolt'),
            array('ion-ios-book-outline'=>'ion-ios-book-outline'),
            array('ion-ios-book'=>'ion-ios-book'),
            array('ion-ios-bookmarks-outline'=>'ion-ios-bookmarks-outline'),
            array('ion-ios-bookmarks'=>'ion-ios-bookmarks'),
            array('ion-ios-box-outline'=>'ion-ios-box-outline'),
            array('ion-ios-box'=>'ion-ios-box'),
            array('ion-ios-briefcase-outline'=>'ion-ios-briefcase-outline'),
            array('ion-ios-briefcase'=>'ion-ios-briefcase'),
            array('ion-ios-browsers-outline'=>'ion-ios-browsers-outline'),
            array('ion-ios-browsers'=>'ion-ios-browsers'),
            array('ion-ios-calculator-outline'=>'ion-ios-calculator-outline'),
            array('ion-ios-calculator'=>'ion-ios-calculator'),
            array('ion-ios-calendar-outline'=>'ion-ios-calendar-outline'),
            array('ion-ios-calendar'=>'ion-ios-calendar'),
            array('ion-ios-camera-outline'=>'ion-ios-camera-outline'),
            array('ion-ios-camera'=>'ion-ios-camera'),
            array('ion-ios-cart-outline'=>'ion-ios-cart-outline'),
            array('ion-ios-cart'=>'ion-ios-cart'),
            array('ion-ios-chatboxes-outline'=>'ion-ios-chatboxes-outline'),
            array('ion-ios-chatboxes'=>'ion-ios-chatboxes'),
            array('ion-ios-chatbubble-outline'=>'ion-ios-chatbubble-outline'),
            array('ion-ios-chatbubble'=>'ion-ios-chatbubble'),
            array('ion-ios-checkmark-empty'=>'ion-ios-checkmark-empty'),
            array('ion-ios-checkmark-outline'=>'ion-ios-checkmark-outline'),
            array('ion-ios-checkmark'=>'ion-ios-checkmark'),
            array('ion-ios-circle-filled'=>'ion-ios-circle-filled'),
            array('ion-ios-circle-outline'=>'ion-ios-circle-outline'),
            array('ion-ios-clock-outline'=>'ion-ios-clock-outline'),
            array('ion-ios-clock'=>'ion-ios-clock'),
            array('ion-ios-close-empty'=>'ion-ios-close-empty'),
            array('ion-ios-close-outline'=>'ion-ios-close-outline'),
            array('ion-ios-close'=>'ion-ios-close'),
            array('ion-ios-cloud-download-outline'=>'ion-ios-cloud-download-outline'),
            array('ion-ios-cloud-download'=>'ion-ios-cloud-download'),
            array('ion-ios-cloud-outline'=>'ion-ios-cloud-outline'),
            array('ion-ios-cloud-upload-outline'=>'ion-ios-cloud-upload-outline'),
            array('ion-ios-cloud-upload'=>'ion-ios-cloud-upload'),
            array('ion-ios-cloud'=>'ion-ios-cloud'),
            array('ion-ios-cloudy-night-outline'=>'ion-ios-cloudy-night-outline'),
            array('ion-ios-cloudy-night'=>'ion-ios-cloudy-night'),
            array('ion-ios-cloudy-outline'=>'ion-ios-cloudy-outline'),
            array('ion-ios-cloudy'=>'ion-ios-cloudy'),
            array('ion-ios-cog-outline'=>'ion-ios-cog-outline'),
            array('ion-ios-cog'=>'ion-ios-cog'),
            array('ion-ios-color-filter-outline'=>'ion-ios-color-filter-outline'),
            array('ion-ios-color-filter'=>'ion-ios-color-filter'),
            array('ion-ios-color-wand-outline'=>'ion-ios-color-wand-outline'),
            array('ion-ios-color-wand'=>'ion-ios-color-wand'),
            array('ion-ios-compose-outline'=>'ion-ios-compose-outline'),
            array('ion-ios-compose'=>'ion-ios-compose'),
            array('ion-ios-contact-outline'=>'ion-ios-contact-outline'),
            array('ion-ios-contact'=>'ion-ios-contact'),
            array('ion-ios-copy-outline'=>'ion-ios-copy-outline'),
            array('ion-ios-copy'=>'ion-ios-copy'),
            array('ion-ios-crop-strong'=>'ion-ios-crop-strong'),
            array('ion-ios-crop'=>'ion-ios-crop'),
            array('ion-ios-download-outline'=>'ion-ios-download-outline'),
            array('ion-ios-download'=>'ion-ios-download'),
            array('ion-ios-drag'=>'ion-ios-drag'),
            array('ion-ios-email-outline'=>'ion-ios-email-outline'),
            array('ion-ios-email'=>'ion-ios-email'),
            array('ion-ios-eye-outline'=>'ion-ios-eye-outline'),
            array('ion-ios-eye'=>'ion-ios-eye'),
            array('ion-ios-fastforward-outline'=>'ion-ios-fastforward-outline'),
            array('ion-ios-fastforward'=>'ion-ios-fastforward'),
            array('ion-ios-filing-outline'=>'ion-ios-filing-outline'),
            array('ion-ios-filing'=>'ion-ios-filing'),
            array('ion-ios-film-outline'=>'ion-ios-film-outline'),
            array('ion-ios-film'=>'ion-ios-film'),
            array('ion-ios-flag-outline'=>'ion-ios-flag-outline'),
            array('ion-ios-flag'=>'ion-ios-flag'),
            array('ion-ios-flame-outline'=>'ion-ios-flame-outline'),
            array('ion-ios-flame'=>'ion-ios-flame'),
            array('ion-ios-flask-outline'=>'ion-ios-flask-outline'),
            array('ion-ios-flask'=>'ion-ios-flask'),
            array('ion-ios-flower-outline'=>'ion-ios-flower-outline'),
            array('ion-ios-flower'=>'ion-ios-flower'),
            array('ion-ios-folder-outline'=>'ion-ios-folder-outline'),
            array('ion-ios-folder'=>'ion-ios-folder'),
            array('ion-ios-football-outline'=>'ion-ios-football-outline'),
            array('ion-ios-football'=>'ion-ios-football'),
            array('ion-ios-game-controller-a-outline'=>'ion-ios-game-controller-a-outline'),
            array('ion-ios-game-controller-a'=>'ion-ios-game-controller-a'),
            array('ion-ios-game-controller-b-outline'=>'ion-ios-game-controller-b-outline'),
            array('ion-ios-game-controller-b'=>'ion-ios-game-controller-b'),
            array('ion-ios-gear-outline'=>'ion-ios-gear-outline'),
            array('ion-ios-gear'=>'ion-ios-gear'),
            array('ion-ios-glasses-outline'=>'ion-ios-glasses-outline'),
            array('ion-ios-glasses'=>'ion-ios-glasses'),
            array('ion-ios-grid-view-outline'=>'ion-ios-grid-view-outline'),
            array('ion-ios-grid-view'=>'ion-ios-grid-view'),
            array('ion-ios-heart-outline'=>'ion-ios-heart-outline'),
            array('ion-ios-heart'=>'ion-ios-heart'),
            array('ion-ios-help-empty'=>'ion-ios-help-empty'),
            array('ion-ios-help-outline'=>'ion-ios-help-outline'),
            array('ion-ios-help'=>'ion-ios-help'),
            array('ion-ios-home-outline'=>'ion-ios-home-outline'),
            array('ion-ios-home'=>'ion-ios-home'),
            array('ion-ios-infinite-outline'=>'ion-ios-infinite-outline'),
            array('ion-ios-infinite'=>'ion-ios-infinite'),
            array('ion-ios-information-empty'=>'ion-ios-information-empty'),
            array('ion-ios-information-outline'=>'ion-ios-information-outline'),
            array('ion-ios-information'=>'ion-ios-information'),
            array('ion-ios-ionic-outline'=>'ion-ios-ionic-outline'),
            array('ion-ios-keypad-outline'=>'ion-ios-keypad-outline'),
            array('ion-ios-keypad'=>'ion-ios-keypad'),
            array('ion-ios-lightbulb-outline'=>'ion-ios-lightbulb-outline'),
            array('ion-ios-lightbulb'=>'ion-ios-lightbulb'),
            array('ion-ios-list-outline'=>'ion-ios-list-outline'),
            array('ion-ios-list'=>'ion-ios-list'),
            array('ion-ios-location-outline'=>'ion-ios-location-outline'),
            array('ion-ios-location'=>'ion-ios-location'),
            array('ion-ios-locked-outline'=>'ion-ios-locked-outline'),
            array('ion-ios-locked'=>'ion-ios-locked'),
            array('ion-ios-loop-strong'=>'ion-ios-loop-strong'),
            array('ion-ios-loop'=>'ion-ios-loop'),
            array('ion-ios-medical-outline'=>'ion-ios-medical-outline'),
            array('ion-ios-medical'=>'ion-ios-medical'),
            array('ion-ios-medkit-outline'=>'ion-ios-medkit-outline'),
            array('ion-ios-medkit'=>'ion-ios-medkit'),
            array('ion-ios-mic-off'=>'ion-ios-mic-off'),
            array('ion-ios-mic-outline'=>'ion-ios-mic-outline'),
            array('ion-ios-mic'=>'ion-ios-mic'),
            array('ion-ios-minus-empty'=>'ion-ios-minus-empty'),
            array('ion-ios-minus-outline'=>'ion-ios-minus-outline'),
            array('ion-ios-minus'=>'ion-ios-minus'),
            array('ion-ios-monitor-outline'=>'ion-ios-monitor-outline'),
            array('ion-ios-monitor'=>'ion-ios-monitor'),
            array('ion-ios-moon-outline'=>'ion-ios-moon-outline'),
            array('ion-ios-moon'=>'ion-ios-moon'),
            array('ion-ios-more-outline'=>'ion-ios-more-outline'),
            array('ion-ios-more'=>'ion-ios-more'),
            array('ion-ios-musical-note'=>'ion-ios-musical-note'),
            array('ion-ios-musical-notes'=>'ion-ios-musical-notes'),
            array('ion-ios-navigate-outline'=>'ion-ios-navigate-outline'),
            array('ion-ios-navigate'=>'ion-ios-navigate'),
            array('ion-ios-nutrition-outline'=>'ion-ios-nutrition-outline'),
            array('ion-ios-nutrition'=>'ion-ios-nutrition'),
            array('ion-ios-paper-outline'=>'ion-ios-paper-outline'),
            array('ion-ios-paper'=>'ion-ios-paper'),
            array('ion-ios-paperplane-outline'=>'ion-ios-paperplane-outline'),
            array('ion-ios-paperplane'=>'ion-ios-paperplane'),
            array('ion-ios-partlysunny-outline'=>'ion-ios-partlysunny-outline'),
            array('ion-ios-partlysunny'=>'ion-ios-partlysunny'),
            array('ion-ios-pause-outline'=>'ion-ios-pause-outline'),
            array('ion-ios-pause'=>'ion-ios-pause'),
            array('ion-ios-paw-outline'=>'ion-ios-paw-outline'),
            array('ion-ios-paw'=>'ion-ios-paw'),
            array('ion-ios-people-outline'=>'ion-ios-people-outline'),
            array('ion-ios-people'=>'ion-ios-people'),
            array('ion-ios-person-outline'=>'ion-ios-person-outline'),
            array('ion-ios-person'=>'ion-ios-person'),
            array('ion-ios-personadd-outline'=>'ion-ios-personadd-outline'),
            array('ion-ios-personadd'=>'ion-ios-personadd'),
            array('ion-ios-photos-outline'=>'ion-ios-photos-outline'),
            array('ion-ios-photos'=>'ion-ios-photos'),
            array('ion-ios-pie-outline'=>'ion-ios-pie-outline'),
            array('ion-ios-pie'=>'ion-ios-pie'),
            array('ion-ios-pint-outline'=>'ion-ios-pint-outline'),
            array('ion-ios-pint'=>'ion-ios-pint'),
            array('ion-ios-play-outline'=>'ion-ios-play-outline'),
            array('ion-ios-play'=>'ion-ios-play'),
            array('ion-ios-plus-empty'=>'ion-ios-plus-empty'),
            array('ion-ios-plus-outline'=>'ion-ios-plus-outline'),
            array('ion-ios-plus'=>'ion-ios-plus'),
            array('ion-ios-pricetag-outline'=>'ion-ios-pricetag-outline'),
            array('ion-ios-pricetag'=>'ion-ios-pricetag'),
            array('ion-ios-pricetags-outline'=>'ion-ios-pricetags-outline'),
            array('ion-ios-pricetags'=>'ion-ios-pricetags'),
            array('ion-ios-printer-outline'=>'ion-ios-printer-outline'),
            array('ion-ios-printer'=>'ion-ios-printer'),
            array('ion-ios-pulse-strong'=>'ion-ios-pulse-strong'),
            array('ion-ios-pulse'=>'ion-ios-pulse'),
            array('ion-ios-rainy-outline'=>'ion-ios-rainy-outline'),
            array('ion-ios-rainy'=>'ion-ios-rainy'),
            array('ion-ios-recording-outline'=>'ion-ios-recording-outline'),
            array('ion-ios-recording'=>'ion-ios-recording'),
            array('ion-ios-redo-outline'=>'ion-ios-redo-outline'),
            array('ion-ios-redo'=>'ion-ios-redo'),
            array('ion-ios-refresh-empty'=>'ion-ios-refresh-empty'),
            array('ion-ios-refresh-outline'=>'ion-ios-refresh-outline'),
            array('ion-ios-refresh'=>'ion-ios-refresh'),
            array('ion-ios-reload'=>'ion-ios-reload'),
            array('ion-ios-reverse-camera-outline'=>'ion-ios-reverse-camera-outline'),
            array('ion-ios-reverse-camera'=>'ion-ios-reverse-camera'),
            array('ion-ios-rewind-outline'=>'ion-ios-rewind-outline'),
            array('ion-ios-rewind'=>'ion-ios-rewind'),
            array('ion-ios-rose-outline'=>'ion-ios-rose-outline'),
            array('ion-ios-rose'=>'ion-ios-rose'),
            array('ion-ios-search-strong'=>'ion-ios-search-strong'),
            array('ion-ios-search'=>'ion-ios-search'),
            array('ion-ios-settings-strong'=>'ion-ios-settings-strong'),
            array('ion-ios-settings'=>'ion-ios-settings'),
            array('ion-ios-shuffle-strong'=>'ion-ios-shuffle-strong'),
            array('ion-ios-shuffle'=>'ion-ios-shuffle'),
            array('ion-ios-skipbackward-outline'=>'ion-ios-skipbackward-outline'),
            array('ion-ios-skipbackward'=>'ion-ios-skipbackward'),
            array('ion-ios-skipforward-outline'=>'ion-ios-skipforward-outline'),
            array('ion-ios-skipforward'=>'ion-ios-skipforward'),
            array('ion-ios-snowy'=>'ion-ios-snowy'),
            array('ion-ios-speedometer-outline'=>'ion-ios-speedometer-outline'),
            array('ion-ios-speedometer'=>'ion-ios-speedometer'),
            array('ion-ios-star-half'=>'ion-ios-star-half'),
            array('ion-ios-star-outline'=>'ion-ios-star-outline'),
            array('ion-ios-star'=>'ion-ios-star'),
            array('ion-ios-stopwatch-outline'=>'ion-ios-stopwatch-outline'),
            array('ion-ios-stopwatch'=>'ion-ios-stopwatch'),
            array('ion-ios-sunny-outline'=>'ion-ios-sunny-outline'),
            array('ion-ios-sunny'=>'ion-ios-sunny'),
            array('ion-ios-telephone-outline'=>'ion-ios-telephone-outline'),
            array('ion-ios-telephone'=>'ion-ios-telephone'),
            array('ion-ios-tennisball-outline'=>'ion-ios-tennisball-outline'),
            array('ion-ios-tennisball'=>'ion-ios-tennisball'),
            array('ion-ios-thunderstorm-outline'=>'ion-ios-thunderstorm-outline'),
            array('ion-ios-thunderstorm'=>'ion-ios-thunderstorm'),
            array('ion-ios-time-outline'=>'ion-ios-time-outline'),
            array('ion-ios-time'=>'ion-ios-time'),
            array('ion-ios-timer-outline'=>'ion-ios-timer-outline'),
            array('ion-ios-timer'=>'ion-ios-timer'),
            array('ion-ios-toggle-outline'=>'ion-ios-toggle-outline'),
            array('ion-ios-toggle'=>'ion-ios-toggle'),
            array('ion-ios-trash-outline'=>'ion-ios-trash-outline'),
            array('ion-ios-trash'=>'ion-ios-trash'),
            array('ion-ios-undo-outline'=>'ion-ios-undo-outline'),
            array('ion-ios-undo'=>'ion-ios-undo'),
            array('ion-ios-unlocked-outline'=>'ion-ios-unlocked-outline'),
            array('ion-ios-unlocked'=>'ion-ios-unlocked'),
            array('ion-ios-upload-outline'=>'ion-ios-upload-outline'),
            array('ion-ios-upload'=>'ion-ios-upload'),
            array('ion-ios-videocam-outline'=>'ion-ios-videocam-outline'),
            array('ion-ios-videocam'=>'ion-ios-videocam'),
            array('ion-ios-volume-high'=>'ion-ios-volume-high'),
            array('ion-ios-volume-low'=>'ion-ios-volume-low'),
            array('ion-ios-wineglass-outline'=>'ion-ios-wineglass-outline'),
            array('ion-ios-wineglass'=>'ion-ios-wineglass'),
            array('ion-ios-world-outline'=>'ion-ios-world-outline'),
            array('ion-ios-world'=>'ion-ios-world'),
            array('ion-ipad'=>'ion-ipad'),
            array('ion-iphone'=>'ion-iphone'),
            array('ion-ipod'=>'ion-ipod'),
            array('ion-jet'=>'ion-jet'),
            array('ion-key'=>'ion-key'),
            array('ion-knife'=>'ion-knife'),
            array('ion-laptop'=>'ion-laptop'),
            array('ion-leaf'=>'ion-leaf'),
            array('ion-levels'=>'ion-levels'),
            array('ion-lightbulb'=>'ion-lightbulb'),
            array('ion-link'=>'ion-link'),
            array('ion-load-a'=>'ion-load-a'),
            array('ion-load-b'=>'ion-load-b'),
            array('ion-load-c'=>'ion-load-c'),
            array('ion-load-d'=>'ion-load-d'),
            array('ion-location'=>'ion-location'),
            array('ion-lock-combination'=>'ion-lock-combination'),
            array('ion-locked'=>'ion-locked'),
            array('ion-log-in'=>'ion-log-in'),
            array('ion-log-out'=>'ion-log-out'),
            array('ion-loop'=>'ion-loop'),
            array('ion-magnet'=>'ion-magnet'),
            array('ion-male'=>'ion-male'),
            array('ion-man'=>'ion-man'),
            array('ion-map'=>'ion-map'),
            array('ion-medkit'=>'ion-medkit'),
            array('ion-merge'=>'ion-merge'),
            array('ion-mic-a'=>'ion-mic-a'),
            array('ion-mic-b'=>'ion-mic-b'),
            array('ion-mic-c'=>'ion-mic-c'),
            array('ion-minus-circled'=>'ion-minus-circled'),
            array('ion-minus-round'=>'ion-minus-round'),
            array('ion-minus'=>'ion-minus'),
            array('ion-model-s'=>'ion-model-s'),
            array('ion-monitor'=>'ion-monitor'),
            array('ion-more'=>'ion-more'),
            array('ion-mouse'=>'ion-mouse'),
            array('ion-music-note'=>'ion-music-note'),
            array('ion-navicon-round'=>'ion-navicon-round'),
            array('ion-navicon'=>'ion-navicon'),
            array('ion-navigate'=>'ion-navigate'),
            array('ion-network'=>'ion-network'),
            array('ion-no-smoking'=>'ion-no-smoking'),
            array('ion-nuclear'=>'ion-nuclear'),
            array('ion-outlet'=>'ion-outlet'),
            array('ion-paintbrush'=>'ion-paintbrush'),
            array('ion-paintbucket'=>'ion-paintbucket'),
            array('ion-paper-airplane'=>'ion-paper-airplane'),
            array('ion-paperclip'=>'ion-paperclip'),
            array('ion-pause'=>'ion-pause'),
            array('ion-person-add'=>'ion-person-add'),
            array('ion-person-stalker'=>'ion-person-stalker'),
            array('ion-person'=>'ion-person'),
            array('ion-pie-graph'=>'ion-pie-graph'),
            array('ion-pin'=>'ion-pin'),
            array('ion-pinpoint'=>'ion-pinpoint'),
            array('ion-pizza'=>'ion-pizza'),
            array('ion-plane'=>'ion-plane'),
            array('ion-planet'=>'ion-planet'),
            array('ion-play'=>'ion-play'),
            array('ion-playstation'=>'ion-playstation'),
            array('ion-plus-circled'=>'ion-plus-circled'),
            array('ion-plus-round'=>'ion-plus-round'),
            array('ion-plus'=>'ion-plus'),
            array('ion-podium'=>'ion-podium'),
            array('ion-pound'=>'ion-pound'),
            array('ion-power'=>'ion-power'),
            array('ion-pricetag'=>'ion-pricetag'),
            array('ion-pricetags'=>'ion-pricetags'),
            array('ion-printer'=>'ion-printer'),
            array('ion-pull-request'=>'ion-pull-request'),
            array('ion-qr-scanner'=>'ion-qr-scanner'),
            array('ion-quote'=>'ion-quote'),
            array('ion-radio-waves'=>'ion-radio-waves'),
            array('ion-record'=>'ion-record'),
            array('ion-refresh'=>'ion-refresh'),
            array('ion-reply-all'=>'ion-reply-all'),
            array('ion-reply'=>'ion-reply'),
            array('ion-ribbon-a'=>'ion-ribbon-a'),
            array('ion-ribbon-b'=>'ion-ribbon-b'),
            array('ion-sad-outline'=>'ion-sad-outline'),
            array('ion-sad'=>'ion-sad'),
            array('ion-scissors'=>'ion-scissors'),
            array('ion-search'=>'ion-search'),
            array('ion-settings'=>'ion-settings'),
            array('ion-share'=>'ion-share'),
            array('ion-shuffle'=>'ion-shuffle'),
            array('ion-skip-backward'=>'ion-skip-backward'),
            array('ion-skip-forward'=>'ion-skip-forward'),
            array('ion-social-android-outline'=>'ion-social-android-outline'),
            array('ion-social-android'=>'ion-social-android'),
            array('ion-social-angular-outline'=>'ion-social-angular-outline'),
            array('ion-social-angular'=>'ion-social-angular'),
            array('ion-social-apple-outline'=>'ion-social-apple-outline'),
            array('ion-social-apple'=>'ion-social-apple'),
            array('ion-social-bitcoin-outline'=>'ion-social-bitcoin-outline'),
            array('ion-social-bitcoin'=>'ion-social-bitcoin'),
            array('ion-social-buffer-outline'=>'ion-social-buffer-outline'),
            array('ion-social-buffer'=>'ion-social-buffer'),
            array('ion-social-chrome-outline'=>'ion-social-chrome-outline'),
            array('ion-social-chrome'=>'ion-social-chrome'),
            array('ion-social-codepen-outline'=>'ion-social-codepen-outline'),
            array('ion-social-codepen'=>'ion-social-codepen'),
            array('ion-social-css3-outline'=>'ion-social-css3-outline'),
            array('ion-social-css3'=>'ion-social-css3'),
            array('ion-social-designernews-outline'=>'ion-social-designernews-outline'),
            array('ion-social-designernews'=>'ion-social-designernews'),
            array('ion-social-dribbble-outline'=>'ion-social-dribbble-outline'),
            array('ion-social-dribbble'=>'ion-social-dribbble'),
            array('ion-social-dropbox-outline'=>'ion-social-dropbox-outline'),
            array('ion-social-dropbox'=>'ion-social-dropbox'),
            array('ion-social-euro-outline'=>'ion-social-euro-outline'),
            array('ion-social-euro'=>'ion-social-euro'),
            array('ion-social-facebook-outline'=>'ion-social-facebook-outline'),
            array('ion-social-facebook'=>'ion-social-facebook'),
            array('ion-social-foursquare-outline'=>'ion-social-foursquare-outline'),
            array('ion-social-foursquare'=>'ion-social-foursquare'),
            array('ion-social-freebsd-devil'=>'ion-social-freebsd-devil'),
            array('ion-social-github-outline'=>'ion-social-github-outline'),
            array('ion-social-github'=>'ion-social-github'),
            array('ion-social-google-outline'=>'ion-social-google-outline'),
            array('ion-social-google'=>'ion-social-google'),
            array('ion-social-googleplus-outline'=>'ion-social-googleplus-outline'),
            array('ion-social-googleplus'=>'ion-social-googleplus'),
            array('ion-social-hackernews-outline'=>'ion-social-hackernews-outline'),
            array('ion-social-hackernews'=>'ion-social-hackernews'),
            array('ion-social-html5-outline'=>'ion-social-html5-outline'),
            array('ion-social-html5'=>'ion-social-html5'),
            array('ion-social-instagram-outline'=>'ion-social-instagram-outline'),
            array('ion-social-instagram'=>'ion-social-instagram'),
            array('ion-social-javascript-outline'=>'ion-social-javascript-outline'),
            array('ion-social-javascript'=>'ion-social-javascript'),
            array('ion-social-linkedin-outline'=>'ion-social-linkedin-outline'),
            array('ion-social-linkedin'=>'ion-social-linkedin'),
            array('ion-social-markdown'=>'ion-social-markdown'),
            array('ion-social-nodejs'=>'ion-social-nodejs'),
            array('ion-social-octocat'=>'ion-social-octocat'),
            array('ion-social-pinterest-outline'=>'ion-social-pinterest-outline'),
            array('ion-social-pinterest'=>'ion-social-pinterest'),
            array('ion-social-python'=>'ion-social-python'),
            array('ion-social-reddit-outline'=>'ion-social-reddit-outline'),
            array('ion-social-reddit'=>'ion-social-reddit'),
            array('ion-social-rss-outline'=>'ion-social-rss-outline'),
            array('ion-social-rss'=>'ion-social-rss'),
            array('ion-social-sass'=>'ion-social-sass'),
            array('ion-social-skype-outline'=>'ion-social-skype-outline'),
            array('ion-social-skype'=>'ion-social-skype'),
            array('ion-social-snapchat-outline'=>'ion-social-snapchat-outline'),
            array('ion-social-snapchat'=>'ion-social-snapchat'),
            array('ion-social-tumblr-outline'=>'ion-social-tumblr-outline'),
            array('ion-social-tumblr'=>'ion-social-tumblr'),
            array('ion-social-tux'=>'ion-social-tux'),
            array('ion-social-twitch-outline'=>'ion-social-twitch-outline'),
            array('ion-social-twitch'=>'ion-social-twitch'),
            array('ion-social-twitter-outline'=>'ion-social-twitter-outline'),
            array('ion-social-twitter'=>'ion-social-twitter'),
            array('ion-social-usd-outline'=>'ion-social-usd-outline'),
            array('ion-social-usd'=>'ion-social-usd'),
            array('ion-social-vimeo-outline'=>'ion-social-vimeo-outline'),
            array('ion-social-vimeo'=>'ion-social-vimeo'),
            array('ion-social-whatsapp-outline'=>'ion-social-whatsapp-outline'),
            array('ion-social-whatsapp'=>'ion-social-whatsapp'),
            array('ion-social-windows-outline'=>'ion-social-windows-outline'),
            array('ion-social-windows'=>'ion-social-windows'),
            array('ion-social-wordpress-outline'=>'ion-social-wordpress-outline'),
            array('ion-social-wordpress'=>'ion-social-wordpress'),
            array('ion-social-yahoo-outline'=>'ion-social-yahoo-outline'),
            array('ion-social-yahoo'=>'ion-social-yahoo'),
            array('ion-social-yen-outline'=>'ion-social-yen-outline'),
            array('ion-social-yen'=>'ion-social-yen'),
            array('ion-social-youtube-outline'=>'ion-social-youtube-outline'),
            array('ion-social-youtube'=>'ion-social-youtube'),
            array('ion-soup-can-outline'=>'ion-soup-can-outline'),
            array('ion-soup-can'=>'ion-soup-can'),
            array('ion-speakerphone'=>'ion-speakerphone'),
            array('ion-speedometer'=>'ion-speedometer'),
            array('ion-spoon'=>'ion-spoon'),
            array('ion-star'=>'ion-star'),
            array('ion-stats-bars'=>'ion-stats-bars'),
            array('ion-steam'=>'ion-steam'),
            array('ion-stop'=>'ion-stop'),
            array('ion-thermometer'=>'ion-thermometer'),
            array('ion-thumbsdown'=>'ion-thumbsdown'),
            array('ion-thumbsup'=>'ion-thumbsup'),
            array('ion-toggle-filled'=>'ion-toggle-filled'),
            array('ion-toggle'=>'ion-toggle'),
            array('ion-transgender'=>'ion-transgender'),
            array('ion-trash-a'=>'ion-trash-a'),
            array('ion-trash-b'=>'ion-trash-b'),
            array('ion-trophy'=>'ion-trophy'),
            array('ion-tshirt-outline'=>'ion-tshirt-outline'),
            array('ion-tshirt'=>'ion-tshirt'),
            array('ion-umbrella'=>'ion-umbrella'),
            array('ion-university'=>'ion-university'),
            array('ion-unlocked'=>'ion-unlocked'),
            array('ion-upload'=>'ion-upload'),
            array('ion-usb'=>'ion-usb'),
            array('ion-videocamera'=>'ion-videocamera'),
            array('ion-volume-high'=>'ion-volume-high'),
            array('ion-volume-low'=>'ion-volume-low'),
            array('ion-volume-medium'=>'ion-volume-medium'),
            array('ion-volume-mute'=>'ion-volume-mute'),
            array('ion-wand'=>'ion-wand'),
            array('ion-waterdrop'=>'ion-waterdrop'),
            array('ion-wifi'=>'ion-wifi'),
            array('ion-wineglass'=>'ion-wineglass'),
            array('ion-woman'=>'ion-woman'),
            array('ion-wrench'=>'ion-wrench'),
            array('ion-xbox=>'=>'ion-xbox'),
        );
    }
}