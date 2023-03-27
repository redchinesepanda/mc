// acf-page-js start

var ACFPage = ( function( $ )
{
    'use strict';

    return {
        run: function ()
        {
            acf.addAction( 'select2_init', function( $select, args, settings, field ) {
                $select.on('select2:clear', function (e) {
                    var data = e.params.data;

                    // console.log( 'select2:clear e ', e );

                    console.log( 'select2:select data ', data );
                    
                    $( '#post_search' ).val( '' );

                    $( '#assign_to_trid' ).val( '' );
                } );

                $select.on('select2:select', function (e) {
                    var data = e.params.data;
                    
                    console.log( 'select2:select data ', data );

                    $( '#icl_document_connect_translations_dropdown' ).on( 'click', { text : data.text, id : data.id }, ACFPage.connect );
                } );
            } );
        },
        
        connect: function ( event ) {
            $( '#post_search' ).val( event.data.text );

            $( '#assign_to_trid' ).val( event.data.id );
        }
    }
} )( jQuery );

// acf-page-js end