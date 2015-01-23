<?php

namespace WPCore\MetaBox;

use WPCore\WordPressCore;

if ( ! class_exists( 'MetaBox' ) ) :

class MetaBox
{

    protected $options = array();

    public function __construct( $options )
    {
        if ( ! is_admin() ) {
            return;
        }

        $this->options = array_merge( array(
            'id'            => 'additional_settings_meta_box',
            'title'         => __( 'Additional Settings' ),
            'post_types'    => array( 'post' ),
            'context'       => 'normal',
            'priority'      => 'high',
            'fields'        => array()
        ), (array) $options );

        foreach( $options['fields'] as &$field ) {
            $multiple = in_array( $field[ 'type' ], array( 'checkboxes' ) );

            $field = array_merge( array( 'multiple' => $multiple ), $field );
        }

        $this->set_fields( $options['fields'] );

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

    public function set_title( $title )
    {
        $this->options['title'] = $title;
    }

    public function get_title()
    {
        return $this->options['title'];
    }

    public function set_post_types( $post_types )
    {
        $this->options['post_types'] = $post_types;
    }

    public function get_post_types()
    {
        return $this->options['post_types'];
    }

    public function set_context( $context )
    {
        $this->options['context'] = $context;
    }

    public function get_context()
    {
        return $this->options['context'];
    }

    public function set_priority( $priority )
    {
        $this->options['priority'] = $priority;
    }

    public function get_priority()
    {
        return $this->options['priority'];
    }

    public function set_fields( $fields )
    {
        $this->options['fields'] = $fields;
    }

    public function get_fields()
    {
        return $this->options['fields'];
    }

    protected function field_start( $field_id, $field )
    {
        $output = '<tr valign="top">';
        $output .= '<th scope="row"><label for="' . $field_id . '">' . $field[ 'label' ] . '</label></th>';
        $output .= '<td>';

        return $output;
    }

    protected function field_end( $field_id, $field )
    {
        $output = '';

        if( isset( $field['description'] ) && $field['description'] !== '' ) {
            $output .= '<p class="description">' . $field['description'] . '</p>';
        }

        $output .= '</td>';
        $output .= '</tr>';

        return $output;
    }

    protected function field_text( $field_id, $field, $data )
    {
        $class = ( isset( $field['class'] ) && is_string( $field['class'] ) ) ? $field['class'] : '';

        return '<input name="' . $field_id . '" id="' . $field_id . '" class="' . $class . '" type="text" value="' . $data . '" />';
    }

    protected function field_textarea( $field_id, $field, $data )
    {
        $class = ( isset( $field['class'] ) && is_string( $field['class'] ) ) ? $field['class'] : '';
        $cols = ( isset( $field['cols'] ) && is_int( $field['cols'] ) ) ? $field['cols'] : 50;
        $rows = ( isset( $field['rows'] ) && is_int( $field['rows'] ) ) ? $field['rows'] : 10;

        return '<textarea name="' . $field_id . '" id="' . $field_id . '" class="' . $class . '" cols="' . $cols . '" rows="' . $rows . '">' . $data . '</textarea>';
    }

    protected function field_select( $field_id, $field, $data )
    {
        $class = ( isset( $field['class'] ) && is_string( $field['class'] ) ) ? $field['class'] : '';

        $output = '<select name="' . $field_id . '" id="' . $field_id . '" class="' . $class . '">';

        foreach( (array) $field['options'] as $key => $value ) {
            $output .= '<option value="' . $key . '" ' . selected( $key, $data, false ) . ' >' . $value . '</option>';
        }

        $output .= '</select>';

        return $output;
    }

    protected function field_checkbox( $field_id, $field, $data )
    {
        $class = ( isset( $field['class'] ) && is_string( $field['class'] ) ) ? $field['class'] : '';

        return '<label for="' . $field_id . '"><input name="' . $field_id . '" id="' . $field_id . '" class="' . $class . '" type="checkbox" value="1" ' . checked( ! empty( $data ), true, false ) . ' /> ' . $field['message'] . '</label>';
    }

    protected function field_checkboxes( $field_id, $field, $data )
    {
        $class = ( isset( $field['class'] ) && is_string( $field['class'] ) ) ? $field['class'] : '';

        $output = '';

        foreach( (array) $field['options'] as $key => $value ) {
            $output .= '<div><label for="' . $key . '"><input name="' . $field_id . '[]" id="' . $key . '" class="' . $class . '" type="checkbox" value="' . $key . '" ' . checked( in_array( $key, (array) $data ), true, false ) . ' /> ' . $value . '</label></div>';
        }

        return $output;
    }

    protected function field_radio( $field_id, $field, $data )
    {
        $class = ( isset( $field['class'] ) && is_string( $field['class'] ) ) ? $field['class'] : '';

        $output = '';

        foreach( (array) $field['options'] as $key => $value ) {
            $output .= '<div><label for="' . $key . '"><input name="' . $field_id . '" id="' . $key . '" class="' . $class . '" type="radio" value="' . $key . '" ' . checked( in_array( $key, (array) $data ), true, false ) . ' />' . $value . '</label></div>';
        }

        return $output;
    }

    protected function field_editor( $field_id, $field, $data )
    {
        $field_id = str_replace( '-', '_', strtolower( $field_id ) );

        ob_start();

        wp_editor( html_entity_decode( $data ), $field_id, (array) $field['settings'] );

        return ob_get_clean();
    }

    protected function field_color( $field_id, $field, $data )
    {
        $class = ( isset( $field['class'] ) && is_string( $field['class'] ) ) ? $field['class'] : '';

        return '<input name="' . $field_id . '" id="' . $field_id . '" class="color-picker ' . $class . '" type="text" value="' . $data . '" />';
    }

    protected function field_date( $field_id, $field, $data )
    {
        $class = ( isset( $field[ 'class' ] ) && is_string( $field['class'] ) ) ? $field['class'] : '';
        $format = ( isset( $field[ 'format' ] ) && is_string( $field[ 'format' ] ) ) ? $field['format'] : 'dd-mm-yy';

        return '<input name="' . $field_id . '" id="' . $field_id . '" class="date-picker ' . $class . '" data-format="' . $field[ 'format' ] . '" type="text" value="' . $data . '" />';
    }

    protected function field_file( $field_id, $field, $data )
    {
        $class = ( isset( $field['class'] ) && is_string( $field['class'] ) ) ? $field['class'] : '';

        return '<strong>TODO</strong>';
    }

    public function build_meta_box( $post )
    {
        wp_nonce_field( plugin_basename( __FILE__ ), $this->options['id'] . '_nonce' );

        $output  = '<table class="form-table">';
        $output .= '<tbody>';

        foreach( $this->get_fields() as $field_id => $field ) {
            if ( method_exists( $this, 'field_' . $field['type'] ) ) {
                $multiple = isset( $field['multiple'] ) ? $field['multiple'] : false;
                $data = get_post_meta( $post->ID, $field_id, ! $multiple );

                $output .= $this->field_start( $field_id, $field );

                $output .= call_user_func( array( $this, 'field_' . $field['type'] ), $field_id, $field, $data );

                $output .= $this->field_end( $field_id, $field );
            }
        }

        $output .= '</tbody>';
        $output .= '</table>';

        echo $output;
    }

    public function save( $post_id, $post )
    {
        if ( ! isset( $_POST[ $this->options[ 'id' ] . '_nonce' ] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST[ $this->options[ 'id' ] . '_nonce' ], plugin_basename( __FILE__ ) ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST[ 'post_type' ] ) && 'page' == $_POST[ 'post_type' ] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        foreach( $this->get_fields() as $field_id => $field ) {
            $data = ( isset( $_POST[ $field_id ] ) ) ? $_POST[ $field_id ] : ( ( $field['multiple'] ) ? array() : '' );

            if ( method_exists( $this, 'save_field_' . $field[ 'type' ] ) ) {
                call_user_func( array( $this, 'save_field_' . $field[ 'type' ] ), $field_id, $field, $post_id, $data );
            } else {
                $this->save_field( $field_id, $field, $post_id, $data );
            }
        }
    }

    protected function save_field( $field_id, $field, $post_id, $data )
    {
        delete_post_meta( $post_id, $field_id );

        if( $field[ 'multiple' ] === true ) {
            foreach( $data as $value ) {
                add_post_meta( $post_id, $field_id, $value );
            }
        } else {
            update_post_meta( $post_id, $field_id, $data );
        }
    }

    public function load_field_assets( $page_hook )
    {
        if( ! in_array( $page_hook, array( 'post.php', 'post-new.php' ) ) ) {
            return;
        }

        global $post_type;

        if( ! in_array( $post_type, (array) $this->options['post_types'] ) ) {
            return;
        }

        foreach( (array) $this->get_field_types() as $type ) {
            switch( $type ) {
                case 'color':
                    wp_enqueue_style( 'wp-color-picker' );
                    wp_enqueue_script( 'wp-color-picker' );
                    break;
                case 'date':
                    wp_enqueue_script( 'jquery-ui');
                    wp_enqueue_script( 'jquery-ui-datepicker');
                    break;
            }
        }
    }

    protected function get_field_types()
    {
        $types = array();

        foreach( $this->get_fields() as $field ) {
            $types[] = $field['type'];
        }

        return array_unique( $types );
    }

    public function register()
    {
        foreach( (array) $this->options['post_types'] as $post_type ) {
            add_action( 'add_meta_boxes_' . $post_type, array( $this, 'register_meta_box' ) );
            add_action( 'save_post_' . $post_type, array( $this, 'save' ), 10, 2 );
        }

        add_action( 'admin_enqueue_scripts', array( $this, 'load_field_assets' ) );
    }

    public function register_meta_box( $post )
    {
        add_meta_box( $this->options[ 'id' ], $this->options[ 'title' ], array( $this, 'build_meta_box' ), $post->post_type, $this->options[ 'context' ], $this->options[ 'priority' ] );
    }

}

endif; // Endif class_exists()
