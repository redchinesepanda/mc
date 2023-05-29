// header-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleBlock( event )
	{
		let element = event.currentTarget;

		if ( !element.classList.contains( 'legal-active' ) ) {
			event.preventDefault();
		}

		element.classList.toggle( 'legal-active' );

		// let oops = document.querySelector( '.legal-oops-background');

		// if ( !oops.contains( event.currentTarget ) || oops == event.target ) {
			
		// }
	}

    document.querySelectorAll( '.legal-menu .menu-item').forEach( function ( element ) {
		element.addEventListener( 'click', toggleBlock, false );
	} );

	// let oops = document.querySelector( '.legal-oops-background');

	// if ( oops !== null ) {
	// 	oops.addEventListener( 'click', toggleBlock, false );
	// }
} );

// header-js end