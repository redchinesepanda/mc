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

            acf.add_filter('select2_args', function( args, $select, settings, a ){
    
                var selectId = $select.attr('id');
            
                // this is what we need to bind the event to select2:

                var $input = $('input#'+selectId+'-input');

                $input.on( 'select2-selected', function (e) { 
                  console.log( 'selected', e );
                });
            
                // return
                
                return args;
                    
              });
        }
    }
} )( jQuery );

// acf-page-js end