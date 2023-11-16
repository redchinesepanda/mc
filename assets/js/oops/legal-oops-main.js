// oops-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleOops( event )
	{
		let oops = document.querySelector( '.legal-oops-background');

		if ( !oops.contains( event.currentTarget ) || oops == event.target ) {
			event.preventDefault();

			oops.classList.toggle( 'legal-active' );
		}
	}

	document.querySelectorAll( 'a.check-oops[href="#"]').forEach( function ( element ) {
		element.addEventListener( 'click', toggleOops, false );
	} );

	let oops = document.querySelector( '.legal-oops-background');

	if ( oops !== null ) {
		oops.addEventListener( 'click', toggleOops, false );
	}
} );

// oops-js end