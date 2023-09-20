// oops-cookie start

document.addEventListener( 'DOMContentLoaded', function ()
{
	let oopsCookieName = 'legal-oops-cookie';

	let oopsCookieClass = 'legal-active';

	function acceptCookie( event )
	{
		setCookie( oopsCookieName, 'accepted' );

		event.currentTarget.parentElement.parentElement.classList.remove( oopsCookieClass );
	}

	document.querySelectorAll( '.legal-oops-cookie-wrapper' ).forEach( function ( wrapper )
	{
		if ( getCookie( oopsCookieName ) === undefined )
		{
			wrapper.querySelectorAll( '.oops-cookie-button' ).forEach( function ( button )
			{
				button.addEventListener( 'click', acceptCookie, false );
			} );

			wrapper.classList.add( oopsCookieClass );
		}
	} );
} );

// oops-cookie end