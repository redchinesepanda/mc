let MetrikaLib = ( function()
{
	"use strict";

	return {
		yandexMetrikaId: '86785715';

		events : {
			mousemove: 'mousemove',
	
			scroll: 'scroll',
	
			click: 'click'
		},
	
		userSuspend : function( handler )
		{
			for ( const [ key, value ] of Object.entries( this.events ) )
			{
				document.removeEventListener( value, handler, { once: true } );
			}
		},
	
		userInit: function( handler )
		{
			for ( const [ key, value ] of Object.entries( this.events ) )
			{
				document.addEventListener( value, handler, { once: true } );
			}
		},

		hreflangs : [
			'da-DK'
		],
	
		checkCode : function()
		{
			return this.hreflangs.includes( document.documentElement.lang );
		},

		checkCookie : function()
		{
			if ( this.checkCode() )
			{
				return LegalCookie.getCookie( LegalCookieOops.cookieName.oopsCookie ) === LegalCookieOops.cookieValue.accepted;
			}

			return true;
		}

		// pageForward : 'pageforward',

		// pageForwardEvent : function( id )
		// {
		// 	return new CustomEvent(
		// 		this.pageForward,

		// 		{
		// 			detail: {
		// 				id: () => id
		// 			},
		// 		}
		// 	)
		// },

		// pageBackward : 'pagebackward',

		// pageBackwardEvent : function( id )
		// {
		// 	return new CustomEvent(
		// 		'pagebackward',

		// 		{
		// 			detail: {
		// 				id: () => id
		// 			},
		// 		}
		// 	)
		// },

		// pageActive : 'pageactive',

		// pageActiveEvent : function( valueID, valueIndex )
		// {
		// 	return new CustomEvent(
		// 		this.pageActive,

		// 		{
		// 			detail: {
		// 				id: valueID,

		// 				index: valueIndex
		// 			}
		// 		}
		// 	)
		// }
	};
} )();