// oops-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleOops( event )
	{
		event.preventDefault();

		let oops = document.querySelector( '.legal-oops-background');
		
		console.log( 'currentTarget: ' + event.currentTarget );

		console.log( 'currentTarget.classList: ' + event.currentTarget.classList );

		console.log( 'target: ' + event.target );

		console.log( 'target.classList: ' + event.target.classList );

		console.log( 'oops.contains( event.currentTarget ): ' + oops.contains( event.currentTarget ) );

		console.log( 'oops.contains( event.target ): ' + oops.contains( event.target ) );

		if ( !oops.contains( event.currentTarget ) || oops == event.target ) {
			oops.classList.toggle( 'legal-active' );
		}
	}

    document.querySelectorAll( 'a[href="#"]').forEach( function ( element ) {

		element.addEventListener( 'click', toggleOops, false );
	} );

	document.querySelector( '.legal-oops-background').addEventListener( 'click', toggleOops, false );
} );

// oops-js end