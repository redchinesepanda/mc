// billet-spoiler-js start

document.addEventListener(
    'DOMContentLoaded',
    
    function ()
    {
        function modifyText( event )
        {
            event.target.classList.toggle( 'legal-active' );

            const spoiler = document.getElementById( 'spoiler-' + event.target.dataset.id );

            spoiler.classList.toggle( 'legal-active' );
        }

        const compilations = document.getElementsByClassName( 'legal-compilation' );

        for ( let compilation of compilations ) {
            let spoilers = compilation.getElementsByClassName( 'bonus-spoiler' );

            for ( let spoiler of spoilers ) {
                spoiler.addEventListener( 'click', modifyText, false );
            }
        }
    }
);

// billet-spoiler-js end