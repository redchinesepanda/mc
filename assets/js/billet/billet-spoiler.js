// billet-spoiler-js start

document.addEventListener(
    'DOMContentLoaded',
    
    function ()
    {
        function spoilerToggle( event )
        {
            event.target.classList.toggle( 'legal-active' );

            const spoiler = compilation.querySelector( '.spoiler-' + event.target.dataset.id );

            spoiler.classList.toggle( 'legal-active' );
        }

        const compilations = document.getElementsByClassName( 'legal-compilation' );

        for ( let compilation of compilations ) {
            let spoilers = compilation.getElementsByClassName( 'bonus-spoiler' );

            for ( let spoiler of spoilers ) {
                spoiler.addEventListener( 'click', spoilerToggle, false );
            }
        }
    }
);

// billet-spoiler-js end