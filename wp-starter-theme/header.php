<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div class="content-container">
 *
 * @package WordPress
 * @subpackage WP Starter Theme
 * @since WP Starter Theme 1.0
 */

?><!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />

        <title><?php wp_title( '&rsaquo;', true, 'right' ); ?></title>

        <link rel="icon" type="image/x-icon" href="<?php echo THEME_URI; ?>/images/favicon.ico" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo THEME_URI; ?>/images/favicon.ico" />
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

        <!--[if lt IE 9]><script src="<?php echo THEME_URI_COMPONENTS; ?>/html5shiv/dist/html5shiv.min.js"></script><![endif]-->

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <div class="off-canvas-wrap" data-offcanvas>
            <div class="inner-wrap">
                <aside class="right-off-canvas-menu">
                    <?php
                        wp_nav_menu( array(
                            'theme_location'    => 'primary',
                            'container'         => false,
                            'menu_class'        => 'off-canvas-list',
                            'fallback_cb'       => 'wpst_default_menu_fallback'
                        ) );
                    ?>
                </aside><!-- .right-off-canvas-menu -->

                <div class="page-container">
                    <div class="header-container">
                        <div class="row">
                            <header class="header" role="banner">
                                <h1 class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

                                <a class="responsive-menu-button right-off-canvas-toggle" href="javascript:void(0);"></a>

                                <?php
                                    wp_nav_menu( array(
                                        'theme_location'    => 'primary',
                                        'container'         => 'nav',
                                        'container_class'   => 'primary-navigation',
                                        'fallback_cb'       => 'wpst_default_menu_fallback'
                                    ) );
                                ?>

                                <?php
                                    $sites = wp_get_sites( array( 'public' => 1 ) );

                                    if( ! empty( $sites ) ) :
                                ?>
                                    <div class="toggle">
                                        <?php _e( 'Go to:', THEME_SLUG ); ?>

                                        <?php
                                            foreach( $sites as $site ) :
                                                if( $site['blog_id'] == get_current_blog_id() ) {
                                                    continue;
                                                }

                                                $site_details = get_blog_details( $site['blog_id'] );
                                        ?>
                                            <a href="<?php echo $site_details->siteurl; ?>"><?php echo $site_details->blogname; ?></a>
                                        <?php
                                            endforeach;
                                        ?>
                                    </div>
                                <?php
                                    endif;
                                ?>
                            </header><!-- .header -->
                        </div><!-- .row -->
                    </div><!-- .header-container -->

                    <div class="main-container">
