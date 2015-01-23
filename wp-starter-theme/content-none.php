<?php
/**
 * The template for displaying a message that posts cannot be found
 *
 * @package WordPress
 * @subpackage WP Starter Theme
 * @since WP Starter Theme 1.0
 */
?>

<section class="no-results not-found">
    <article id="post-0" class="post-0 entry">

        <header class="page-header">
            <h1 class="page-title"><?php _e( 'Er kon helaas niets gevonden worden.', THEME_SLUG ); ?></h1>
        </header><!-- .page-header -->

        <div class="page-content">

            <?php if ( is_search() ) : ?>

                <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', THEME_SLUG ); ?></p>

            <?php else : ?>

                <p><?php _e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', THEME_SLUG ); ?></p>

            <?php endif; // End if is_search() ?>

            <?php get_search_form(); ?>

        </div><!-- .page-content -->

    </article><!-- #post-0 -->
</section><!-- .no-results -->
