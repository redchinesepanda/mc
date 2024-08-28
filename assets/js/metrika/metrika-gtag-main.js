// Google Tag Manager start

// (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
// new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
// j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
// 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
// })(window,document,'script','dataLayer','GTM-PW5JXP9');

document.addEventListener( 'DOMContentLoaded', function ()
{
	function gtmInit()
	{
		(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-PW5JXP9');

		// userSuspend();

		// MetrikaLib.userSuspend( gtmInit );
	}

	if ( MetrikaLib.checkCookie() )
	{
		// gtmInit();

		MetrikaLib.userInit( gtmInit );
	}
	
	document.addEventListener( LegalCookieOops.oopsCookieHandler, gtmInit, { once: true } );

	// const events = {
	// 	mousemove: 'mousemove',

	// 	scroll: 'scroll',

	// 	click: 'click'
	// };

	// function userSuspend()
	// {
	// 	for ( const [ key, value ] of Object.entries( events ) )
	// 	{
	// 		document.removeEventListener( value, gtmInit, { once: true } );
	// 	}
	// }

	// function userInit()
	// {
	// 	for ( const [ key, value ] of Object.entries( events ) )
	// 	{
	// 		document.addEventListener( value, gtmInit, { once: true } );
	// 	}
	// }

	// function checkCookie()
	// {
	// 	return LegalCookie.getCookie( LegalCookieOops.cookieName.oopsCookie ) === LegalCookieOops.cookieValue.accepted;
	// }

	// if ( checkCookie() )
	// {
	// 	userInit();
	// }

	// document.addEventListener( LegalCookieOops.oopsCookieHandler, userInit, { once: true } );

} );

// Google Tag Manager End