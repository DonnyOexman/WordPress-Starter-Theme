<?php
/**
 * The template for displaying image attachments
 *
 * @package WordPress
 * @subpackage WP Starter Theme
 * @since WP Starter Theme 1.0
 */

// Retrieve attachment metadata.
$metadata = wp_get_attachment_metadata();

get_header();
?>

<div class="content-container">
    <div class="row">
        <section class="primary-content content-area" role="main">

            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                        <div class="entry-meta">
                            <span class="entry-date"><time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></span>

                            <span class="full-size-link"><a href="<?php echo esc_url( wp_get_attachment_url() ); ?>"><?php echo $metadata['width']; ?> &times; <?php echo $metadata['height']; ?></a></span>

                            <span class="parent-post-link"><a href="<?php echo esc_url( get_permalink( $post->post_parent ) ); ?>" rel="gallery"><?php echo get_the_title( $post->post_parent ); ?></a></span>
                        </div><!-- .entry-meta -->
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <div class="entry-attachment">
                            <div class="attachment">
                                <?php wpst_the_attached_image(); ?>
                            </div><!-- .attachment -->

                            <?php if ( has_excerpt() ) : ?>

                                <div class="entry-caption">
                                    <?php the_excerpt(); ?>
                                </div><!-- .entry-caption -->

                            <?php endif; // End if has_excerpt() ?>
                        </div><!-- .entry-attachment -->

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

                <nav id="image-navigation" class="navigation image-navigation">
                    <div class="nav-links">
                        <?php previous_image_link( false, '<div class="previous-image">' . __( 'Previous Image', THEME_SLUG ) . '</div>' ); ?>

                        <?php next_image_link( false, '<div class="next-image">' . __( 'Next Image', THEME_SLUG ) . '</div>' ); ?>
                    </div><!-- .nav-links -->
                </nav><!-- #image-navigation -->

                <?php comments_template(); ?>

            <?php endwhile; ?>

        </section><!-- .primary-content -->
    </div>
</div><!-- .content-container -->

<?php
get_footer();
