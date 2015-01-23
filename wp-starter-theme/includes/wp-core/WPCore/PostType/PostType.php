<?php

namespace WPCore\PostType;

use WPCore\WordPressCore;

if ( ! class_exists( 'PostType' ) ) :

class PostType
{

    private $options = array();

    public function __construct( $options )
    {
        if ( ! is_admin() ) {
            return;
        }

        $this->options = array_merge( array(
            'id'          => 'custom_post_type',
            'args'        => array()
        ), (array) $options );

        $this->register();
    }

    public function set_options( $options )
    {
        $this->options = $options;
    }

    public function get_options()
    {
        return $this->options;
    }

    public function set_id( $id )
    {
        $this->options['id'] = $id;
    }

    public function get_id()
    {
        return $this->options['id'];
    }

    public function set_args( $args )
    {
        $this->options['args'] = $args;
    }

    public function get_args()
    {
        return $this->options['args'];
    }

    private function get_post_type_name()
    {
        $prefix = WordPressCore::get_plugin_prefix();
        $id = $this->get_id();

        return $prefix . $id;
    }

    public function register()
    {
        add_action( 'init', array( $this, 'register_post_type' ) );
    }

    public function register_post_type()
    {
        register_post_type( $this->get_post_type_name(), $this->get_args() );
    }

}

endif; // Endif class_exists()
