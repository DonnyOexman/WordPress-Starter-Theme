<?php
/**
 * The sidebar containing the primary widget area
 *
 * @package WordPress
 * @subpackage WP Starter Theme
 * @since WP Starter Theme 1.0
 */

if ( ! is_active_sidebar( 'sidebar-primary' ) ) {
    return;
}
?>

<div class="secondary-content widget-area" role="complementary">

    <?php dynamic_sidebar( 'sidebar-primary' ); ?>

</div><!-- .secondary-content -->
