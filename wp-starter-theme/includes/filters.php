<?php

// This theme uses its own gallery styles, so we need to remove the default WordPress gallery style.
add_filter( 'use_default_gallery_style', '__return_false' );

// Extend classes of the <body> and the posts.
add_filter( 'body_class', 'wpst_body_classes' );
add_filter( 'post_class', 'wpst_post_classes' );

// Change the title of the page.
add_filter( 'wp_title', 'wpst_wp_title', 10, 2 );

// Change the excerpt length and more link.
add_filter( 'excerpt_length', 'wpst_excerpt_length', 999 );
add_filter( 'excerpt_more', 'wpst_new_excerpt_more' );

// Change the quality of image uploads.
add_filter( 'jpeg_quality', 'wpst_image_full_quality' );
add_filter( 'wp_editor_set_quality', 'wpst_image_full_quality' );

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Index views.
 * 3. Single views.
 *
 * @since WP Starter Theme 1.0
 *
 * @param array $classes    A list of existing body class values.
 * @return array            The filtered body class list.
 */
function wpst_body_classes( $classes ) {
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    if ( is_archive() || is_search() || is_home() ) {
        $classes[] = 'list-view';
    }

    if ( ( ! is_active_sidebar( 'sidebar-primary' ) )
        || is_page_template( 'page-templates/full-width.php' )
        || is_attachment()
        || is_404() ) {
        $classes[] = 'full-width';
    }

    if ( is_singular() && ! is_front_page() ) {
        $classes[] = 'singular';
    }

    return $classes;
}

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since WP Starter Theme 1.0
 *
 * @param array $classes    A list of existing post class values.
 * @return array            The filtered post class list.
 */
function wpst_post_classes( $classes ) {
    $classes[] = 'entry';

    if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
        $classes[] = 'has-post-thumbnail';
    }

    return $classes;
}

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since WP Starter Theme 1.0
 *
 * @param string $title     Default title text for current view.
 * @param string $sep       Optional separator.
 * @return string           The filtered title.
 */
function wpst_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() ) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo( 'name', 'display' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 ) {
        $title = "$title $sep " . sprintf( __( 'Pagina %s', THEME_SLUG ), max( $paged, $page ) );
    }

    return $title;
}

/**
 * Changes the default excerpt length
 *
 * @since WP Starter Theme 1.0
 *
 * @param  int $length      The current excerpt length
 * @return int              The new excerpt length
 */
function wpst_excerpt_length( $length ) {
    return 20;
}

/**
 * Changes the default excerpt more text
 *
 * @since WP Starter Theme 1.0
 *
 * @param  string $more     The current excerpt more text
 * @return string           The new excerpt more text
 */
function wpst_new_excerpt_more( $more ) {
    return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __( '&raquo; Lees meer', THEME_SLUG ) . '</a>';
}

/**
 * Changes the default image upload quality
 *
 * @since WP Starter Theme 1.0
 *
 * @param  int $quality     The current image upload quality
 * @return int              The next image upload quality
 */
function wpst_image_full_quality( $quality ) {
    return 100;
}
