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

	function gtagRunInitNoCookieUserId()
	{
		gtagRunInit();

		let userId = 'legal_user_id' + Date.now();

		console.log( 'userId:');

		console.log( userId );

		gtag(
			'config',
			
			'{{ gaData.id }}',
			
			{
				'user_id': userId
			}
		);

		gtag(
			'consent',
			
			'default',
			
			{
				'ad_storage': 'denied',

				'ad_user_data': 'granted',

				'ad_personalization': 'granted',

				'analytics_storage': 'denied'
			}
		);
	}

	if ( MetrikaLib.checkCookie() )
	{
		// gtagRunInit();

		MetrikaLib.userInit( gtagRunInit );
	}
	else
	{
		MetrikaLib.userInit( gtagRunInitNoCookieUserId );
	}

	document.addEventListener( LegalCookieOops.oopsCookieHandler, gtagRunInit, { once: true } );
	
} );

// Google Tag Manager run start