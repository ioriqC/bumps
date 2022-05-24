<?php
/**
 * The template includes necessary functions for theme.
 *
 * @package sanjose
 * @since 1.0.0
 *
 */

if ( ! isset( $content_width ) ) {
    $content_width = 960; // pixel
}


// ------------------------------------------
// Global define for theme
// ------------------------------------------
defined( 'SANJOSE_URI' )    or define( 'SANJOSE_URI',    get_template_directory_uri() );
defined( 'SANJOSE_T_PATH' ) or define( 'SANJOSE_T_PATH', get_template_directory() );
defined( 'SANJOSE_F_PATH' ) or define( 'SANJOSE_F_PATH', SANJOSE_T_PATH . '/include' );

// ------------------------------------------
// Framework integration
// ------------------------------------------

// Include all styles and scripts.
require_once SANJOSE_T_PATH .'/include/custom/inc.php';

require SANJOSE_T_PATH . '/vendor/autoload.php';

/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_sanjose() {

	if ( ! class_exists( 'Appsero\Client' ) ) {
		require_once SANJOSE_T_PATH . '/vendor/appsero/client/src/Client.php';
	}

	$client = new \Appsero\Client( '39408f4d-05c7-4e23-bc93-590cc9155de1', 'SanJose', __FILE__ );

	// Active insights
	$client->insights()->init();

	// Active automatic updater
	$client->updater();

}

appsero_init_tracker_sanjose();

// ------------------------------------------
// Setting theme after setup
// ------------------------------------------
if ( ! function_exists( 'sanjose_after_setup' ) ) {
    function sanjose_after_setup()
    {
        load_theme_textdomain( 'sanjose', SANJOSE_T_PATH .'/languages' );

        register_nav_menus(
            array(
                'top-menu' => esc_html__( 'Top menu', 'sanjose' ),
            )
        );

        add_theme_support( 'custom-header' );
        add_theme_support( 'custom-background' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption') );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'title-tag' );
		remove_theme_support( 'widgets-block-editor' );
    }
}
add_action( 'after_setup_theme', 'sanjose_after_setup' );

function sanjose_set_script( $scripts, $handle, $src, $deps = array(), $ver = false, $in_footer = false ) {
	$script = $scripts->query( $handle, 'registered' );
	if ( $script ) {
		// If already added
		$script->src  = $src;
		$script->deps = $deps;
		$script->ver  = $ver;
		$script->args = $in_footer;
		unset( $script->extra['group'] );
		if ( $in_footer ) {
			$script->add_data( 'group', 1 );
		}
	} else {
		// Add the script
		if ( $in_footer ) {
			$scripts->add( $handle, $src, $deps, $ver, 1 );
		} else {
			$scripts->add( $handle, $src, $deps, $ver );
		}
	}
}
function sanjose_replace_scripts( $scripts ) {
	$assets_url = SANJOSE_URI . '/assets/js/';
	sanjose_set_script( $scripts, 'jquery-migrate', $assets_url . 'jquery-migrate.min.js', array(), '1.4.1-wp' );
	sanjose_set_script( $scripts, 'jquery', false, array( 'jquery-core', 'jquery-migrate' ), '1.12.4-wp' );
}
add_action( 'wp_default_scripts', 'sanjose_replace_scripts' );