<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the .content-container and .off-canvas-wrap div elements.
 *
 * @package WordPress
 * @subpackage WP Starter Theme
 * @since WP Starter Theme 1.0
 */
?>

                    </div><!-- .main-container-->

                    <div class="footer-container">
                        <?php get_sidebar( 'footer' ); ?>

                        <div class="secondary-footer-container">
                            <div class="row">
                                <footer>
                                    <p>&copy; Copyright <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>. <?php _e( 'All rights reserved.', THEME_SLUG ); ?></p>

                                    <p><?php _e( 'Powered by', THEME_SLUG ); ?> <a target="_blank" href="http://www.donnyoexman.com/">D. Oexman</a></p>
                                </footer>
                            </div><!-- .row -->
                        </div><!-- .secondary-footer-container-->
                    </div><!-- .footer-container-->
                </div><!-- .page-container -->

                <a class="exit-off-canvas"></a>
            </div><!-- .inner-wrap -->
        </div><!-- .off-canvas-wrap -->

        <?php wp_footer(); ?>
    </body>
</html>
