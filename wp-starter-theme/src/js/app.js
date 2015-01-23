( function( $, window, document, undefined ) {
    'use strict';

    $( function() {
        var primaryMenu = $( '.primary-navigation' );

        // Submenu functionality
        if ( $( primaryMenu ).is( ':visible' ) ) {
            $( '.menu > .menu-item-has-children', primaryMenu ).mouseenter( function() {
                $( '> .sub-menu', this ).fadeIn( 'fast' );
            } ).mouseleave( function() {
                $( '> .sub-menu', this ).hide();
            } );
        }

        // Placeholders
        $( 'input, textarea' ).placeholder();
    } );

    // Initialize Foundation framework
    $( document ).foundation();
} )( jQuery, window, document );
