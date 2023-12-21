// header-open-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleLink( event )
	{
		let element = event.target;

		if ( element.hasAttribute( attrs.href ) ) {

			if ( !element.parentElement.classList.contains( classes.active ) )
			{
				event.preventDefault();
			}
		}
	}

	const attrs = {
		href: 'href'
	};

	const classes = {
		active: 'legal-active',

		item: 'menu-item',
		
		menu: 'legal-menu'
	};

	const args = [
		{
			'selector' : '.legal-menu .menu-item-has-children > a',

			'event' : 'click',

			'action' : toggleLink
		},

		{
			'selector' : '.footer-menu .menu-item-has-children > a',

			'event' : 'click',

			'action' : toggleLink
		},
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

// header-open-js end