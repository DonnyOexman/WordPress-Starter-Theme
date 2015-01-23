<?php

class WPST {

    function __construct() {
        $this->themeConstants();
        $this->themeIncludes();
        $this->themeActions();
    }

    function themeConstants() {
        define( 'THEME_SLUG',           get_template() );
        define( 'THEME_DIR',            get_template_directory() );
        define( 'THEME_DIR_INCLUDES',   get_template_directory() . '/includes' );
        define( 'THEME_URI',            get_template_directory_uri() );
        define( 'THEME_URI_ASSETS',     THEME_URI . '/assets' );
        define( 'THEME_URI_JS',         THEME_URI_ASSETS . '/js' );
        define( 'THEME_URI_COMPONENTS', THEME_URI_ASSETS . '/components' );
        define( 'THEME_URI_IMAGES',     THEME_URI_ASSETS . '/images' );
    }

    function themeIncludes() {
        require_once( THEME_DIR_INCLUDES . '/wp-core.php' );
        require_once( THEME_DIR_INCLUDES . '/functions.php' );
        require_once( THEME_DIR_INCLUDES . '/filters.php' );
        require_once( THEME_DIR_INCLUDES . '/actions.php' );
        require_once( THEME_DIR_INCLUDES . '/template-tags.php' );
        require_once( THEME_DIR_INCLUDES . '/widgets.php' );
    }

    function themeActions() {
        add_action( 'after_setup_theme', array( $this, 'themeSetup' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'themeStylesAndScripts' ), 999 );

        add_action( 'widgets_init', array( $this, 'themeSidebars' ) );
    }

    /**
     * WP Starter Theme setup.
     *
     * Set up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support post thumbnails.
     *
     * @since WP Starter Theme 1.0
     */
    function themeSetup() {
        $this->themeSupports();
        $this->themeMenus();
    }

    function themeSupports() {
        // This theme styles the visual editor to resemble the theme style.
        add_editor_style( THEME_URI_ASSETS . '/css/style-editor.css' );

        // Add RSS feed links to <head> for posts and comments.
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails, and declare two sizes.
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 900, 400, true );
        add_image_size( 'full-width', 1170, 400, true );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ) );

        // This theme allows users to set a custom background.
        add_theme_support( 'custom-background', apply_filters( 'wpst_custom_background_args', array(
            'default-color' => 'ffdda0'
        ) ) );
    }

    function themeMenus() {
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', THEME_SLUG )
        ) );
    }

    function themeStylesAndScripts() {
        wp_enqueue_style( 'stylesheet', get_stylesheet_uri() );

        wp_enqueue_style( 'bxslider-4', THEME_URI_COMPONENTS . '/bxslider-4/jquery.bxslider.css' );

        wp_enqueue_script( 'modernizr', THEME_URI_COMPONENTS . '/modernizr/modernizr.min.js', false, false, false );

        wp_deregister_script( 'jquery' );

        wp_enqueue_script( 'jquery', THEME_URI_COMPONENTS . '/jquery/dist/jquery.min.js', false, false, false );

        wp_enqueue_script( 'jquery.placeholder', THEME_URI_COMPONENTS . '/jquery-placeholder/jquery.placeholder.min.js', array( 'jquery' ), false, true );

        wp_enqueue_script( 'foundation', THEME_URI_COMPONENTS . '/foundation/js/foundation.min.js', array( 'jquery' ), false, true );

        wp_enqueue_script( 'foundation.offcanvas', THEME_URI_COMPONENTS . '/foundation/js/foundation/foundation.offcanvas.js', array( 'jquery', 'foundation' ), false, true );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        wp_enqueue_script( 'bxslider-4', THEME_URI_COMPONENTS . '/bxslider-4/jquery.bxslider.min.js', array( 'jquery' ), false, true );

        wp_enqueue_script( 'app', THEME_URI_JS . '/app.min.js', array( 'jquery', 'foundation' ) , false, true );
    }

    function themeSidebars() {
        register_sidebar( array(
            'name' => __( 'Primary Sidebar', THEME_SLUG ),
            'id' => 'sidebar-primary',
            'description' => __( 'Used throughout the theme.', THEME_SLUG ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ) );

        register_sidebar( array(
            'name' => __( 'Footer Sidebar', THEME_SLUG ),
            'id' => 'sidebar-footer',
            'description' => __( 'Used in the footer of the theme.', THEME_SLUG ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ) );
    }

}

new WPST();
