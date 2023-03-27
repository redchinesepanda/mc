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
            
            var val = acf.getField( 'page-translation-group' ).val();

            console.log( 'acf-page-js val: ' + JSON.stringify( val ) );

            $('#acf-field_64213360cf905').select2('data');

            console.log( 'acf-page-js data: ' + JSON.stringify( data ) );
        }
    }
} )( jQuery );

// acf-page-js end