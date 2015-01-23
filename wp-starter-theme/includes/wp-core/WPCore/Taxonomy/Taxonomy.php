<?php

namespace WPCore\Taxonomy;

use WPCore\WordPressCore;

if ( ! class_exists( 'Taxonomy' ) ) :

class Taxonomy
{

    private $options = array();

    public function __construct( $options )
    {
        if ( ! is_admin() ) {
            return;
        }

        $this->options = array_merge( array(
            'id'          => 'custom_taxonomy',
            'post_types'  => array( 'post' ),
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

    public function set_post_types( $post_types )
    {
        $this->options['post_types'] = $post_types;
    }

    public function get_post_types()
    {
        return $this->options['post_types'];
    }

    public function set_args( $args )
    {
        $this->options['args'] = $args;
    }

    public function get_args()
    {
        return $this->options['args'];
    }

    private function get_taxonomy_name()
    {
        $prefix = WordPressCore::get_plugin_prefix();
        $id = $this->get_id();

        return $prefix . $id;
    }

    public function register()
    {
        add_action( 'init', array( $this, 'register_taxonomy' ) );
    }

    public function register_taxonomy()
    {
        register_taxonomy( $this->get_taxonomy_name(), $this->get_post_types(), $this->get_args() );
    }

}

endif; // Endif class_exists()
