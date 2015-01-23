<?php

use WPCore\PostType\PostType;


$custom_post_types = array(
    // Add custom post type 'Slides'
    array(
        'id' => 'slide',
        'args' => array(
            'labels' => array(
                'name' => __( 'Slides', THEME_SLUG ),
                'singular_name' => __( 'Slide', THEME_SLUG ),
                'add_new_item' => __( 'Add New Slide', THEME_SLUG ),
                'edit_item' => __( 'Edit Slide', THEME_SLUG ),
                'new_item' => __( 'New Slide', THEME_SLUG ),
                'view_item' => __( 'View Slide', THEME_SLUG ),
                'search_items' => __( 'Search Slides', THEME_SLUG ),
                'not_found' => __( 'No slides found.', THEME_SLUG ),
                'not_found_in_trash' => __( 'No slides found in Trash.', THEME_SLUG )
            ),
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_nav_menus' => false,
            'menu_position' => 10,
            'menu_icon' => 'dashicons-slides',
            'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
            'rewrite' => array(
                'slug' => __( 'slide', THEME_SLUG )
            )
        )
    ),
    // Add custom post type 'Content Blocks'
    array(
        'id' => 'content_block',
        'args' => array(
            'labels' => array(
                'name' => __( 'Content Blocks', THEME_SLUG ),
                'singular_name' => __( 'Content Block', THEME_SLUG ),
                'add_new_item' => __( 'Add New Content Block', THEME_SLUG ),
                'edit_item' => __( 'Edit Content Block', THEME_SLUG ),
                'new_item' => __( 'New Content Block', THEME_SLUG ),
                'view_item' => __( 'View Content Block', THEME_SLUG ),
                'search_items' => __( 'Search Content Blocks', THEME_SLUG ),
                'not_found' => __( 'No content blocks found.', THEME_SLUG ),
                'not_found_in_trash' => __( 'No content blocks found in Trash.', THEME_SLUG )
            ),
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_nav_menus' => false,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-admin-page',
            'supports' => array( 'title', 'editor', 'revisions' ),
            'rewrite' => array(
                'slug' => __( 'content-block', THEME_SLUG )
            )
        )
    ),
    // Add custom post type 'Testimonials'
    array(
        'id' => 'testimonial',
        'args' => array(
            'labels' => array(
                'name' => __( 'Testimonials', THEME_SLUG ),
                'singular_name' => __( 'Testimonial', THEME_SLUG ),
                'add_new_item' => __( 'Add New Testimonial', THEME_SLUG ),
                'edit_item' => __( 'Edit Testimonial', THEME_SLUG ),
                'new_item' => __( 'New Testimonial', THEME_SLUG ),
                'view_item' => __( 'View Testimonial', THEME_SLUG ),
                'search_items' => __( 'Search Testimonials', THEME_SLUG ),
                'not_found' => __( 'No testimonials found.', THEME_SLUG ),
                'not_found_in_trash' => __( 'No testimonials found in Trash.', THEME_SLUG )
            ),
            'public' => true,
            'has_archive' => false,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-megaphone',
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
            'rewrite' => array(
                'slug' => __( 'testimonial' )
            )
        )
    )
);

// Create the CPTs
foreach( $custom_post_types as $cpt ) {
    new PostType( $cpt );
}
