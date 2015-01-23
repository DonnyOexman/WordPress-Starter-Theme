<?php

// Require the Widget files
require_once( 'widgets/ContentBlockWidget.php' );
require_once( 'widgets/TestimonialsWidget.php' );

// Register the custom widgets
add_action( 'widgets_init', function() {
    register_widget( 'ContentBlockWidget' );
    register_widget( 'TestimonialsWidget' );
} );
