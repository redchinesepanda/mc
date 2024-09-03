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

	function getUserId()
	{
		let userId = localStorage.getItem( 'userId' ) ?? '';

		if ( ! userId )
		{
			userId = 'legal_user_id' + Date.now();
	
			localStorage.setItem( 'userId', userId );
		}
	}

	function gtagRunInitNoCookieUserId()
	{
		// let userId = 'legal_user_id' + Date.now();
		
		let userId = getUserId();

		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('consent', 'default', {
            'ad_storage': 'denied',
            'ad_user_data': 'granted',
            'ad_personalization': 'granted',
            'analytics_storage': 'denied'
        });
		gtag('js', new Date());
		gtag('config', 'UA-224707123-1');
		gtag('config', '{{ gaData.id }}', { 'user_id': userId });
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