<?php
/**
 * Action Config - Theme setting
 *
 * @package sanjose
 * @since 1.0.0
 *
 */

// ------------------------------------------
// Global actions for theme
// ------------------------------------------
add_action( 'widgets_init',       'sanjose_register_sidebar' );
add_action( 'wp_enqueue_scripts', 'sanjose_enqueue_scripts');
add_action( 'wp_enqueue_scripts', 'sanjose_custom_styles');
add_action( 'tgmpa_register',     'sanjose_include_required_plugins' );


// ------------------------------------------
// Function for add actions
// ------------------------------------------
/** Function for register sidebar */
if ( ! function_exists( 'sanjose_register_sidebar' ) ) {
	function sanjose_register_sidebar()
	{

		// register main sidebars
		register_sidebar(
			array(
				'id'            => 'sidebar',
				'name'          => esc_html__( 'Sidebar' , 'sanjose' ),
				'before_widget' => '<div class="sanjose-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="sanjose-title-w">',
				'after_title'   => '</h6>',
				'description'   => esc_html__( 'Drag the widgets for blog sidebars.', 'sanjose' )
			)
		);

		// register footer sidebars is active
		register_sidebar(
			array(
				'id'            => 'footer-sidebar',
				'name'          => esc_html__( 'Footer sidebar' , 'sanjose' ),
				'before_widget' => '<div class="col-xs-12 col-sm-4 col-md-4 sanjose-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="sanjose-title-w">',
				'after_title'   => '</h6>',
				'description'   => esc_html__( 'Drag the widgets for footer sidebars.', 'sanjose' )
			)
		);
	}
}

