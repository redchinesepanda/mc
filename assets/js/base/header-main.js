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

		let tagBody = document.querySelector('body');

		let headerControl = document.querySelector('.legal-header-control');

		if ( element == element.closest( headerControl ) ) {
			tagBody.classList.toggle( classes.active );
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

	// Для активации кнопки кукки   начало
/* 	let cookieButton = document.querySelector('.oops-cookie-button');
	let containerCookieButton = document.querySelector('.legal-oops-cookie-wrapper');

	cookieButton.addEventListener('click', () => {
		containerCookieButton.classList.toggle('legal-active');
	}); */

	// Для активации кнопки кукки  конец

	/* let headerControl = document.querySelector('.legal-header-control');
	let tagBody = document.querySelector('body');

	headerControl.addEventListener('click', () => {
		tagBody.classList.toggle('legal-active');
	}); */

	toggleInit();

	window.addEventListener( 'resize', toggleInit, false );
} );

// header-main-js end