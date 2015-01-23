<?php

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since WP Starter Theme 1.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function wpst_paging_nav() {
    global $wp_query, $wp_rewrite;

    // Don't print empty markup if there's only one page.
    if ( $wp_query->max_num_pages < 2 ) {
        return;
    }

    $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $query_args   = array();
    $url_parts    = explode( '?', $pagenum_link );

    if ( isset( $url_parts[1] ) ) {
        wp_parse_str( $url_parts[1], $query_args );
    }

    $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
    $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

    $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

    // Set up paginated links.
    $links = paginate_links( array(
        'base'     => $pagenum_link,
        'format'   => $format,
        'total'    => $wp_query->max_num_pages,
        'current'  => $paged,
        'mid_size' => 1,
        'add_args' => array_map( 'urlencode', $query_args ),
        'prev_text' => '&larr; ' . __( 'Vorige', THEME_SLUG ),
        'next_text' => __( 'Volgende' . ' &rarr;', THEME_SLUG ),
    ) );

    if ( $links ) :
?>

    <nav class="navigation paging-navigation" role="navigation">
        <h1 class="screen-reader-text"><?php _e( 'Posts navigation', THEME_SLUG ); ?></h1>
        <div class="pagination loop-pagination">
            <?php echo $links; ?>
        </div><!-- .pagination -->
    </nav><!-- .navigation -->

<?php
    endif; // End if $links
}

/**
 * Display navigation to next/previous post when applicable.
 *
 * @since WP Starter Theme 1.0
 */
function wpst_post_nav() {
    // Don't print empty markup if there's nowhere to navigate.
    $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous ) {
        return;
    }
?>

    <nav class="navigation post-navigation" role="navigation">
        <h1 class="screen-reader-text"><?php _e( 'Post navigation', THEME_SLUG ); ?></h1>
        <div class="nav-links">
            <?php
                if ( is_attachment() ) {
                    previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', THEME_SLUG ) );
                } else {
                    previous_post_link( '%link', __( '<span class="meta-nav">Previous Post</span>%title', THEME_SLUG ) );
                    next_post_link( '%link', __( '<span class="meta-nav">Next Post</span>%title', THEME_SLUG ) );
                }
            ?>
        </div><!-- .nav-links -->
    </nav><!-- .navigation -->

<?php
}

/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since WP Starter Theme 1.0
 */
function wpst_posted_on() {
    if ( is_sticky() && is_home() && ! is_paged() ) {
        echo '<span class="featured-post">' . __( 'Sticky', THEME_SLUG ) . '</span>';
    }

    // Set up and print post meta information.
    printf( '<span class="entry-date"><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span> <span class="byline"><span class="author vcard"><a class="url fn n" href="%4$s" rel="author">%5$s</a></span></span>',
        esc_url( get_permalink() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        get_the_author()
    );
}

/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 *
 * @since WP Starter Theme 1.0
 */
function wpst_post_thumbnail() {
    if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
        return;
    }

    if ( is_singular() ) :
?>

        <div class="post-thumbnail">
            <?php
                if ( ( ! is_active_sidebar( 'sidebar-primary' ) || is_page_template( 'page-templates/full-width.php' ) ) ) {the_post_thumbnail( 'full-width' );
                } else {
                    the_post_thumbnail();
                }
            ?>
        </div><!-- .post-thumbnail -->

    <?php else : ?>

        <a class="post-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>

    <?php endif; // End if is_singular()
}

/**
 * Print the attached image with a link to the next attached image.
 *
 * @since WP Starter Theme 1.0
 */
function wpst_the_attached_image() {
    $post = get_post();

    /**
     * Filter the default WP Starter Theme attachment size.
     *
     * @since WP Starter Theme 1.0
     *
     * @param array $dimensions {
     *     An array of height and width dimensions.
     *
     *     @type int $height Height of the image in pixels. Default 810.
     *     @type int $width  Width of the image in pixels. Default 810.
     * }
     */
    $attachment_size = apply_filters( 'wpst_attachment_size', array( 810, 810 ) );

    $next_attachment_url = wp_get_attachment_url();

    /*
     * Grab the IDs of all the image attachments in a gallery so we can get the URL
     * of the next adjacent image in a gallery, or the first image (if we're
     * looking at the last image in a gallery), or, in a gallery of one, just the
     * link to that image file.
     */
    $attachment_ids = get_posts( array(
        'post_parent'       => $post->post_parent,
        'fields'            => 'ids',
        'numberposts'       => -1,
        'post_status'       => 'inherit',
        'post_type'         => 'attachment',
        'post_mime_type'    => 'image',
        'order'             => 'ASC',
        'orderby'           => 'menu_order ID'
    ) );

    // If there is more than 1 attachment in a gallery...
    if ( count( $attachment_ids ) > 1 ) {
        foreach ( $attachment_ids as $attachment_id ) {
            if ( $attachment_id == $post->ID ) {
                $next_id = current( $attachment_ids );
                break;
            }
        }

        // get the URL of the next image attachment...
        if ( $next_id ) {
            $next_attachment_url = get_attachment_link( $next_id );
        }

        // or get the URL of the first image attachment.
        else {
            $next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
        }
    }

    printf( '<a href="%1$s" rel="attachment">%2$s</a>', esc_url( $next_attachment_url ), wp_get_attachment_image( $post->ID, $attachment_size ) );
}
