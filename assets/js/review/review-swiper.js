// Review Swiper Lib Start

document.addEventListener( 'DOMContentLoaded', function ()
{
	// function swiperLibUserInit()
	// {
	// 	console.log( 'swiperLibUserInit' );

	// 	MetrikaLib.userInit( swiperInitAll );
	// }

	function appendScript( src )
	{
		let script = document.createElement( 'script' );

		script.type = 'text/javascript';

		script.src = src;

		// script.onload = swiperLibUserInit;s
	
		document.head.appendChild( script );
	}

	function swiperLibInit()
	{
		// appendScript( 'https://www.googletagmanager.com/gtag/js?id=UA-224707123-1' );

		appendScript( mcSwiperLib.src );
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