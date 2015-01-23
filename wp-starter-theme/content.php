<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
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

            if ( is_single() ) {
                the_title( '<h1 class="entry-title">', '</h1>' );
            } else {
                the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
            }
        ?>

        <?php if ( 'post' == get_post_type() ) : ?>

            <div class="entry-meta">
                <?php wpst_posted_on(); ?>
            </div><!-- .entry-meta -->

        <?php endif; ?>
    </header><!-- .entry-header -->

    <?php if ( is_search() ) : ?>

        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->

    <?php else : ?>

        <div class="entry-content">
            <?php
                the_content( __( 'Lees verder <span class="meta-nav">&rarr;</span>', THEME_SLUG ) );

                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pagina\'s:', THEME_SLUG ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>'
                ) );
            ?>
        </div><!-- .entry-content -->

    <?php endif; // End if is_search() ?>

    <footer class="entry-footer">

        <?php
            if ( 'post' == get_post_type() ) :
                $categories_list = get_the_category_list( __( ', ', THEME_SLUG ) );
                $tags_list = get_the_tag_list( '', __( ', ', '_s' ) );

                if ( $categories_list ) :
        ?>

            <span class="cat-links">
                <?php printf( __( 'Posted in %1$s', THEME_SLUG ), $categories_list ); ?>
            </span>

        <?php
                endif; // End if $categories_list

                if ( $tags_list ) :
        ?>

            <span class="tag-links">
                <?php printf( __( 'Tagged %1$s', THEME_SLUG ), $tags_list ); ?>
            </span>

        <?php
                endif; // End if $tags_list
            endif; // End if 'post' == get_post_type()
        ?>

        <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>

            <span class="comments-link"><?php comments_popup_link( __( 'Reactie plaatsen', THEME_SLUG ), __( '1 reactie', THEME_SLUG ), __( '% reacties', THEME_SLUG ) ); ?></span>

        <?php endif; ?>

        <?php edit_post_link( '&#xf040; ' . __( 'Aanpassen', THEME_SLUG ), '<span class="edit-link">', '</span>' ); ?>

    </footer><!-- .entry-footer -->

</article><!-- #post-## -->
