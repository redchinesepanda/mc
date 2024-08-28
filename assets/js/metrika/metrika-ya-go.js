// ym 86785715, gtag, ga start

let YMGO = ( function()
{
	"use strict";

	return {
		prefix : {
			default :  'goal-',

			casino :  'casino-'
		},

		part : {
			casino : '/ca/'
		},

		regExp : /-\d+\/$/,
	};
} )();

document.addEventListener( 'DOMContentLoaded', function ()
{
	function sendMetric( href, YandexMetrikaId )
	{
		let prefix = 'goal-';

		if ( href.indexOf( '/ca/' ) !== -1 )
		{
			prefix += 'casino-';
		}

		let parts = href.replace( /\/$/, '' ).match( /\go\/(.+)/i )[ 1 ].split( '/' );

		let goalName = prefix + parts.slice( -1 );

		let goalParams = {
			page: window.location.toString(),
			
			label: parts[ 1 ]
		};

		if ( window[ 'yaCounter' + YandexMetrikaId ] )
		{
			window[ 'yaCounter' + YandexMetrikaId ].reachGoal( goalName, goalParams );

			// console.log( { type: 'yaCounter', YandexMetrikaId: YandexMetrikaId, goalName: goalName, goalParams: goalParams } );
		}
		else if ( window[ 'ym' ] )
		{
			window[ 'ym' ]( YandexMetrikaId, 'reachGoal', goalName, goalParams );

			// console.log( { type: 'ym', YandexMetrikaId: YandexMetrikaId, goalName: goalName, goalParams: goalParams } );
		}

		if ( window[ 'gtag' ] )
		{
			window[ 'gtag' ]( 'event', 'conversion', { event_category: goalName, event_label: goalParams.label } );

			// console.log( { type: 'gtag', goalName: goalName, goalParams: goalParams } );
		}
		else if ( window[ 'ga' ] )
		{
			window[ 'ga' ]( 'send', 'event', { eventCategory: 'conversion', eventAction: goalName, eventLabel: goalParams.label } );

			// console.log( { type: 'ga', goalName: goalName, goalParams: goalParams } );
		}
	}

	function handleRef( event )
	{

		// console.log( 'handleRef:' );

		let ref = event.currentTarget;

		// console.log( ref );

		// console.log( MetrikaLib.yandexMetrikaId );
		
		// console.log( YMGO.regExp.test( ref.href ) );

		if ( YMGO.regExp.test( ref.href ) )
		{
			sendMetric( ref.href.replace( YMGO.regExp, '' ), MetrikaLib.yandexMetrikaId );
		}

		// sendMetric( ref.href, '' );

		// sendMetric( ref.href.replace( YMGO.regExp, '' ), MetrikaLib.yandexMetrikaId );

		sendMetric( ref.href, MetrikaLib.yandexMetrikaId );

		// console.log( ref.href );
	}

	function prepareRef( element )
	{
		element.addEventListener( 'click', handleRef );

		// console.log( 'prepareRef:' );

		// console.log( element );
	}

	const selectors = {
		go : 'a[href*="/go/"]'
	};

	const classes = {
		loggedIn : 'logged-in'
	};

	function metricInit()
	{
		// var YandexMetrikaId = 86785715,
		// 	refs = document.querySelectorAll( 'a[href*="/go/"]' );

		// let YandexMetrikaId = 86785715;

		// let refs = document.querySelectorAll( 'a[href*="/go/"]' );

		// const regExp = /-\d+\/$/;

		// for ( var ref of refs )
		// {
			// ref.addEventListener( 'click', function ( e )
			// {
			// 	// console.log(`Нажали на нужную рефку ${ref}`); 
			// 	if ( regExp.test( this.href ) )
			// 	{
			// 		sendMetric( this.href.replace( regExp, '' ), YandexMetrikaId );
			// 	}

			// 	sendMetric( this.href );
			// } );

		// 	ref.addEventListener( 'click', handleRef );
		// }

		document.querySelectorAll( selectors.go ).forEach( prepareRef );

		// console.log( 'metricInit' );

		MetrikaLib.userSuspend( metricInit );

		// console.log( 'metricInit-userSuspend' );
	}

	function checkCookie()
	{
		return MetrikaLib.checkCookie()
	}

	function checkLoggedIn()
	{
		return ! document.body.classList.contains( classes.loggedIn );
	}

	function check()
	{
		return checkCookie() && checkLoggedIn();
	}

	if ( check() )
	{
		// metricInit();

		MetrikaLib.userInit( metricInit );
	}

	document.addEventListener( LegalCookieOops.oopsCookieHandler, metricInit, { once: true } );
});

// ym 86785715, gtag, ga end