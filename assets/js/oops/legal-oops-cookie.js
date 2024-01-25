// oops-cookie start

document.addEventListener( 'DOMContentLoaded', function ()
{
	const cookies = {
		oopsAge: 'legal-oops-age',

		oopsCookie: 'legal-oops-cookie'
	};

	// let oopsCookieName = 'legal-oops-cookie';

	// let oopsCookieClass = 'legal-active';

	const selectors = {
		cookieWrapper: '.legal-oops-cookie-wrapper',

		cookieButton: '.oops-cookie-button',

		ageWrapper: '.legal-oops-age-wrapper',

		ageButtonYes: '.age-button-yes-link'
	};

	function acceptCookie( event )
	{
		LegalCookie.setCookie( cookies.oopsCookie, 'accepted', LegalCookie.options );

		event.currentTarget.closest( selectors.cookieWrapper ).classList.remove( oopsCookieClass );
	}

	// document.querySelectorAll( selectors.cookieWrapper ).forEach( function ( wrapper )

	function oopsInit( wrapper, cookie, selector )
	{
		if ( LegalCookie.getCookie( cookie ) === undefined )
		{
			wrapper.querySelectorAll( selector ).forEach( function ( button )
			{
				button.addEventListener( 'click', acceptCookie, false );
			} );

			// wrapper.classList.add( oopsCookieClass );
		}
	}
	
	document.querySelectorAll( selectors.cookieWrapper ).forEach( function ( wrapper )
	{
		// if ( LegalCookie.getCookie( cookies.oopsCookie ) === undefined )
		// {
		// 	wrapper.querySelectorAll( selectors.cookieButton ).forEach( function ( button )
		// 	{
		// 		button.addEventListener( 'click', acceptCookie, false );
		// 	} );

		// 	// wrapper.classList.add( oopsCookieClass );
		// }

		oopsInit( wrapper, cookies.oopsCookie, selectors.cookieButton );
	} );

	document.querySelectorAll( selectors.ageWrapper ).forEach( function ( wrapper )
	{
		oopsInit( wrapper, cookies.ageCookie, selectors.ageButtonYes );
	} );

	const classes = {
		active: 'legal-active'
	};

	function enableOops( element )
	{
		element.classList.add( classes.active );
	}

	const events = {
		mousemove: 'mousemove',

		scroll: 'scroll',

		click: 'click'
	};

	function enableOopsAll( event )
	{
		document.querySelectorAll( [ selectors.cookieWrapper, selectors.ageWrapper ].join( ', ' ) ).forEach( enableOops );

		// document.removeEventListener( 'mousemove', enableOopsAll, { once: true } );

		// document.removeEventListener( 'scroll', enableOopsAll, { once: true } );

		for ( const [ key, value ] of Object.entries( events ) )
		{
			document.removeEventListener( value, enableOopsAll, { once: true } );
		}
	}

	for ( const [ key, value ] of Object.entries( events ) )
	{
		// console.log(`${key}: ${value}`);

		document.addEventListener( value, enableOopsAll, { once: true } );
	}

	// document.addEventListener( 'mousemove', enableOopsAll, { once: true } );

	// document.addEventListener( 'scroll', enableOopsAll, { once: true } );
} );

// oops-cookie end