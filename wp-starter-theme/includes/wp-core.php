<?php

// Require the WordPress Core main file
require_once( 'wp-core/WPCore.php' );

// Get instance of the WordPress Core and set some options
$instance = \WPCore\WordPressCore::get_instance();
$instance->set_plugin_prefix( 'wpst_' );

// Load custom added stuff
include_once( 'pages.php' );
include_once( 'custom-post-types.php' );
include_once( 'metaboxes.php' );
include_once( 'taxonomies.php' );
