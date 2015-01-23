( function( $, window, document, undefined ) {
    'use strict';

    $( function() {
        if ( $( '.color-picker' ).length ) {
            $( '.color-picker' ).wpColorPicker();
        }

        if ( $( '.date-picker' ).length ) {
            $( '.date-picker' ).each( function() {
                var format = $( this ).data( 'format' );

                $( this ).datepicker( {
                    showButtonPanel: true,
                    dateFormat: format
                } )
            } );
        }
    } );
} )( jQuery, window, document );
