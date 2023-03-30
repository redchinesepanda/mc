// wpml-lang-switcher-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function spoilerToggle( event )
    {
        event.currentTarget.classList.toggle( 'legal-active' );

        event.currentTarget.nextElementSibling.classList.toggle( 'legal-active' );
    }

    const switchers = document.getElementsByClassName( 'lang-switcher' );

    for ( let switcher of switchers ) {
        const button = switcher.getElementsByClassName( 'lang-current' ).item( 0 );

        button.addEventListener( 'click', spoilerToggle, false );
    }

    window.addEventListener( 'click', function( event ) {
        const switchers = document.getElementsByClassName( 'lang-switcher' );

        for ( let switcher of switchers ) {
            let button = switcher.getElementsByClassName( 'lang-current' ).item( 0 );

            let avaible = button.nextElementSibling;

            if ( !avaible.contains( event.target ) && !button.contains( event.target )  ) {
                button.classList.remove( 'legal-active' );
                
                avaible.classList.remove( 'legal-active' );
            }
        }
    } );
} );

// wpml-lang-switcher-js