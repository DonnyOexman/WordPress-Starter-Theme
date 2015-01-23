<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage WP Starter Theme
 * @since WP Starter Theme 1.0
 */

get_header(); ?>

<div class="content-container">
    <div class="row">
        <section class="primary-content content-area" role="main">

            <?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <h1 class="page-title"><?php printf( __( 'Search Results for: %s', THEME_SLUG ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                </header><!-- .page-header -->

                <?php
                    while ( have_posts() ) : the_post();

                        get_template_part( 'content', get_post_format() );

                    endwhile;

                    wpst_paging_nav();
                ?>

            <?php else : ?>

                <?php get_template_part( 'content', 'none' ); ?>

            <?php endif; // End if have_posts() ?>

        </section><!-- .primary-content -->

        <?php get_sidebar(); ?>
    </div><!-- .row -->
</div><!-- .content-container -->

<?php
get_footer();
