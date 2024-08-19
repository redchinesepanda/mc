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

	const selectors = {
		hrefHash: 'a.check-oops[href="#"]',

		hrefDisable: 'a.check-oops[href=""]',

		// thrive: 'a.tcb-button-link[href="#"]'
	}; 

	/* document.querySelectorAll( [ selectors.hrefHash, selectors.thrive ].join( ', ' ) ).forEach( function ( element ) {
		element.addEventListener( 'click', toggleOops, false );
	} ); */

	document.querySelectorAll( [ selectors.hrefHash, selectors.hrefDisable ].join( ', ' ) ).forEach( function ( element ) {
		element.addEventListener( 'click', toggleOops, false );
	} );

	let oops = document.querySelector( '.legal-oops-background');

	if ( oops !== null ) {
		oops.addEventListener( 'click', toggleOops, false );
	}
} );

// oops-js end