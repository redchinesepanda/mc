// acf-page-js start

document.addEventListener('DOMContentLoaded', function()
{
    function option_changed( event )
    {
        const value = event.currentTarget.value;

        console.log( 'acf-page-js value: ' + value );

        const text = event.currentTarget.options[ event.currentTarget.selectedIndex ].text;

        console.log( 'acf-page-js text: ' + text );
    }

	const pageTranslationGroups = document.querySelector( '.acf-field-select[data-name="page-translation-group"]' );

    console.log( 'acf-page-js pageTranslationGroups: ' + pageTranslationGroups );

    pageTranslationGroups.addEventListener('change', option_changed, false );
} );

// acf-page-js end