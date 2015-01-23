<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage WP Starter Theme
 * @since WP Starter Theme 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">
        <?php
            wpst_post_thumbnail();

            the_title( '<h1 class="entry-title">', '</h1>' );
        ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
            the_content();

            wp_link_pages( array(
                'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pagina\'s:', THEME_SLUG ) . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>'
            ) );
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php edit_post_link( '&#xf040; ' . __( 'Aanpassen', THEME_SLUG ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-footer -->

</article><!-- #post-## -->
