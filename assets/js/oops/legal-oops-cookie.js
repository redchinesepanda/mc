// oops-cookie start

document.addEventListener( 'DOMContentLoaded', function ()
{
	const selectors = {
		cookieWrapper: '.legal-oops-cookie-wrapper',

		cookieButton: '.oops-cookie-button',

		ageWrapper: '.legal-oops-age-wrapper',

		ageButtonYes: '.age-button-yes-link'
	};

	const classes = {
		active: 'legal-active'
	};

	function closeOops( element )
	{
		element.closest( element.dataset.wrapperSelector ).classList.remove( classes.active );
	}

	function acceptCookie( event )
	{
		LegalCookie.setCookie( event.currentTarget.dataset.cookie, 'accepted', LegalCookie.options );

		// event.currentTarget.closest( event.currentTarget.dataset.wrapperSelector ).classList.remove( classes.active );

		closeOops( event.currentTarget );
	}

	function prepareAccept( button )
	{
		button.dataset.cookie = this.cookie;

		button.dataset.wrapperSelector = this.wrapperSelector;

		button.addEventListener( 'click', acceptCookie, false );
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
				closeOops( wrapper.querySelector( itemSlector ) ); 
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