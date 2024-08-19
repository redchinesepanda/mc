// oops-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	const selectors = {
		hrefHash: 'a.check-oops[href="#"]',

		hrefDisable: 'a.check-oops[href=""]',

		// thrive: 'a.tcb-button-link[href="#"]'

		background: '.legal-oops-background',

		iconClose: 'oops-tooltip-close',
	};

	let oops = document.querySelector( selectors.background );

	let checkClose = document.querySelector( selectors.iconClose );

    function toggleOops( event )
	{
		// let oops = document.querySelector( selectors.background );

		// let checkClose = document.querySelector( selectors.iconClose );
		console.log( checkClose );

		if ( !oops.contains( event.currentTarget ) || oops == event.target ) {
			event.preventDefault();

			oops.classList.toggle( 'legal-active' );

		} else if ( checkClose == event.target ) {
			event.preventDefault();

			oops.classList.remove( 'legal-active' );
		};
	}

	/* document.querySelectorAll( [ selectors.hrefHash, selectors.thrive ].join( ', ' ) ).forEach( function ( element ) {
		element.addEventListener( 'click', toggleOops, false );
	} ); */

	document.querySelectorAll( [ selectors.hrefHash, selectors.hrefDisable ].join( ', ' ) ).forEach( function ( element ) {
		element.addEventListener( 'click', toggleOops, false );
	} );

	// let oops = document.querySelector( selectors.background );

	if ( oops !== null ) {
		oops.addEventListener( 'click', toggleOops, false );
	}

	if ( checkClose !== null ) {
		oops.addEventListener( 'click', toggleOops, false );
	}
} );

// oops-js end