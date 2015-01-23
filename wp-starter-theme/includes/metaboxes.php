<?php

use WPCore\MetaBox\MetaBox;


/**
 * Available field types (for now):
 *
 * Text
 * Textarea;            - Possible to config 'rows' and 'cols'
 * Select
 * Checkbox;            - Possible to add a single checkbox or multiple checkboxes
 * Radio
 * WP Editor
 * Colorpicker
 * Datepicker;          - Possible to config date format (e.g. DD-MM-YYYY or YYYY-MM-DD, etc.)
 *
 * Extra:
 * - Possible to add a 'description' to all field types
 */


// Add meta box 'Additional Settings'
$options_additional_settings = array(
    'id'                => 'additional_settings_meta_box',
    'title'             => __( 'Additional Settings' ),
    'post_types'        => array( 'page' ),
    'context'           => 'normal',
    'priority'          => 'high',
    'fields'            => array(
        'text_field'    => array(
            'type'      => 'text',
            'label'     => __( 'Text Field' ),
            'description' => __( 'This field is for testing purposes.' )
        ),
        'text_field_2'    => array(
            'type'      => 'text',
            'label'     => __( 'Text Field #2' )
        ),
        'textarea_field' => array(
            'type'      => 'textarea',
            'label'     => __( 'Textarea' ),
            'cols'      => 50,
            'rows'      => 5,
            'class'     => 'testing1234'
        ),
        'select_field' => array(
            'type' => 'select',
            'label' => __( 'Select Field' ),
            'options' => array(
                'blue' => __( 'Blue' ),
                'green' => __( 'Green' ),
                'yellow' => __( 'Yellow' )
            )
        ),
        'checkbox_field' => array(
            'type' => 'checkbox',
            'label' => __( 'Membership' ),
            'message' => __( 'Would you like to sign up?' )
        )
    )
);

$meta_box = new MetaBox( $options_additional_settings );
