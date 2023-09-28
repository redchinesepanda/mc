// ym 86785715, gtag, ga start

document.addEventListener( 'DOMContentLoaded', function ()
{
	// console.log( 'ym 86785715 start' );

	if ( !document.body.classList.contains( 'logged-in' ) )
	{
		// console.log( 'ym 86785715 not logged-in' );

		function sendMetric( href ) {
			// console.log( 'ym 86785715 sendMetric href: ' + href );

			let prefix = 'goal-';

			if ( href.indexOf( '/ca/' ) !== -1 ) {
				prefix += 'casino-';
			}

			var parts = href.replace( /\/$/, '' ).match( /\go\/(.+)/i )[ 1 ].split( '/' ),
				goalName = prefix + parts.slice( -1 ),
				goalParams = { page: window.location.toString(), label: parts[ 1 ] };

			if ( window[ 'yaCounter' + YandexMetrikaId ] )
			{
				window[ 'yaCounter' + YandexMetrikaId ].reachGoal( goalName, goalParams );
			} else if ( window[ 'ym' ] )
			{
				window[ 'ym' ]( YandexMetrikaId, 'reachGoal', goalName, goalParams );
			}

			if ( window[ 'gtag' ] )
			{
				window[ 'gtag' ]( 'event', 'conversion', { event_category: goalName, event_label: goalParams.label } );
			} else if ( window[ 'ga' ] )
			{
				window[ 'ga' ]( 'send', 'event', { eventCategory: 'conversion', eventAction: goalName, eventLabel: goalParams.label } );
			}
		}

		var YandexMetrikaId = 86785715,
			refs = document.querySelectorAll( 'a[href*="/go/"]' );

		const regExp = /-\d+\/$/;

		// console.log( 'ym 86785715 refs' + refs );

		for ( var ref of refs ) {

			// console.log( 'ym 86785715 ref: ' + ref );

			// console.log( 'ym 86785715 ref.href: ' + ref.href );

			ref.addEventListener( 'click', function ( e ) {
				// const regExp = /-\d+$/;
				
				// const regExp = /-\d+\/$/;

				// console.log( 'ym 86785715 regExp.test: ' + regExp.test( this.href ) );
				
				if ( regExp.test( this.href ) )
				{
					// console.log( 'ym 86785715 ref: ' + ref );

					sendMetric( this.href.replace( regExp, '' ) );
				}

				sendMetric( this.href );
			} );
		}
	}
});

// ym 86785715, gtag, ga end