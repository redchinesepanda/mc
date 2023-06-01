// header-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleBlock( event )
	{

		let current = event.currentTarget;

		console.log( 'toggleBlock ' + 'current.id: ' + current.id );

		// console.log( 'current.id: ' + current.id + ' | current.classList: ' + current.classList );
		
		current.classList.toggle( 'legal-active' );
		
		// console.log( 'current.id: ' + current.id + ' | current.classList: ' + current.classList );

		let element = event.target;

		console.log( 'toggleBlock ' + 'element.id: ' + element.id );

		// console.log( 'element.id: ' + element.id + ' | element.classList: ' + element.classList );

		// element.classList.toggle( 'legal-active' );

		// console.log( 'element.id: ' + element.id + ' | element.classList: ' + element.classList );
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
			// 'selector' : '.legal-menu .menu-item',
			
			'selector' : '.legal-menu .menu-item-has-children',

			'event' : 'click',

			'action' : toggleBlock
		},

		{
			// 'selector' : '.legal-menu .menu-item > a',
			
			'selector' : '.legal-menu .menu-item-has-children > a',

			'event' : 'click',

			'action' : toggleLink
		},

		{
			'selector' : '.legal-header-control',

			'event' : 'click',

			'action' : toggleBlock
		}
	];

	function toggleInit()
	{
		if ( window.matchMedia( '( max-width: 768px )' ).matches ) {
			args.forEach( function ( arg ) {
				document.querySelectorAll( arg.selector ).forEach( function ( element ) {
					element.addEventListener( arg.event, arg.action, false );
				} );
			} );
		} else {
			args.forEach( function ( arg ) {
				document.querySelectorAll( arg.selector ).forEach( function ( element ) {
					element.removeEventListener( arg.event, arg.action, false );
				} );
			} );
		}
	}

	toggleInit();

	window.addEventListener( 'resize', toggleInit, false );
} );

// header-js end