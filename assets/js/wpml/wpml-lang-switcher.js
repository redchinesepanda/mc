// wpml-lang-switcher-js start

document.addEventListener(
    'DOMContentLoaded',
    
    function ()
    {
        function getElement( selector )
        {
            const footer = document.getElementById( 'thrive-footer' );

            const switcher = footer.getElementsByClassName( 'container__menu-in-futter' ).item( 0 );
    
            return switcher.getElementsByClassName( selector ).item( 0 );
        }

        function spoilerToggle( event )
        {
            const spoiler = getElement( 'drop-menu_content_Spoiler' );

            event.currentTarget.classList.toggle( 'legal-active' );

            spoiler.classList.toggle( 'legal-active' );
        }

        const button = getElement( 'drop-menu_content_Spoiler' );

        console.log( 'wpml-lang-switcher-js button: ' + button );

        button.addEventListener( 'click', spoilerToggle, false );
    }
);

// wpml-lang-switcher-js