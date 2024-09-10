// Review Swiper Lib Start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function appendScript( src )
	{
		let script = document.createElement( 'script' );

		script.src = src;
	
		document.head.appendChild( script );
	}

	function swiperLibInit()
	{
		// appendScript( 'https://www.googletagmanager.com/gtag/js?id=UA-224707123-1' );

		appendScript( '/assets/js/review/swiper-bundle.min.js' );
	}

	// if ( MetrikaLib.checkCookie() )
	// {
	// 	// gtagLibInit();

	// 	MetrikaLib.userInit( gtagLibInit );
	// }

	MetrikaLib.userInit( swiperLibInit );

	// document.addEventListener( LegalCookieOops.oopsCookieHandler, gtagLibInit, { once: true } );
	
} );

// Review Swiper Lib Start