// wpml-lang-switcher-js start

document.addEventListener(
    'DOMContentLoaded',
    
    function ()
    {
        function spoilerToggle( event )
        {
            event.currentTarget.nextElementSibling.classList.toggle( 'legal-active' );
        }

        const switchers = document.getElementsByClassName( 'lang-switcher' );

        for ( let switcher of switchers ) {
            const button = switcher.getElementsByClassName( 'lang-current' ).item( 0 );

            button.addEventListener( 'click', spoilerToggle, false );
        }
        
    }
);

// wpml-lang-switcher-js