<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * @package WordPress
 * @subpackage WP Starter Theme
 * @since WP Starter Theme 1.0
 */

get_header(); ?>

<div class="content-container">
    <div class="row">
        <section class="primary-content content-area" role="main">

            <header class="page-header">
                <h1 class="page-title">
                    <?php
                        if ( is_category() ) {
                            single_cat_title();
                        } elseif ( is_tag() ) {
                            single_tag_title();
                        } elseif ( is_author() ) {
                            printf( __( 'All posts by %s', THEME_SLUG ), '<span class="vcard">' . get_the_author() . '</span>' );
                        } elseif ( is_day() ) {
                            printf( __( 'Dag: %s', THEME_SLUG ), '<span>' . get_the_date() . '</span>' );
                        } elseif ( is_month() ) {
                            printf( __( 'Maand: %s', THEME_SLUG ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', THEME_SLUG ) ) . '</span>' );
                        } elseif ( is_year() ) {
                            printf( __( 'Jaar: %s', THEME_SLUG ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', THEME_SLUG ) ) . '</span>' );
                        } else {
                            _e( 'Archieven', THEME_SLUG );
                        }
                    ?>
                </h1>

                <?php
                    // Show an optional term description.
                    $term_description = term_description();

                    if ( ! empty( $term_description ) ) {
                        printf( '<div class="taxonomy-description">%s</div>', $term_description );
                    }

                    // Show author description when possible.
                    if( is_author() ) {
                        $author_description = get_the_author_meta( 'description' );

                        if ( ! empty( $author_description ) ) {
                            printf( '<div class="author-description">%s</div>', $author_description );
                        }
                    }
                ?>
            </header><!-- .page-header -->

            <?php
                while ( have_posts() ) : the_post();

                    get_template_part( 'content', get_post_format() );

                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }

                endwhile;

                wpst_paging_nav();
            ?>

        </section><!-- .primary-content -->

        <?php get_sidebar(); ?>
    </div><!-- .row -->
</div><!-- .content-container -->

<?php
get_footer();
