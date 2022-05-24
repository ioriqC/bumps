<?php
/**
 * Footer template.
 *
 * @package sanjose
 * @since 1.0.0
 *
 */

// Footer sign up
$footer_sign_up = cs_get_option('footer_sign_up');

// Footer subscribe
$footer_subscribe = cs_get_option('footer_subscribe');
$hide_subscribe   = ( isset( $footer_subscribe ) && $footer_subscribe ) ? 'col-md-8' : 'col-md-12';

// Footer copyright
$footer_copyright = cs_get_option('footer_copyright');
$footer_subscribe_shortcode = cs_get_option('footer_subscribe_shortcode');

$footer = true;
if ( is_page() ) {
	$meta_data = get_post_meta( get_the_ID(), 'sanjose_page_options', true );
	if ( isset( $meta_data['page_footer'] ) && $meta_data['page_footer'] === false ) {
		$footer = false;
	}
}

	if ( $footer ) : ?>

		<footer class="main-footer">
		    <div class="container no-padd-md">
		        <div class="row">

					<!-- Footer sidebar -->
                    <?php if ( is_active_sidebar('footer-sidebar') ): ?>
                        <div class="<?php echo esc_attr( $hide_subscribe ); ?>">
                            <aside class="sidebar row">
                                <?php dynamic_sidebar('footer-sidebar'); ?>
                            </aside>
                        </div>
                    <?php endif; ?>

                    <!-- Footer subscribe -->
                    <?php if ( isset( $footer_subscribe ) && $footer_subscribe ) : ?>
                        <div class="col-md-4 no-padd-r-md">
							<?php if ( ! empty( $footer_subscribe_shortcode ) ): ?>
								<div class="main-footer__subscribe">
									<?php echo do_shortcode( cs_get_option('footer_subscribe_shortcode') ); ?>
								</div>
							<?php endif; ?>
                        </div>
                    <?php endif; ?>

		        </div>
		    </div>
		</footer>

        <!-- Footer bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <!-- Footer copyright -->
                    <?php if ( isset( $footer_copyright ) && $footer_copyright ) { ?>
                        <div class="col-md-6">
                            <div class="footer-bottom__copyright">
                                <p><?php echo wp_kses_post( $footer_copyright ); ?></p>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-xs-12">
                            <div class="footer-bottom__copyright text-center">
                                <p><?php echo esc_html_e('@', 'sanjose') . date("Y") . ' ' . get_bloginfo('name'); ?></p>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- Footer links -->
                    <div class="col-md-6 text-right-md">
                        <?php if ( cs_get_option('footer_other_links') ): ?>
                            <div class="footer-bottom__links">
                                <?php sanjose_other_links(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php endif;

	wp_footer(); ?>
	</body>
</html>
