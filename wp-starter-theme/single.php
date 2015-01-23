<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage WP Starter Theme
 * @since WP Starter Theme 1.0
 */

get_header(); ?>

<div class="content-container">
    <div class="row">
        <section class="primary-content content-area" role="main">

            <?php
                while ( have_posts() ) : the_post();

                    get_template_part( 'content', get_post_format() );

                    wpst_post_nav();

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