/** Loads all the js and css script to frontend */
if ( ! function_exists( 'sanjose_enqueue_scripts' ) ) {
	function sanjose_enqueue_scripts()
	{
		// general settings
		if ( ( is_admin() ) ) { return; }

        wp_enqueue_script( 'bootstrap-js',	            get_theme_file_uri( '/assets/js/bootstrap.min.js' ), array( 'jquery' ), false, true );
        wp_enqueue_script( 'jquery-mmenu-main',	        get_theme_file_uri( '/assets/js/jquery.mmenu.all.min.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'jquery-carousel',	        get_theme_file_uri( '/assets/js/owl.carousel.min.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'jquery-circliful',	        get_theme_file_uri( '/assets/js/jquery.circliful.min.js' ), array( 'jquery' ), false, true );
        wp_enqueue_script( 'particles',                 get_theme_file_uri( '/assets/js/particles.min.js' ), array( 'jquery' ), false, true );
        wp_enqueue_script( 'jquery-fitvids',     	    get_theme_file_uri( '/assets/js/jquery.fitvids.js' ), array( 'jquery' ), false, true );
        wp_enqueue_script( 'swiper',	           		get_theme_file_uri( '/assets/js/swiper.min.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'easypiechart',              get_theme_file_uri( '/assets/js/jquery.easypiechart.min.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'isotope',                   get_theme_file_uri( '/assets/js/isotope.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'lightgallery',              get_theme_file_uri( '/assets/js/lightgallery.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'sanjose-scripts',           get_theme_file_uri( '/assets/js/scripts.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'sanjose-main',	            get_theme_file_uri( '/assets/js/main.js' ), array( 'jquery' ), false, true );


		// add TinyMCE style
		add_editor_style();

		// including jQuery plugins
		wp_localize_script('sanjose-main', 'ajax_data',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'sanjose-siteurl' => get_template_directory_uri()
			)
		);

		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// register style
		wp_enqueue_style( 'sanjose-core', 	      		get_theme_file_uri( '/style.css' ) );
        wp_enqueue_style( 'font-awesome', 		  		get_theme_file_uri( '/assets/css/font-awesome.min.css' ) );
        wp_enqueue_style( 'sanjose-info-icons', 	    get_theme_file_uri( '/assets/css/info.css' ) );
        wp_enqueue_style( 'bootstrap', 			  		get_theme_file_uri( '/assets/css/bootstrap.min.css' ) );
        wp_enqueue_style( 'carousel-css',		  		get_theme_file_uri( '/assets/css/owl.carousel.min.css' ) );
        wp_enqueue_style( 'sanjose-resp-menu', 	  		get_theme_file_uri( '/assets/css/responsive-menu.css' ) );
        wp_enqueue_style( 'sanjose-custom-spacing', 	get_theme_file_uri( '/assets/css/custom-spacing.css' ) );
        wp_enqueue_style( 'swiper-css', 	      		get_theme_file_uri( '/assets/css/swiper.css' ) );
        wp_enqueue_style( 'lightgallery-css', 	  		get_theme_file_uri( '/assets/css/lightgallery.css' ) );
        wp_enqueue_style( 'ionicons-css', 	      		get_theme_file_uri( '/assets/css/ionicons.min.css' ) );
		wp_enqueue_style( 'circliful', 		      		get_theme_file_uri( '/assets/css/jquery.circliful.css' ) );
		wp_enqueue_style( 'sanjose-style', 	      		get_theme_file_uri( '/assets/css/styl.css' ) );
		wp_enqueue_style( 'sanjose-guttenderg', 	      		get_theme_file_uri( '/assets/css/guttenderg.css' ) );
		wp_enqueue_style( 'sanjose-theme', 	      		get_theme_file_uri( '/assets/css/styles.css' ) );
	}
}

/** Include required plugins */
if ( ! function_exists( 'sanjose_include_required_plugins' ) ) {
	function sanjose_include_required_plugins()
	{
		$plugins = array(
			array(
				'name'                  => esc_html__( 'Contact Form 7', 'sanjose' ), // The plugin name
				'slug'                  => 'contact-form-7', // The plugin slug (typically the folder name)
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'                  => esc_html__( 'Visual Composer', 'sanjose' ), // The plugin name
				'slug'                  => 'js_composer', // The plugin slug (typically the folder name)
				'source'                =>  esc_url('http://import.foxthemes.me/plugins/premium-plugins/js_composer.zip'), // The plugin source
				'required'              => true, // If false, the plugin is only 'recommended' instead of required
				'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'                  => esc_html__( 'Sanjose Plugins', 'sanjose' ), // The plugin name
				'slug'                  => 'sanjose-plugins', // The plugin slug (typically the folder name)
				'source'                => esc_url('http://import.foxthemes.me/plugins/sanjose/sanjose-plugins.zip'), // The plugin source
				'required'              => true, // If false, the plugin is only 'recommended' instead of required
				'version'               => '1.0.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__('Gutenberg Blocks Collection', 'sanjose'),
				// The plugin name
				'slug'               => 'qodeblock',
				// The plugin slug (typically the folder name)
				'required'           => true,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'					=> esc_html__( 'MailChimp for WordPress', 'sanjose' ),
				'slug'					=> 'mailchimp-for-wp',
				'required'				=> false,
				'version'				=> '',
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'external_url'			=> ''
			),
			array(
				'name'					=> esc_html__( 'Upqode Google Maps', 'sanjose' ),
				'slug'					=> 'upqode-google-maps',
				'required'				=> false,
				'version'				=> '',
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'external_url'			=> ''
			),
		);

		// Change this to your theme text domain, used for internationalising strings

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'domain'            => 'sanjose',                    // Text domain - likely want to be the same as your theme.
			'default_path'      => '',                          // Default absolute path to pre-packaged plugins
			'menu'              => 'tgmpa-install-plugins',  	// Menu slug
			'has_notices'       => true,                        // Show admin notices or not
			'is_automatic'      => false,                        // Automatically activate plugins after installation or not
			'message'           => '',                          // Message to output right before the plugins table
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'sanjose' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'sanjose' ),
				/* translators: %s: plugin name. */
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'sanjose' ),
				/* translators: %s: plugin name. */
				'updating'                        => esc_html__( 'Updating Plugin: %s', 'sanjose' ),
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'sanjose' ),
				'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). */
					'This theme requires the following plugin: %1$s.',
					'This theme requires the following plugins: %1$s.',
					'sanjose'
				),
				'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). */
					'This theme recommends the following plugin: %1$s.',
					'This theme recommends the following plugins: %1$s.',
					'sanjose'
				),
				'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). */
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'sanjose'
				),
				'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). */
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'sanjose'
				),
				'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). */
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'sanjose'
				),
				'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). */
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'sanjose'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'sanjose'
				),
				'update_link' 					  => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'sanjose'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'sanjose'
				),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'sanjose' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'sanjose' ),
				'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'sanjose' ),
				/* translators: 1: plugin name. */
				'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'sanjose' ),
				/* translators: 1: plugin name. */
				'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'sanjose' ),
				/* translators: 1: dashboard link. */
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'sanjose' ),
				'dismiss'                         => esc_html__( 'Dismiss this notice', 'sanjose' ),
				'notice_cannot_install_activate'  => esc_html__( 'There are one or more required or recommended plugins to install, update or activate.', 'sanjose' ),
				'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'sanjose' ),

				'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
			),
		);

		tgmpa( $plugins, $config );
	}
}

