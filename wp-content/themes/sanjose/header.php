<?php
/**
 * Header template.
 *
 * @package sanjose
 * @since 1.0.0
 *
 */

// Absolute header
$header_style = '';
$absolute_header = get_post_meta( get_the_ID(), 'sanjose_page_options', true );

if( isset( $absolute_header['absolute_header'] ) && $absolute_header['absolute_header'] ) {
    $header_style = 'absolute-header';
}

$unitclass =!function_exists( 'cs_framework_init' ) ? ' unit' : '';

// Preloader site
$preloader_site = cs_get_option('page_preloader');
$sticky_header = cs_get_option('sticky_header');
$sticky_header_style = ( $sticky_header ) ? ' fix_menu ' : '';

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php wp_head(); ?>
  </head>
<body <?php body_class(); ?>>

	<?php if ( isset( $preloader_site ) && $preloader_site ) : ?>
		<div id="loading"></div>
	<?php endif; ?>

    <div class="mm-slideout<?php echo esc_attr( $unitclass ); ?>">

	<header class="main-header clearfix <?php echo esc_attr( $header_style . $sticky_header_style); ?>">
        <div class="container no-padd-md">
            <div class="row">
                <div class="col-md-12">

                    <!-- Logo header -->
                    <div class="logo">
                        <?php
                        $color_logo = cs_get_option('text_color');
                        $style_logo =  ( ! empty( $color_logo ) ) ? 'style="color: '. esc_attr( $color_logo ) .' "' : '';
                        ?>
                        <a <?php echo  $style_logo; ?> href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php sanjose_logo(); ?></a>
                    </div>

                    <!-- Navigation header -->
                    <nav id="main-menu" class="navigation clearfix">
                        <?php
                            sanjose_custom_menu();
                            sanjose_header_links();
                        ?>
                    </nav>

                    <a class="menu-hamburger" href="#main-menu"><i></i></a>

                </div>
            </div>
        </div>
	</header>

	