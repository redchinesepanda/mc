// wpml-lang-switcher-js start

document.addEventListener(
    'DOMContentLoaded',
    
    function ()
    {
        function spoilerToggle( event )
        {
            event.currentTarget.classList.toggle( 'legal-active' );

            event.currentTarget.dataset.spoiler.classList.toggle( 'legal-active' );
        }

        const footer = document.getElementById( 'thrive-footer' );

        const switcher = footer.getElementsByClassName( 'container__menu-in-futter' ).item( 0 );

        const spoiler = switcher.getElementsByClassName( 'drop-menu_content_Spoiler' ).item( 0 );

        const button = switcher.getElementsByClassName( 'buttton-country-whis-flag' ).item( 0 );

        button.dataset.spoiler = spoiler;

        button.addEventListener( 'click', spoilerToggle, false );
    }
);

// wpml-lang-switcher-js