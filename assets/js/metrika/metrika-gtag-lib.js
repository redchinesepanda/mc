// Google Tag Manager Lib Start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function appendScript( src )
	{
		let script = document.createElement( 'script' );

		script.src = src;
	
		document.head.appendChild( script );
	}

	function gtagLibInit()
	{
		appendScript( 'https://www.googletagmanager.com/gtag/js?id=UA-224707123-1' );
	}

	if ( MetrikaLib.checkCookie() )
	{
		// gtagLibInit();

		MetrikaLib.userInit( gtagLibInit );
	}

	document.addEventListener( LegalCookieOops.oopsCookieHandler, gtagLibInit, { once: true } );
	
} );

// Google Tag Manager Lib End