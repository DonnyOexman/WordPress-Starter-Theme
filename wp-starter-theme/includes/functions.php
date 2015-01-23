<?php

/**
 * Custom excerpt function to limit by words instead of characters.
 *
 * @since WP Starter Theme 1.0
 *
 * @param  int $limit       Word limit
 * @return string           The new excerpt
 */
function wpst_excerpt( $limit ) {
    $excerpt = explode( ' ', get_the_excerpt(), $limit );

    if ( count( $excerpt ) >= $limit ) {
        array_pop($excerpt);
        $excerpt = implode( ' ', $excerpt ) . apply_filters( 'excerpt_more', ' ' );
    } else {
        $excerpt = implode( ' ', $excerpt );
    }

    $excerpt = preg_replace( '`[[^]]*]`', '', $excerpt );

    return $excerpt;
}

/**
 * Menu fallback. Links to the menu editor if needed.
 *
 * @since WP Starter Theme 1.0
 *
 * @param  array $args      Given arguments
 * @return string           The new menu fallback
 */
function wpst_default_menu_fallback( $args ) {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    extract( $args );

    $link = $link_before . '<a href="' . admin_url( 'nav-menus.php' ) . '">' . $before . __( 'Please add a menu first', THEME_SLUG ) . $after . '</a>' . $link_after;

    // We have a list
    if ( FALSE !== stripos( $items_wrap, '<ul' ) || FALSE !== stripos( $items_wrap, '<ol' ) ) {
        $link = "<li>$link</li>";
    }

    $output = sprintf( $items_wrap, $menu_id, $menu_class, $link );

    if ( ! empty ( $container ) ) {
        $output  = "<$container class='$container_class' id='$container_id'>$output</$container>";
    }

    if ( $echo ) {
        echo $output;
    }

    return $output;
}
