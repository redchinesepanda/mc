// billet-spoiler-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function spoilerToggle( event )
    {
        event.currentTarget.classList.toggle( 'legal-active' );

        const billet = document.getElementById( 'billet-' + event.currentTarget.dataset.id );
        
        billet.nextElementSibling.classList.toggle( 'legal-active' );
    }

    const compilations = document.getElementsByClassName( 'legal-compilation' );

    for ( let compilation of compilations ) {
        let spoilers = compilation.getElementsByClassName( 'bonus-spoiler' );

        for ( let spoiler of spoilers ) {
            spoiler.addEventListener( 'click', spoilerToggle, false );
        }
    }
} );

// billet-spoiler-js end