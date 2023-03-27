// acf-page-js start

// document.addEventListener('DOMContentLoaded', function()
// {
//     function option_changed( event )
//     {
//         const value = event.currentTarget.value;

//         console.log( 'acf-page-js value: ' + value );

//         const text = event.currentTarget.options[ event.currentTarget.selectedIndex ].text;

//         console.log( 'acf-page-js text: ' + text );
//     }

//     const field = acf.getField( 'page-translation-group' );

// 	// const pageTranslationGroups = document.querySelector( '.acf-field-select[data-name="page-translation-group"] select' );

//     console.log( 'acf-page-js data: ' + field.select2('data') );

//     // pageTranslationGroups.addEventListener('change', option_changed, false );
// } );

var ACFPage = ( function( $ )
{
    'use strict';

    return {
        run: function ()
        {
            // const field = acf.getField( 'page-translation-group' );
            
            // var val = ( val = acf.getFields( { name : 'page-translation-group' } ).shift() ) ? val.val() : '';
            
            // var val = acf.getField( 'page-translation-group' ).val();

            // console.log( 'acf-page-js val: ' + JSON.stringify( val ) );

            // $( '#acf-field_64213360cf905-input' ).select2('data');

            // console.log( 'acf-page-js data: ' + JSON.stringify( data ) );

            acf.addAction( 'select2_init', function( $select, args, settings, field ) {
                // $select (jQuery) select element
                // args (object) args given to the select2 function
                // settings (object) settings given to the acf.select2 function
                // field (object) field instance 

                // console.log( 'acf-page-js $select: ' + JSON.stringify( $select ) );

                console.log( 'acf-page-js args: ' + JSON.stringify( args ) );

                // console.log( 'acf-page-js settings: ' + JSON.stringify( settings ) );

                // console.log( 'acf-page-js field: ' + JSON.stringify( field ) );

                console.log( 'acf-page-js data: ' +  JSON.stringify( $select.select2('data') ) );

                $select.on( 'change', function ( e ) {
                    var data = e.params.data;

                    console.log( 'acf-page-js data: ' + JSON.stringify( data ) );
                } );

                // $select
                //     .on( 'change', function( e ) { console.log( 'change ' + JSON.stringify( { val : e.val, added : e.added, removed : e.removed} ) ); } );

                // field
                //     .on( 'change', function( e ) { console.log( 'change ' + JSON.stringify( { val : e.val, added : e.added, removed : e.removed} ) ); } );
            } );

            $("#acf-field_64213360cf905-input")
                .on( 'change', function( e ) { log( 'change ' + JSON.stringify( {val:e.val, added:e.added, removed:e.removed} ) ); } )
        }
    }
} )( jQuery );

// acf-page-js end