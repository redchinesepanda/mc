// header-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleBlock( event )
	{
		let element = event.currentTarget;

		element.classList.toggle( 'legal-active' );
	}

    function toggleLink( event )
	{
		let element = event.target;

		if ( element.hasAttribute( 'href' ) ) {

			if ( !element.parentElement.classList.contains( 'legal-active' ) ) {
				event.preventDefault();
			}
		}
	}

	function toggleInit() {
		// console.log( 'matchMedia: ' + window.matchMedia( '( max-width: 768px )' ).matches );
		
		if ( window.matchMedia( '( max-width: 768px )' ).matches ) {
			document.querySelectorAll( '.legal-menu .menu-item' ).forEach( function ( element ) {
				element.addEventListener( 'click', toggleBlock, false );
			} );
		
			document.querySelectorAll( '.legal-menu .menu-item > a' ).forEach( function ( element ) {
				element.addEventListener( 'click', toggleLink, false );
			} );
		
			document.querySelectorAll( '.legal-header-control' ).forEach( function ( element ) {
				element.addEventListener( 'click', toggleBlock, false );
			} );
		} else {
			document.querySelectorAll( '.legal-menu .menu-item' ).forEach( function ( element ) {
				element.removeEventListener( 'click', toggleBlock, false );
			} );
		
			document.querySelectorAll( '.legal-menu .menu-item > a' ).forEach( function ( element ) {
				element.removeEventListener( 'click', toggleLink, false );
			} );
		
			document.querySelectorAll( '.legal-header-control' ).forEach( function ( element ) {
				element.removeEventListener( 'click', toggleBlock, false );
			} );
		}
	}

	toggleInit();

	document.addEventListener( 'resize', toggleInit, false );

    // document.querySelectorAll( '.legal-menu .menu-item' ).forEach( function ( element ) {
	// 	element.addEventListener( 'click', toggleBlock, false );
	// } );

    // document.querySelectorAll( '.legal-menu .menu-item > a' ).forEach( function ( element ) {
	// 	element.addEventListener( 'click', toggleLink, false );
	// } );

    // document.querySelectorAll( '.legal-header-control' ).forEach( function ( element ) {
	// 	element.addEventListener( 'click', toggleBlock, false );
	// } ); 
} );

// header-js end