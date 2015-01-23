<?php
/**
 * The sidebar containing the footer widget area
 *
 * @package WordPress
 * @subpackage WP Starter Theme
 * @since WP Starter Theme 1.0
 */

if ( ! is_active_sidebar( 'sidebar-footer' ) ) {
    return;
}
?>

<div class="primary-footer-container">
    <footer class="row">

        <?php dynamic_sidebar( 'sidebar-footer' ); ?>

    </footer><!-- .row -->
</div><!-- .primary-footer-container -->
