// oops-cookie start

document.addEventListener( 'DOMContentLoaded', function ()
{
	const selectors = {
		cookieWrapper: '.legal-oops-cookie-wrapper',

		cookieButton: '.oops-cookie-button.legal-all',

		cookieButtonNecessary: '.oops-cookie-button.legal-necessary',

		ageWrapper: '.legal-oops-age-wrapper',

		ageButtonYes: '.age-button-yes-link'
	};

	const classes = {
		active: 'legal-active'
	};

	const cookieValue = {
		accepted: 'accepted',

		undefined: undefined,
	};

	function closeOops( element )
	{
		element.closest( element.dataset.wrapperSelector ).classList.remove( classes.active );
	}

	function acceptCookieNecessary( event )
	{
		closeOops( event.currentTarget );
	}

	function acceptCookie( event )
	{
		if ( event.currentTarget.dataset.wrapperSelector == selectors.ageWrapper )
		{
			console.log( cookies.oopsCookie );

			console.log( LegalCookie.getCookie( cookies.oopsCookie ) );
			
			if ( LegalCookie.getCookie( cookies.oopsCookie ) === cookieValue.accepted )
			{
				LegalCookie.setCookie( event.currentTarget.dataset.cookie, cookieValue.accepted, LegalCookie.options );
			}
		}
		else
		{
			LegalCookie.setCookie( event.currentTarget.dataset.cookie, cookieValue.accepted, LegalCookie.options );
		}

		// event.currentTarget.closest( event.currentTarget.dataset.wrapperSelector ).classList.remove( classes.active );

		closeOops( event.currentTarget );
	}

	function prepareAccept( button )
	{
		button.dataset.cookie = this.cookie;

		button.dataset.wrapperSelector = this.wrapperSelector;

		button.addEventListener( events.click, acceptCookie, false );
	}

	function prepareAcceptNecessary( wrapper )
	{
		wrapper.querySelector( selectors.cookieButtonNecessary ).addEventListener( events.click, acceptCookieNecessary, false );
	}

	function oopsInit( wrapper, wrapperSelector, cookie, itemSlector )
	{
		console.log( LegalCookie.getCookie( cookie ) );

		console.log( LegalCookie.getCookie( cookie ) === undefined );

		if ( LegalCookie.getCookie( cookie ) === undefined )
		{
			wrapper.querySelectorAll( itemSlector ).forEach( prepareAccept, {
				cookie: cookie,

				wrapperSelector: wrapperSelector
			} );
			
			wrapper.classList.add( classes.active );

			console.log( wrapper.classList );

			if ( wrapperSelector == selectors.cookieWrapper )
			{
				// closeOops( wrapper.querySelector( itemSlector ) ); 

				// wrapper.classList.remove( classes.active );

				prepareAcceptNecessary( wrapper )
			}
		}
	}
	
	const cookies = {
		oopsAge: 'legal-oops-age',

		oopsCookie: 'legal-oops-cookie'
	};

	function enableOops( element )
	{
		document.querySelectorAll( selectors.cookieWrapper ).forEach( function ( wrapper )
		{
			oopsInit( wrapper, selectors.cookieWrapper, cookies.oopsCookie, selectors.cookieButton );

			console.log( wrapper );
		} );
	
		document.querySelectorAll( selectors.ageWrapper ).forEach( function ( wrapper )
		{
			oopsInit( wrapper, selectors.ageWrapper, cookies.oopsAge, selectors.ageButtonYes );

			console.log( wrapper );
		} );
	}

	const events = {
		mousemove: 'mousemove',

		scroll: 'scroll',

		click: 'click'
	};

	function enableOopsAll( event )
	{
		document.querySelectorAll( [ selectors.cookieWrapper, selectors.ageWrapper ].join( ', ' ) ).forEach( enableOops );

		for ( const [ key, value ] of Object.entries( events ) )
		{
			document.removeEventListener( value, enableOopsAll, { once: true } );
		}
	}

	console.log( events );

	for ( const [ key, value ] of Object.entries( events ) )
	{
		document.addEventListener( value, enableOopsAll, { once: true } );

		console.log( value );
	}
} );

// oops-cookie end