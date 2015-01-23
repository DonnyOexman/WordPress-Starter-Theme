<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage WP Starter Theme
 * @since WP Starter Theme 1.0
 */

get_header(); ?>

<div class="content-container">
    <div class="row">
        <section class="primary-content content-area" role="main">

            <?php get_template_part( 'content', 'none' ); ?>

        </section><!-- .primary-content -->
    </div><!-- .row -->
</div><!-- .content-container -->

<?php
get_footer();
