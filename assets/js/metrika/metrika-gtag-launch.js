// Google Tag Manager run start

// window.dataLayer = window.dataLayer || [];
// function gtag(){dataLayer.push(arguments);}
// gtag('js', new Date());
// gtag('config', 'UA-224707123-1');

document.addEventListener( 'DOMContentLoaded', function ()
{
	function gtagRunInit()
	{
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-224707123-1');
	}

	if ( MetrikaLib.checkCookie() )
	{
		// gtagRunInit();

		MetrikaLib.userInit( gtagRunInit );
	}

	document.addEventListener( LegalCookieOops.oopsCookieHandler, gtagRunInit, { once: true } );
	
} );

// Google Tag Manager run start