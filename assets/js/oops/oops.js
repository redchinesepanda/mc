// oops-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleOops( event )
	{
		event.preventDefault();

		document.querySelector( '.legal-oops-background').classList.toggle( 'legal-active' );
	}

    document.querySelectorAll( 'a[href="#"]').forEach( function ( element ) {
		console.log( element.classList );

		element.addEventListener( 'click', toggleOops, false );
	} );

	document.querySelector( '.legal-oops-background').addEventListener( 'click', toggleOops, false );
} );

// oops-js end