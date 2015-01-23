<?php

use WPCore\Page\Page;


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
 * File upload (WiP)
 *
 * Extra:
 * - Possible to add a 'description' to all field types
 */


// Add page 'Custom Settings'
$options_custom_settings = array(
    'slug' => 'custom_settings_page',
    'title' => __( 'Custom Settings', THEME_SLUG ),
    'icon' => 'dashicons-admin-generic',
    'position' => 999,
    'sections' => array(
        'section_social_media' => array(
            'title' => __( 'Social Media' ),
            'description' => __( 'Will be used throughout the website..' ),
            'fields' => array(
                'social_facebook'    => array(
                    'type'      => 'text',
                    'label'     => __( 'Facebook URL' ),
                    'description' => __( 'Full URL, e.g. https://www.facebook.com/WPStarterTheme' )
                ),
                'social_twitter'  => array(
                    'type'      => 'text',
                    'label'     => __( 'Twitter Account' ),
                    'description' => __( 'Twitter account, e.g. WPStarterTheme' )
                ),
                'social_youtube'  => array(
                    'type'      => 'text',
                    'label'     => __( 'YouTube Account' ),
                    'description' => __( 'YouTube account, e.g. WPStarterTheme' )
                ),
                'social_vimeo'  => array(
                    'type'      => 'text',
                    'label'     => __( 'Vimeo Account' ),
                    'description' => __( 'Vimeo account, e.g. WPStarterTheme' )
                ),
            ),
        ),
        'section_example' => array(
            'title' => __( 'Section Example' ),
            'description' => __( 'This is just an example of another section.' ),
            'fields' => array()
        ),
    )
);

new Page( $options_custom_settings );
