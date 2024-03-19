// oops-age start

document.addEventListener( 'DOMContentLoaded', function ()
{
	let oopsCookieName = 'legal-oops-age';

	let oopsCookieClass = 'legal-active';

	function acceptCookie( event )
	{
		LegalCookie.setCookie( oopsCookieName, 'accepted', LegalCookie.options );

		event.currentTarget.closest( '.legal-oops-age-wrapper' ).classList.remove( oopsCookieClass );
	}

	document.querySelectorAll( '.legal-oops-age-wrapper' ).forEach( function ( wrapper )
	{
		if ( LegalCookie.getCookie( oopsCookieName ) === undefined )
		{
			wrapper.querySelectorAll( '.age-button-yes-link' ).forEach( function ( button )
			{
				button.addEventListener( 'click', acceptCookie, false );
			} );

			wrapper.classList.add( oopsCookieClass );
		}
	} );
} );

// oops-cookie age