// oops-cookie start

document.addEventListener( 'DOMContentLoaded', function ()
{
	let oopsCookieName = 'legal-oops-cookie';

	let oopsCookieClass = 'legal-active';

	function acceptCookie( event )
	{
		LegalCookie.setCookie( oopsCookieName, 'accepted', LegalCookie.options );

		event.currentTarget.closest( '.legal-oops-cookie-wrapper' ).classList.remove( oopsCookieClass );
	}

	document.querySelectorAll( '.legal-oops-cookie-wrapper' ).forEach( function ( wrapper )
	{
		if ( LegalCookie.getCookie( oopsCookieName ) === undefined )
		{
			wrapper.querySelectorAll( '.oops-cookie-button' ).forEach( function ( button )
			{
				button.addEventListener( 'click', acceptCookie, false );
			} );

			// wrapper.classList.add( oopsCookieClass );
		}
	} );

	function enableOops( element )
	{
		element.classList.add( oopsCookieClass );
	}

	function enableOopsAll( event )
	{
		document.querySelectorAll( '.legal-oops-cookie-wrapper' ).forEach( enableOops );

		document.removeEventListener( 'mousemove', enableOopsAll, { once: true } );

		document.removeEventListener( 'scroll', enableOopsAll, { once: true } );
	}

	document.addEventListener( 'mousemove', enableOopsAll, { once: true } );

	document.addEventListener( 'scroll', enableOopsAll, { once: true } );
} );

// oops-cookie end