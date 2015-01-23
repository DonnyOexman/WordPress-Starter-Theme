<?php
/**
 * The main template file
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
                if ( have_posts() ) :

                    while ( have_posts() ) : the_post();

                        get_template_part( 'content', get_post_format() );

                    endwhile;

                    wpst_paging_nav();

                else :

                    get_template_part( 'content', 'none' );

                endif;
            ?>

        </section><!-- .primary-content -->

        <?php get_sidebar(); ?>
    </div><!-- .row -->
</div><!-- .content-container -->

<?php
get_footer();
