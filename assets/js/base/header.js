// header-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleBlock( event )
	{
		let current = event.currentTarget;

		let element = event.target;
		
		if ( current == element ) {
			current.classList.toggle( 'legal-active' );
		}
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