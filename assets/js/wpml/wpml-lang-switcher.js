// wpml-lang-switcher-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function spoilerToggle( event )
    {
        event.currentTarget.classList.toggle( 'legal-active' );

        event.currentTarget.nextElementSibling.classList.toggle( 'legal-active' );
    }

    // const switchers = document.getElementsByClassName( 'lang-switcher' );

    // for ( let switcher of switchers )
    // {
    //     const button = switcher.getElementsByClassName( 'lang-current' ).item( 0 );

    //     button.addEventListener( 'click', spoilerToggle, false );
    // }

    function langPrepare( lang )
    {
        lang.addEventListener( 'click', spoilerToggle, false );
    }

    function spoilerPrepare( switcher )
    {
        switcher.querySelectorAll( '.lang-current').forEach( langPrepare );
    }

    document.querySelectorAll( '.lang-switcher').forEach( spoilerPrepare );

    // document.getElementById( 'thrive-footer' ).addEventListener( 'click', function( event ) {
    //     const switchers = document.getElementsByClassName( 'lang-switcher' );

    //     for ( let switcher of switchers ) {
    //         let button = switcher.getElementsByClassName( 'lang-current' ).item( 0 );

    //         let avaible = button.nextElementSibling;

    //         if ( !avaible.contains( event.target ) && !button.contains( event.target )  ) {
    //             button.classList.remove( 'legal-active' );

    //             avaible.classList.remove( 'legal-active' );
    //         }
    //     }
    // } );

    function toggle( event ) 
    {
        const switchers = document.getElementsByClassName( 'lang-switcher' );

        for ( let switcher of switchers ) {
            let button = switcher.getElementsByClassName( 'lang-current' ).item( 0 );

            let avaible = button.nextElementSibling;

            if ( !avaible.contains( event.target ) && !button.contains( event.target )  ) {
                button.classList.remove( 'legal-active' );

                avaible.classList.remove( 'legal-active' );
            }
        }
    }

    function prepare( element ) {

        element.addEventListener( 'click', toggle );
    }

    document.querySelectorAll( '.legal-footer-wrapper').forEach( prepare );
} );

// wpml-lang-switcher-js