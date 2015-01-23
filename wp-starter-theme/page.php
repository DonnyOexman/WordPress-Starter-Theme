<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage WP Starter Theme
 * @since WP Starter Theme 1.0
 */

get_header(); ?>

<?php putRevSlider( 'default-slider' ); ?>

<div class="content-container">
    <div class="row">
        <section class="primary-content content-area" role="main">

            <?php
                while ( have_posts() ) : the_post();

                    get_template_part( 'content', 'page' );

                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }

                endwhile;
            ?>

        </section><!-- .primary-content -->

        <?php get_sidebar(); ?>
    </div><!-- .row -->
</div><!-- .content-container -->

<?php
get_footer();
