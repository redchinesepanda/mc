// Review Swiper Lib Start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function swiperInit( el )
	{
		const swiper = new Swiper(el, {
			loop: false,
			slidesPerView: 'auto',
			spaceBetween: 8,
		});

		swiper.on('slideChange', function () {
			// console.log('slide changed');
		});

		swiper.on('reachBeginning', function () {
			// console.log('slide reachBeginning');

			el.classList.add('legal-active-start');
			el.classList.remove('legal-active-end');
		}); 

		swiper.on('reachEnd', function () {
			// console.log('slide reachEnd');

			el.classList.add('legal-active-end');
			el.classList.remove('legal-active-start');
		});
	}

	function swiperInitAll()
	{
		document.querySelectorAll( '.swiper' ).forEach( swiperInit );
	}

	function swiperLibUserInit()
	{
		console.log( 'swiperLibUserInit' );

		MetrikaLib.userInit( swiperInitAll );
	}

	function appendScript( src )
	{
		let script = document.createElement( 'script' );

		script.type = 'text/javascript';

		script.src = src;

		script.onload = swiperLibUserInit;
	
		document.head.appendChild( script );
	}

	function swiperLibInit()
	{
		// appendScript( 'https://www.googletagmanager.com/gtag/js?id=UA-224707123-1' );

		appendScript( mcSwiperLib.src );

		console.log( 'swiperLibInit' );

		console.log( mcSwiperLib.src );
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