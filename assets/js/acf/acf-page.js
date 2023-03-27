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

// 	const pageTranslationGroups = document.querySelector( '.acf-field-select[data-name="page-translation-group"] select' );

//     console.log( 'acf-page-js pageTranslationGroups: ' + pageTranslationGroups );

//     pageTranslationGroups.addEventListener('change', option_changed, false );
// } );

var ACFPage = ( function( $ )
{
    'use strict';

    return {
        run: function ()
        {
            console.log( 'acf-page-js data: ' + $( '.acf-field-select[data-name="page-translation-group"] select' ).select2( 'data' ) );
        }
    }
} )( jQuery );

// acf-page-js end