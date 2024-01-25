// oops-cookie start

document.addEventListener( 'DOMContentLoaded', function ()
{
	const selectors = {
		cookieWrapper: '.legal-oops-cookie-wrapper',

		cookieButton: '.oops-cookie-button',

		ageWrapper: '.legal-oops-age-wrapper',

		ageButtonYes: '.age-button-yes-link'
	};

	function acceptCookie( event )
	{
		console.log( 'acceptCookie' );

		console.log( this ); 

		LegalCookie.setCookie( cookie, 'accepted', LegalCookie.options );

		event.currentTarget.closest( selectors.cookieWrapper ).classList.remove( oopsCookieClass );
	}

	function prepareAccept( button )
	{
		button.addEventListener( 'click', acceptCookie, false );
	}

	function oopsInit( wrapper, cookie, selector )
	{
		console.log( 'oopsInit' );

		console.log( LegalCookie.getCookie( cookie ) );

		if ( LegalCookie.getCookie( cookie ) === undefined )
		{
			wrapper.querySelectorAll( selector ).forEach( prepareAccept, {
				cookie: cookie,

				wrapper: wrapper
			} );
		}
		else
		{
			wrapper.classList.add( classes.active );
		}
	}
	
	const cookies = {
		oopsAge: 'legal-oops-age',

		oopsCookie: 'legal-oops-cookie'
	};

	document.querySelectorAll( selectors.cookieWrapper ).forEach( function ( wrapper )
	{
		oopsInit( wrapper, cookies.oopsCookie, selectors.cookieButton );
	} );

	document.querySelectorAll( selectors.ageWrapper ).forEach( function ( wrapper )
	{
		oopsInit( wrapper, cookies.oopsAge, selectors.ageButtonYes );
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

		for ( const [ key, value ] of Object.entries( events ) )
		{
			document.removeEventListener( value, enableOopsAll, { once: true } );
		}
	}

	for ( const [ key, value ] of Object.entries( events ) )
	{
		document.addEventListener( value, enableOopsAll, { once: true } );
	}
} );

// oops-cookie end