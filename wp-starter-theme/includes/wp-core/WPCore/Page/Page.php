<?php

namespace WPCore\Page;

use WPCore\WordPressCore;

if ( ! class_exists( 'Page' ) ) :

class Page
{

    protected $options = array();

    public function __construct( $options )
    {
        if ( ! is_admin() ) {
            return;
        }

        $this->options = array_merge( array(
            'slug'          => 'custom_settings',
            'title'         => __( 'Custom Settings' ),
            'parent_page'   => false,
            'rights'        => 'manage_options',
            'icon'          => '',
            'position'      => 100,
            'sections'      => array()
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

    public function set_slug( $slug )
    {
        $this->options['slug'] = $slug;
    }

    public function get_slug()
    {
        return $this->options['slug'];
    }

    public function set_title( $title )
    {
        $this->options['title'] = $title;
    }

    public function get_title()
    {
        return $this->options['title'];
    }

    public function set_menu_title( $menu_title )
    {
        $this->options['menu_title'] = $menu_title;
    }

    public function get_menu_title()
    {
        return isset( $this->options['menu_title'] ) ? $this->options['menu_title'] : $this->options['title'];
    }

    public function set_parent_page( $parent_page )
    {
        $this->options['parent_page'] = $parent_page;
    }

    public function get_parent_page()
    {
        return $this->options['parent_page'];
    }

    public function set_rights( $rights )
    {
        $this->options['rights'] = $rights;
    }

    public function get_rights()
    {
        return $this->options['rights'];
    }

    public function set_icon( $icon )
    {
        $this->options['icon'] = $icon;
    }

    public function get_icon()
    {
        return $this->options['icon'];
    }

    public function set_position( $position )
    {
        $this->options['position'] = $position;
    }

    public function get_position()
    {
        return $this->options['position'];
    }

    public function set_sections( $sections )
    {
        $this->options['sections'] = $sections;
    }

    public function get_sections()
    {
        return $this->options['sections'];
    }

    protected function get_field_types()
    {
        $types = array();

        foreach( (array) $this->get_sections() as $key => $section ) {
            foreach( (array) $section['fields'] as $field_id => $field ) {
                $types[$field_id] = $field['type'];
            }
        }

        return $types;
    }

    public function field_text( $args )
    {
        $field = $args['field'];
        $class = ( isset( $field['class'] ) && is_string( $field['class'] ) ) ? $field['class'] : '';

        echo '<input name="' . $this->get_slug() . '[' .$args['field_id'] . ']" id="' . $args['field_id'] . '" class="' . $class . '" type="text" value="' . $args['data'] . '" />';

        if( isset( $args['field']['description'] ) && $args['field']['description'] !== '' ) {
            echo '<p class="description">' . $args['field']['description'] . '</p>';
        }
    }

    public function field_textarea( $args )
    {
        $field = $args['field'];
        $class = ( isset( $field['class'] ) && is_string( $field['class'] ) ) ? $field['class'] : '';
        $cols = ( isset( $field['cols'] ) && is_int( $field['cols'] ) ) ? $field['cols'] : 50;
        $rows = ( isset( $field['rows'] ) && is_int( $field['rows'] ) ) ? $field['rows'] : 10;

        echo '<textarea name="' . $this->get_slug() . '[' .$args['field_id'] . ']" id="' . $args['field_id'] . '" class="' . $class . '" cols="' . $cols . '" rows="' . $rows . '">' . $args['data'] . '</textarea>';

        if( isset( $args['field']['description'] ) && $args['field']['description'] !== '' ) {
            echo '<p class="description">' . $args['field']['description'] . '</p>';
        }
    }

    public function field_select( $args )
    {
        $field = $args['field'];
        $class = ( isset( $field['class'] ) && is_string( $field['class'] ) ) ? $field['class'] : '';

        echo '<select name="' . $this->get_slug() . '[' . $args['field_id'] . ']" id="' . $args['field_id'] . '" class="' . $class . '">';

        foreach( (array) $field['options'] as $key => $value ) {
            echo '<option value="' . $key . '" ' . selected( $key, $args['data'], false ) . ' >' . $value . '</option>';
        }

        echo '</select>';

        if( isset( $args['field']['description'] ) && $args['field']['description'] !== '' ) {
            echo '<p class="description">' . $args['field']['description'] . '</p>';
        }
    }

    public function field_editor( $args )
    {
        $field = $args['field'];
        $class = ( isset( $field['class'] ) && is_string( $field['class'] ) ) ? $field['class'] : '';

        $field_id = str_replace( '-', '_', strtolower( $args['field_id'] ) );

        wp_editor( html_entity_decode( $args['data'] ), $field_id, (array) $field['settings'] );

        if( isset( $args['field']['description'] ) && $args['field']['description'] !== '' ) {
            echo '<p class="description">' . $args['field']['description'] . '</p>';
        }
    }

    public function validate_field( $input )
    {
        $types = $this->get_field_types();

        foreach( $input as $key => $value ) {
            $type = ( isset( $types[$key] ) ) ? $types[$key] : false;

            if ( method_exists( $this, 'validate_field_' . $type ) ) {
                call_user_func( array( $this, 'validate_field_' . $type ), $value );
            }
        }

        return $input;
    }

    public function validate_field_text( $data )
    {
        return wp_filter_nohtml_kses( $data );
    }

    public function build_sections( $section )
    {
        $sections = $this->get_sections();
        $description = ( isset( $sections[$section['id']]['description'] ) ) ? $sections[$section['id']]['description'] : false;

        if( $description !== false ) {
            echo '<p class="description">' . $description . '</p>';
        }
    }

    public function build_page()
    {
    ?>

        <div class="wrap">
            <h2><?php echo $this->get_title(); ?></h2>

            <?php settings_errors(); ?>

            <form action="options.php" method="POST">
                <?php settings_fields( $this->get_slug() . '_group' ); ?>

                <?php do_settings_sections( $this->get_slug() ); ?>

                <?php submit_button(); ?>
            </form>
        </div>

    <?php
    }

    public function register()
    {
        add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
        add_action( 'admin_init', array( $this, 'register_admin_fields' ) );
    }

    public function register_admin_page()
    {
        if( $this->get_parent_page() !== false ) {
            add_submenu_page( $this->get_parent_page(), $this->get_title(), $this->get_menu_title(), $this->get_rights(), $this->get_slug(), array( $this, 'build_page' ) );
        } else {
            add_menu_page( $this->get_title(), $this->get_menu_title(), $this->get_rights(), $this->get_slug(), array( $this, 'build_page' ), $this->get_icon(), $this->get_position() );
        }
    }

    public function register_admin_fields()
    {
        register_setting( $this->get_slug() . '_group', $this->get_slug(), array( $this, 'validate_field' ) );

        $data = get_option( $this->get_slug() );

        foreach( (array) $this->get_sections() as $section_id => $section ) {
            add_settings_section( $section_id, $section['title'], array( $this, 'build_sections' ), $this->get_slug() );

            foreach( $section['fields'] as $field_id => &$field ) {
                $multiple = in_array( $field[ 'type' ], array( 'checkboxes' ) );

                $field = array_merge( array( 'multiple' => $multiple ), $field );

                if ( method_exists( $this, 'field_' . $field['type'] ) ) {
                    $data_field = ( isset( $data[$field_id] ) ) ? $data[$field_id] : '';

                    $args = array(
                        'label_for' => $field_id,
                        'field_id' => $field_id,
                        'field' => $field,
                        'data' => $data_field
                    );

                    add_settings_field( $field_id, $field['label'], array( $this, 'field_' . $field['type'] ), $this->get_slug(), $section_id, $args );
                }
            }
        }
    }

}

endif; // Endif class_exists()
