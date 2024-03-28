// header-main-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleBlock( event )
	{
		// if ( window.matchMedia( '( max-width: 1209px )' ).matches )
		// {
		// 	event.preventDefaults();
		// }

		let current = event.currentTarget;

		let element = event.target;
		
		if ( current == element ) {
			current.classList.toggle( classes.active );
		} 

	}

    // function toggleLink( event )
	// {
	// 	let element = event.target;

	// 	if ( element.hasAttribute( attrs.href ) ) {

	// 		if ( !element.parentElement.classList.contains( classes.active ) )
	// 		{
	// 			event.preventDefault();
	// 		}
	// 	}
	// }

	// const attrs = {
	// 	href: 'href'
	// };

	const classes = {
		active: 'legal-active',

		item: 'menu-item',
		
		menu: 'legal-menu'
	};

	const args = [
		{
			'selector' : '.legal-menu .menu-item-has-children',

			'event' : 'click',

			'action' : toggleBlock
		},

		{
			'selector' : '.legal-header-control',

			'event' : 'click',

			'action' : toggleBlock
		},

		{
			'selector' : '.footer-menu .menu-item-has-children',

			'event' : 'click',

			'action' : toggleBlock
		},

		{
			'selector' : '.tcb-post-content table:not( .legal-raw-rawspan ):not( .legal-check ) tr *:first-child',

			'event' : 'click',

			'action' : toggleBlock
		}
	];

	const selectors = {
		headerControl: '.legal-header-control',

		tagBody: 'body'
	};

	function toggleInit()
	{
		if ( window.matchMedia( '( max-width: 1209px )' ).matches ) {
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

	// Для активации скрытия контента при раскрытии гамбургера. Начало
	function toggleBody() {
		document.querySelector( selectors.headerControl ).addEventListener('click', () => {
			document.querySelector( selectors.tagBody ).classList.toggle( classes.active );
		});
	};
	
	toggleBody()
	// Для активации скрытия контента при раскрытии гамбургера. Конец

	toggleInit();

	window.addEventListener( 'resize', toggleInit, false );
} );

// header-main-js end