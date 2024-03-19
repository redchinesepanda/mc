// oops-cookie start

let LegalCookieOops = ( function()
{
	"use strict";

	return {
		cookieName : {
			oopsAge: 'legal-oops-age',
	
			oopsCookie: 'legal-oops-cookie'
		},

		cookieValue : {
			accepted: 'accepted',
	
			undefined: undefined,
		},

		oopsCookieHandler : 'oopscookiesset',

		oopsCookieEvent : function()
		{
			return new CustomEvent( this.oopsCookieHandler, {} );
		}
	};
} )();

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
			// if ( LegalCookie.getCookie( cookies.oopsCookie ) === cookieValue.accepted )
			
			if ( MetrikaLib.checkCookie() )
			{
				LegalCookie.setCookie( event.currentTarget.dataset.cookie, cookieValue.accepted, LegalCookie.options );
			}
		}
		else
		{
			LegalCookie.setCookie( event.currentTarget.dataset.cookie, cookieValue.accepted, LegalCookie.options );

			// console.log( LegalCookieOops.oopsCookieEvent );

			if ( MetrikaLib.checkCode() )
			{
				document.dispatchEvent( LegalCookieOops.oopsCookieEvent() );
			}
		}

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
		if ( LegalCookie.getCookie( cookie ) === undefined )
		{
			wrapper.querySelectorAll( itemSlector ).forEach( prepareAccept, {
				cookie: cookie,

				wrapperSelector: wrapperSelector
			} );
			
			wrapper.classList.add( classes.active );

			if ( wrapperSelector == selectors.cookieWrapper )
			{
				// closeOops( wrapper.querySelector( itemSlector ) ); 

				// wrapper.classList.remove( classes.active );

				prepareAcceptNecessary( wrapper );
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
		} );
	
		document.querySelectorAll( selectors.ageWrapper ).forEach( function ( wrapper )
		{
			oopsInit( wrapper, selectors.ageWrapper, cookies.oopsAge, selectors.ageButtonYes );
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

	for ( const [ key, value ] of Object.entries( events ) )
	{
		document.addEventListener( value, enableOopsAll, { once: true } );
	}
} );

// oops-cookie end