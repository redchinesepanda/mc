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
            acf.addAction( 'select2_init', function( $select, args, settings, field ) {
                console.log( 'acf-page-js args: ' + JSON.stringify( args ) );

                console.log( 'acf-page-js data: ' +  JSON.stringify( $select.select2('data') ) );

                $select.on("select2:open", function (e) { console.log( 'select2:open ', e); });

                $select.on("select2:close", function (e) { console.log( 'select2:close ', e); });

                $select.on('select2:select', function (e) {
                    var data = e.params.data;

                    console.log( 'select2:select ', e );
                });
            } );

            $("#acf-field_64213360cf905-input")
                .on( 'change', function( e ) { log( 'change ' + JSON.stringify( {val:e.val, added:e.added, removed:e.removed} ) ); } )
        }
    }
} )( jQuery );

// acf-page-js end