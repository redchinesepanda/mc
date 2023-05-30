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

	const args = [
		{
			'selector' : '.legal-menu .menu-item',

			'event' : 'click',

			'function' : 'toggleBlock'
		},

		{
			'selector' : '.legal-menu .menu-item > a',

			'event' : 'click',

			'function' : 'toggleLink'
		},

		{
			'selector' : '.legal-header-control',

			'event' : 'click',

			'function' : 'toggleBlock'
		}
	];

	function toggleInit() {
		// console.log( 'matchMedia: ' + window.matchMedia( '( max-width: 768px )' ).matches );

		if ( window.matchMedia( '( max-width: 768px )' ).matches ) {
			args.forEach( function ( arg ) {
				document.querySelectorAll( arg.selector ).forEach( function ( element ) {
					element.addEventListener( arg.event, arg.function, false );
				} );
			} );
			
			// document.querySelectorAll( '.legal-menu .menu-item' ).forEach( function ( element ) {
			// 	element.addEventListener( 'click', toggleBlock, false );
			// } );
		
			// document.querySelectorAll( '.legal-menu .menu-item > a' ).forEach( function ( element ) {
			// 	element.addEventListener( 'click', toggleLink, false );
			// } );
		
			// document.querySelectorAll( '.legal-header-control' ).forEach( function ( element ) {
			// 	element.addEventListener( 'click', toggleBlock, false );
			// } );
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

	window.addEventListener( 'resize', toggleInit, false );

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