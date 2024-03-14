// Google Tag Manager Lib Start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function appendScript( src )
	{
		let script = document.createElement( 'script' );

		script.src = src;
	
		document.head.appendChild( script );
	}

	function gtagInit()
	{
		appendScript( 'https://www.googletagmanager.com/gtag/js?id=UA-224707123-1' );

		MetrikaLib.userSuspend( gtagInit );
	}

	if ( checkCookie() )
	{
		gtagInit();
	}

	document.addEventListener( LegalCookieOops.oopsCookieHandler, gtagInit, { once: true } );
	
} );

// Google Tag Manager Lib End