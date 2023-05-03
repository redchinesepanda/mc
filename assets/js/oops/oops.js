// oops-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleOops( event )
	{
		event.preventDefault();

		let oops = document.querySelector( '.legal-oops-background');

		if ( !oops.contains( event.target )  ) {
			console.log( event.currentTarget.classList );

			oops.classList.toggle( 'legal-active' );
		}
	}

    document.querySelectorAll( 'a[href="#"]').forEach( function ( element ) {

		element.addEventListener( 'click', toggleOops, false );
	} );

	document.querySelector( '.legal-oops-background').addEventListener( 'click', toggleOops, false );
} );

// oops-js end