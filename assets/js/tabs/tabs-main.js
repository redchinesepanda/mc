// tabs-main-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function tabToggle( event )
    {
        let tabs = document.getElementById( event.currentTarget.dataset.tabs );

        tabs.querySelectorAll( '.legal-tab-title' ).forEach( ( title ) => {
            title.classList.remove( 'legal-active' );
        });

        tabs.querySelectorAll( '.legal-tab-content' ).forEach( ( content ) => {
            content.classList.remove( 'legal-active' );
        });
        
        event.currentTarget.classList.add( 'legal-active' );

        tabs.querySelector( '.legal-content-' + event.currentTarget.dataset.content ).classList.add( 'legal-active' );
    }

    Array.from( document.getElementsByClassName( 'legal-tabs' ) ).forEach( function callback( tabs, index ) {
        tabs.id = "legal-tabs-" + index;

        let titles = tabs.getElementsByClassName( 'legal-tab-title' );

        for ( let title of titles ) {
            title.dataset.tabs = tabs.id;

            // title.addEventListener( 'click', tabToggle, false );
            title.addEventListener( 'click', function() { tabToggle(); spoilerinit(); }, false );
        }
    });
} );

// tabs-main-js end