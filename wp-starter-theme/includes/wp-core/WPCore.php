<?php

namespace WPCore;


require_once( THEME_DIR_INCLUDES . '/wp-core/UniversalClassLoader.php' );

if ( ! class_exists( 'WordPressCore' ) ) :

class WordPressCore
{

    private static $instance;
    private static $prefix = '';
    private $version = '0.1';

    /**
     * Constructor.
     */
    private function __construct()
    {
        $autoLoader = new \WPCore\UniversalClassLoader();
        $autoLoader->registerNamespace( __NAMESPACE__, __DIR__ );
        $autoLoader->register();

        add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
    }

    public function load_assets()
    {
        wp_enqueue_style( 'wp-core-css', THEME_DIR_INCLUDES . '/wp-core/WPCore/Resources/wp-core.css' );

        wp_enqueue_style( 'jquery-ui', THEME_DIR_INCLUDES . '/wp-core/WPCore/Resources/jquery-ui/jquery-ui.css' );

        wp_enqueue_script( 'wp-core-js', THEME_DIR_INCLUDES . '/wp-core/WPCore/Resources/wp-core.js', array( 'jquery', 'wp-color-picker' ), false, true );
    }

    /**
     * Set the plugin prefix, used when creating post types, taxonomies, metaboxes, etc.
     * @param string $prefix The prefix.
     */
    public static function set_plugin_prefix( $prefix )
    {
        self::$prefix = $prefix; // TODO check of laatste char _ is.
    }

    /**
     * Get the plugin prefix, used when creating post types, taxonomies, metaboxes, etc.
     * @return string The prefix.
     */
    public static function get_plugin_prefix()
    {
        return self::$prefix;
    }

    /**
     * Set the plugin version.
     * @param string $version The version.
     */
    public function set_version($version)
    {
        $this->version = $version;
    }

    /**
     * Get the plugin version.
     * @return string The version.
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Get the current instance. Singleton method.
     * @return Object Instance from called class.
     */
    public static function get_instance()
    {
        if( ! isset( self::$instance ) ) {
            $class = __CLASS__;
            self::$instance = new $class;
        }

        return self::$instance;
    }

}

WordPressCore::get_instance();

endif; // Endif class_exists()

?>