/** Custom styles from Theme Options */
if ( ! function_exists( 'sanjose_custom_styles' ) ) {
	function sanjose_custom_styles() {
		$output = '';

		/* Global typography */
		$typography_style = cs_get_option('typography_style' );
		if ( ! empty( $typography_style ) && $typography_style ){
			foreach ( $typography_style as $key => $title ) {

				$heading_tag = '';
				if( $title['heading_tag'] == 'span' ) {
					$heading_tag .= '#animated-text span, .position, .info-author';
				} elseif( $title['heading_tag'] == 'a' ) { 
					$heading_tag .= '.container a, .sign-up';
			    } else {
					$heading_tag .= $title['heading_tag'];
				}

				if ( ! empty( $title['heading_family']['family'] ) ) {
					$output .= $heading_tag . ' {font-family:' . $title['heading_family']['family'] . ' !important;}' . "\n\r";

					if ( $title['heading_family']['font'] == 'google' ) {
						wp_enqueue_style( 'sanjose_header_typography', '//fonts.googleapis.com/css?family=' . $title['heading_family']['family'] . ':' . $title['heading_family']['variant'] );
					}
				}
				if ( ! empty( $title['heading_size'] ) ) {
					$output .=  $heading_tag . ' {font-size:' . $title['heading_size'] . 'px !important;}' . "\n\r";
				}
				if ( ! empty( $title['heading_color'] ) ) {
					$output .= $heading_tag . ' {color:' . $title['heading_color'] . ' !important;}' . "\n\r";
				}
			}
		}

		/* Custom menu typography */
		$default_header_typography = cs_get_option('default_header_typography' );
		if( ! empty( $default_header_typography ) && $default_header_typography ) {

		    $header_typography_group = cs_get_option('header_typography_group' );
			$typo = ( !empty( $header_typography_group ) ) ? $header_typography_group : '';

			if( ! empty( $typo['header_typography']['family'] ) ) {
				$output .= '.main-header .navigation ul li a {font-family:' . $typo['header_typography']['family'] . ';}' . "\n\r";
				
				if( $typo['header_typography']['font'] == 'google' ) {
					wp_enqueue_style( 'sanjose_header_typography', '//fonts.googleapis.com/css?family=' . $typo['header_typography']['family'] . ':' . $typo['header_typography']['variant'] );
				}
			}

			if( ! empty( $typo['header_font_size'] ) ) {
				$output .= '.main-header .navigation ul li a {font-size:' . $typo['header_font_size'] . 'px;}' . "\n\r";
			}

			if( ! empty( $typo['header_font_color'] ) ) {
				$output .= '.sanjose-header.white-header .main-menu > li > a, .main-header .navigation ul li a {color:' . $typo['header_font_color'] . ';}' . "\n\r";
			}
		}

		/* Text Logo font size */
		$text_logo_font_size = cs_get_option('text_logo_font_size' );
		if ( ! empty( $text_logo_font_size ) ){
			$output .= '.sanjose-header .logo a {font-size:' . $text_logo_font_size;
			$output .= ( is_numeric( $text_logo_font_size ) ) ? 'px;}' : ';}';
			$output .= "\n\r";
		}

		// Custom color scheme site
		if(cs_get_option('base_color')) {
			$output .= '.footer-bottom,';
			$output .= '.main-header:not(.absolute-header) {';
			 	$output .= 'background-color: '.cs_get_option('base_color').' !important;';
			$output .= '}';
			$output .= '.page-404__content .title,';
			$output .= '.custom-form-2 .wpcf7-form h2,';
			$output .= '.sanjose-contact-form.custom-form .wpcf7-form h2,';
			$output .= '.contact-info ul li a,';
			$output .= '.contact-info ul li,';
			$output .= '.sanjose-pricing .pricing-item h2,';
			$output .= '.sanjose-pricing .pricing-item h6,';
			$output .= '.sanjose-faq-info h6,';
			$output .= '.blog-list .post.sticky:after, .blog-list .page.sticky:after,';
			$output .= '.sanjose-accordion .panel .panel-title a[aria-expanded="true"],';
			$output .= '.sanjose-text h2,'; 
			$output .= '.sanjose-text h3,'; 
			$output .= '.sanjose-text h4,'; 
			$output .= '.sanjose-text h5,'; 
			$output .= '.sanjose-text h6,';
			$output .= '.footer-bottom,';
			$output .= '.main-footer,';
			$output .= '.main-header,';
			$output .= '.post-detail .post-password-form input[type="password"],';
			$output .= 'pre,';
			$output .= 'h1,'; 
			$output .= 'h2,'; 
			$output .= 'h3,'; 
			$output .= 'h4,'; 
			$output .= 'h5,'; 
			$output .= 'h6 '; 
			$output .= ' {';
				$output .= 'color: '.cs_get_option('base_color').' !important;';
			$output .= '}';
		}

		if(cs_get_option('front_base_color')) { 
			$output .= '.sanjose-product-slideshow .pagination-product li.tab-item,';
			$output .= '.sanjose-slider .pagination .swiper-pagination-switch.swiper-active-switch,';
			$output .= '.sanjose-slider .swiper-slide .content-slide .btn:hover,';
			$output .= '.sanjose-slider .swiper-slide .content-slide .btn,';
			$output .= '.sanjose-timeline .tab-content .swiper-container .pagination .swiper-pagination-switch.swiper-active-switch,';
			$output .= '.sanjose-timeline .tabs-header .tab-item.active .title, .sanjose-timeline .tabs-header .tab-item.active .counter,';
			$output .= '.sanjose-timeline .timeline-border .timeline-scale,';
			$output .= '.sanjose-timeline__animated-line,';
			$output .= '.sanjose-contact-form input[type="submit"]:hover,';
			$output .= '.sanjose-contact-form input[type="submit"],';
			$output .= '.sanjose-faq-info a.link:hover,';
			$output .= '.sanjose-faq-info a.link,';
			$output .= '.button.default:hover,';
			$output .= '.button.default,';
			$output .= '.sanjose-video-banner .button-play,';
			$output .= '.wpb_widgetised_column .sanjose-widget.widget_categories li:before,';
			$output .= '.sidebar.blog-sidebar .sanjose-widget.widget_categories li a:before,';
			$output .= '.banner-blog__content .btn:hover,';
			$output .= '.banner-blog__content .btn,';
			$output .= '.sanjose-banner .content-banner .mc4wp-form input[type="submit"]:hover,';
			$output .= '.sanjose-banner .content-banner .mc4wp-form input[type="submit"],';
			$output .= '.sanjose-banner .content-banner .mc4wp-form input:focus,';
			$output .= '.sanjose-text ul li:before,';
			$output .= '.sanjose-text a.link:hover,';
			$output .= '.sanjose-text a.link,';
			$output .= '.main-footer .mc4wp-form input[type="submit"]:hover,';
			$output .= '.main-footer .mc4wp-form input:focus,';
			$output .= '.sanjose-banner .content-banner .btn:hover,';
			$output .= '.main-header .navigation .other-links a:last-child:hover,';
			$output .= '.main-header .navigation ul li:hover .sub-menu a:hover,';
			$output .= '.sanjose-timeline .tabs-header .tab-item.highlited .title, .sanjose-timeline .tabs-header .tab-item.highlited .counter,';
			$output .= '.main-header .navigation ul li.current_page_item > a, .main-header .navigation ul li.current-menu-parent > a,';
			$output .= '.main-header .navigation ul li a:hover {'; 
				$output .= 'color: '.cs_get_option('front_base_color').' !important;';
			$output .= '}';
			$output .= '.sanjose-product-slideshow .pagination-product li.tab-item,';
			$output .= '.sanjose-slider .pagination .swiper-pagination-switch.swiper-active-switch,';
			$output .= '.sanjose-slider .swiper-slide .content-slide .btn,';
			$output .= '.sanjose-timeline .tab-content .swiper-container .pagination .swiper-pagination-switch.swiper-active-switch,';
			$output .= '.sanjose-timeline .timeline-border .timeline-scale,';
			$output .= '.sanjose-timeline__animated-line,';
			$output .= '.sanjose-contact-form input[type="submit"],';
			$output .= '.sanjose-faq-info a.link:hover,';
			$output .= '.button.default,';
			$output .= '.sanjose-video-banner .button-play,';
			$output .= '.banner-blog__content .btn,';
			$output .= '.sanjose-banner .content-banner .mc4wp-form input[type="submit"],';
			$output .= '.sanjose-banner .content-banner .btn,';
			$output .= '.sanjose-text a.link:hover,';
			$output .= '.sanjose-accordion.style_3 .panel .panel-body .btn-link:hover,';
			$output .= '.main-footer .mc4wp-form input[type="submit"],';
			$output .= '.sanjose-pricing.classic .pricing-item.active h2,';
			$output .= '.sanjose-pricing .label-text,';
			$output .= '.main-header .navigation .other-links a:last-child {';
				$output .= 'background-color: '.cs_get_option('front_base_color').' !important;';
			$output .= '}';
			$output .= '.sanjose-slider .pagination .swiper-pagination-switch.swiper-active-switch ,';
			$output .= '.sanjose-timeline .tabs-header .tab-item.active .title, .sanjose-timeline .tabs-header .tab-item.active .counter ,';
			$output .= '.sanjose-banner .content-banner .mc4wp-form input[type="submit"] ,';
			$output .= '.sanjose-banner .content-banner .mc4wp-form input:focus ,';
			$output .= '.main-footer .mc4wp-form input[type="submit"] ,';
			$output .= '.sanjose-banner .content-banner .btn ,';
			$output .= '.sanjose-timeline .tabs-header .tab-item.highlited .title, .sanjose-timeline .tabs-header .tab-item.highlited .counter,';
			$output .= '.main-header .navigation .other-links a:last-child ,';
			$output .= '.sanjose-text a.link ,';
			$output .= '.button.default:hover ,';
			$output .= '.button.default ,';
			$output .= '.button.default ,';
			$output .= '.sanjose-accordion.style_3 .panel .panel-body .btn-link ,';
			$output .= '.sanjose-faq-info a.link ,';
			$output .= '.main-footer .mc4wp-form input:focus {';
				$output .= 'border-color: '.cs_get_option('front_base_color').' !important;';
			$output .= '}';
			$output .= '.button.default, ';
			$output .= '.sanjose-text a.link:hover, ';
			$output .= '.sanjose-faq-info a.link:hover, ';
			$output .= '.button.default, .sanjose-text a.link:hover { ';
				$output .= 'color: #fff !important;';
			$output .= '}';
			$output .= '.main-header .navigation .other-links a:last-child:hover, ';
			$output .= '.button.default:hover, ';
			$output .= '.sanjose-banner .content-banner .btn:hover, ';
			$output .= '.main-footer .mc4wp-form input[type="submit"]:hover, .main-footer .mc4wp-form input[type="submit"]:hover {';
				$output .= 'background-color: transparent !important;';
			$output .= '}';

		}

		if(cs_get_option('front_other_color')) {
			$output .= '.search-banner .content-banner .search-form .search-submit,';
			$output .= '.sanjose-pricing.modern .select-price li.active,';
			$output .= '.sanjose-pricing .pricing-item.active .btn,';
			$output .= '.sanjose-pricing .pricing-item .btn:hover,';
			$output .= '.sanjose-faq-info a.link.modern:hover,';
			$output .= '.post-comments #sanjose-comment-form .send-button,';
			$output .= '.wpb_widgetised_column .sanjose-widget.widget_tag_cloud a:hover,';
			$output .= '.sidebar.blog-sidebar .sanjose-widget.widget_tag_cloud a:hover,';
			$output .= '.load-btn:hover,';
			$output .= '.post-detail .post-password-form input[type="submit"] {';
				$output .= 'background-color: '.cs_get_option('front_other_color').' !important;';
			$output .= '}';
			$output .= '.search-banner .content-banner .search-form .search-submit,';
			$output .= '.sanjose-pricing.modern .pricing-item ul li:before,';
			$output .= '.sanjose-pricing.modern .select-price li.active,';
			$output .= '.sanjose-pricing .pricing-item.active .btn:hover,';
			$output .= '.sanjose-pricing .pricing-item.active .btn,';
			$output .= '.sanjose-pricing .pricing-item .btn:hover,';
			$output .= '.sanjose-pricing .pricing-item .btn,';
			$output .= '.sanjose-faq-info a.link.modern:hover,';
			$output .= '.sanjose-faq-info a.link.modern,';
			$output .= '.post-comments #sanjose-comment-form .send-button:hover,';
			$output .= '.post-comments #sanjose-comment-form .send-button,';
			$output .= '.post-comments .sanjose-comments-list li .comm-txt .comment-ctn .comment-reply-link,';
			$output .= '.wpb_widgetised_column .sanjose-widget.widget_tag_cloud a:hover,';
			$output .= '.wpb_widgetised_column .sanjose-widget.widget_categories li a:hover,';
			$output .= '.sidebar.blog-sidebar .sanjose-widget.widget_tag_cloud a:hover,';
			$output .= '.sidebar.blog-sidebar .sanjose-widget.widget_categories li a:hover,';
			$output .= '.load-btn:hover,';
			$output .= '.load-btn,';
			$output .= '.blog-list.vertical .post .content-post h6 a:hover,';
			$output .= '.blog-list.modern .post-item .content-post .read-more:hover,';
			$output .= '.blog-list.modern .post-item .content-post .modern-info li a:hover,';
			$output .= '.blog-list.modern .post-item .content-post h6 a:hover,';
			$output .= '.blog-list.default .post .entry-meta ul li:last-child a, .blog-list.default .page .entry-meta ul li:last-child a,';
			$output .= '.blog-list.default .post .read-more, .blog-list.default .page .read-more,';
			$output .= '.blog-list .post h6 a:hover, .blog-list .page h6 a:hover,';
			$output .= '.footer-bottom a:hover,';
			$output .= '.main-footer .sidebar .sanjose-widget a:hover,';
			$output .= '.post-detail .post-password-form input[type="submit"],';
			$output .= '.no-menu a,';
			$output .= 'a, a:visited {';
				$output .=' color: '.cs_get_option('front_other_color').' !important;';
			$output .= '}';
			$output .= '.sanjose-faq-info a.link.modern,';
			$output .= '.sanjose-pricing .pricing-item.active .btn,';
			$output .= '.sanjose-pricing .pricing-item .btn,';
			$output .= '.load-btn {';
				$output .= 'border-color: '.cs_get_option('front_other_color').' !important;';
			$output .= '}';
			$output .= ' a:hover, ';
			$output .= ' .main-footer .sidebar .sanjose-widget a:hover, ';
			$output .= '.load-btn:hover, ';
			$output .= '.sanjose-pricing .pricing-item.active .btn, ';
			$output .= '.sanjose-pricing .pricing-item .btn:hover, ';
			$output .= '.sanjose-faq-info a.link.modern:hover {';
				$output .= 'color: #fff !important;';
			$output .= '}';
			$output .= '.sanjose-pricing .pricing-item.active .btn:hover {';
				$output .= 'background-color: transparent !important;';
			$output .= '}';

		}

		if(cs_get_option('other_color')) { 
			$output .= '.main-header .menu-hamburger i:before, .main-header .menu-hamburger i:after,';
			$output .= '.main-header .menu-hamburger i,';
			$output .= '#mm-main-menu .mm-clear:after, #mm-main-menu .mm-clear:before, #mm-main-menu .mm-close:after, #mm-main-menu .mm-close:before,';
			$output .= '#mm-main-menu .mm-listview > li, #mm-main-menu .mm-listview > li .mm-next, #mm-main-menu .mm-listview > li .mm-next:before,'; 		
			$output .= '#mm-main-menu .mm-listview > li:after, #mm-main-menu .mm-next:after, #mm-main-menu .mm-prev:before,';
			$output .= '#mm-main-menu .mm-navbar a,';
			$output .= '#mm-main-menu .mm-listview > li > a, #mm-main-menu .mm-listview > li > span,';
			$output .= '.search-banner .content-banner .search-form .search-submit,';
			$output .= '.sanjose-slider .swiper-slide .content-slide .btn,';
			$output .= '.sanjose-slider .swiper-slide .content-slide .title,';
			$output .= '.sanjose-contact-form input[type="submit"],';
			$output .= '.sanjose-contact-form input:focus, .sanjose-contact-form textarea:focus,';
			$output .= '.sanjose-pricing.modern .select-price li.active,';
			$output .= '.sanjose-pricing .pricing-item.active .btn,';
			$output .= '.sanjose-pricing .pricing-item.active,';
			$output .= '.sanjose-pricing .pricing-item .btn:hover,';
			$output .= '.sanjose-pricing .select-price li.active,';
			$output .= '.sanjose-faq-info a.link.modern:hover,';
			$output .= '.sanjose-faq-info a.link:hover,';
			$output .= '.button.transparent:hover,';
			$output .= '.button.default,';
			$output .= '.post-comments #sanjose-comment-form .send-button,';
			$output .= '.post-detail .entry-meta .social-list li button:hover .fa,';
			$output .= '.wpb_widgetised_column .sanjose-widget.widget_tag_cloud a:hover,';
			$output .= '.sidebar.blog-sidebar .sanjose-widget.widget_tag_cloud a:hover,';
			$output .= '.load-btn:hover,';
			$output .= '.blog-list.modern .post-item .content-post .info-post li,';
			$output .= '.blog-list.modern .post-item .content-post .read-more,';
			$output .= '.blog-list.modern .post-item .content-post h6 a,';
			$output .= '.banner-blog__content .btn,';
			$output .= '.sanjose-testimonials-slider.default .swiper-slide.swiper-slide-active .content:before,';
			$output .= '.sanjose-testimonials-slider.default .swiper-slide.swiper-slide-active .content,';
			$output .= '.sanjose-banner.style_5 .content-banner .title,';
			$output .= '.sanjose-banner.style_4 .title,';
			$output .= '.sanjose-banner.style_3 .content-banner .title,';
			$output .= '.sanjose-banner.style_2 .content-banner .title,';
			$output .= '.sanjose-banner .content-banner .mc4wp-form input[type="submit"],';
			$output .= '.sanjose-banner .content-banner .mc4wp-form input:-ms-input-placeholder,';
			$output .= '.sanjose-banner .content-banner .mc4wp-form input:-moz-placeholder,';
			$output .= '.sanjose-banner .content-banner .mc4wp-form input::-moz-placeholder,';
			$output .= '.sanjose-banner .content-banner .mc4wp-form input::-webkit-input-placeholder,';
			$output .= '.sanjose-banner .content-banner .mc4wp-form input,';
			$output .= '.sanjose-banner .content-banner .mc4wp-form p,';
			$output .= '.sanjose-banner .content-banner .btn,';
			$output .= '.sanjose-banner .content-banner .title,';
			$output .= '.sanjose-text a.link:hover,';
			$output .= '.main-footer .mc4wp-form input[type="submit"],';
			$output .= '.main-footer .mc4wp-form p,';
			$output .= '.main-footer .sidebar .sanjose-widget.info_widget ul li a:hover,';
			$output .= '.main-header .navigation .other-links a:last-child,';
			$output .= '.main-header .navigation ul li a,';
			$output .= '.main-header .logo a,';
			$output .= '.post-detail .post-password-form input[type="submit"],';
			$output .= '.no-menu {';
				$output .= 'color: '.cs_get_option('other_color').' !important;';
			$output .= '}';
			$output .= '.main-header .menu-hamburger i:before, .main-header .menu-hamburger i:after,';
			$output .= '.main-header .menu-hamburger i,';
			$output .= '.sanjose-contact-form input:focus, .sanjose-contact-form textarea:focus,';
			$output .= '.sanjose-pricing .pricing-item.active,';
			$output .= '.sanjose-pricing .select-price li.active,';
			$output .= '.sanjose-testimonials-slider.default .swiper-slide.swiper-slide-active .content {';
				$output .= 'background-color: '.cs_get_option('other_color').' !important;';
			$output .= '}';
			$output .= '#mm-main-menu .mm-clear:after,'; 
			$output .= '#mm-main-menu .mm-clear:before,'; 
			$output .= '#mm-main-menu .mm-close:after,'; 
			$output .= '#mm-main-menu .mm-close:before ,';
			$output .= '#mm-main-menu .mm-listview > li,'; 
			$output .= '#mm-main-menu .mm-listview > li .mm-next,'; 
			$output .= '#mm-main-menu .mm-listview > li .mm-next:before,'; 
			$output .= '#mm-main-menu .mm-listview > li:after,'; 
			$output .= '#mm-main-menu .mm-next:after,'; 
			$output .= '#mm-main-menu .mm-prev:before {';
				$output .= 'border-color: '.cs_get_option('other_color').' !important;';
			$output .= '}';
			$output .= '.sanjose-testimonials-slider.default .swiper-slide.swiper-slide-active .content-slide .content:before {';
			$output .= 'border-top-color: '.cs_get_option('other_color').' !important; ';
		}

        if(cs_get_option('button_color')) {
            $output .= '.main-header .navigation .other-links a:last-child';
            $output .= ' {';
                $output .= 'background-color: '.cs_get_option('button_color').' ; border: 1px solid ' .cs_get_option('button_color'). '; ';
            $output .= ' }';
        }

        if(cs_get_option('button_color_botton')) {
            $output .= '.main-footer .mc4wp-form input[type="submit"]';
            $output .= ' {';
            $output .= 'background-color: '.cs_get_option('button_color_botton').' ; border-color:' .cs_get_option('button_color_botton'). '; ';
            $output .= ' }';
        }

		if( ! empty( $output ) ) {
			wp_add_inline_style( 'sanjose-theme', $output );
		}

		/* Custom JavaScript code */
		$custom_js_code = cs_get_option('custom_js_code' );
		if( ! empty( $custom_js_code ) ){
			if ( function_exists( 'wp_add_inline_script' ) ) {
				wp_add_inline_script( 'sanjose-main', cs_get_option('custom_js_code') );
			}
		}
	}
}

/*
 * Add backend styles for Gutenberg.
 */
add_action( 'enqueue_block_editor_assets', 'sanjose_add_gutenberg_assets' );

if ( ! function_exists( 'sanjose_add_gutenberg_assets' ) ) {
	function sanjose_add_gutenberg_assets() {

		// Load the theme styles within Gutenberg.

		wp_enqueue_style( 'sanjose-fonts', sanjose_fonts_url(), array() );
		wp_enqueue_style( 'font-awesome', 		  		get_theme_file_uri( '/assets/css/font-awesome.min.css' ) );
		wp_enqueue_style( 'sanjose-gutenberg', 		  		get_theme_file_uri( '/assets/css/gutenberg-editor-style.css' ) );

	}
}
