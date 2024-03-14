// ym 86785715, gtag, ga start

document.addEventListener( 'DOMContentLoaded', function ()
{
	if ( !document.body.classList.contains( 'logged-in' ) )
	{
		function sendMetric( href )
		{
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

				console.log( { YandexMetrikaId: YandexMetrikaId, goalName: goalName, goalParams: goalParams } );
			}
			else if ( window[ 'ym' ] )
			{
				window[ 'ym' ]( YandexMetrikaId, 'reachGoal', goalName, goalParams );
			}

			if ( window[ 'gtag' ] )
			{
				window[ 'gtag' ]( 'event', 'conversion', { event_category: goalName, event_label: goalParams.label } );
			}
			else if ( window[ 'ga' ] )
			{
				window[ 'ga' ]( 'send', 'event', { eventCategory: 'conversion', eventAction: goalName, eventLabel: goalParams.label } );
			}
		}

		var YandexMetrikaId = 86785715,
			refs = document.querySelectorAll( 'a[href*="/go/"]' );

		const regExp = /-\d+\/$/;

		for ( var ref of refs )
		{
			ref.addEventListener( 'click', function ( e )
			{
				if ( regExp.test( this.href ) )
				{
					sendMetric( this.href.replace( regExp, '' ) );
				}

				sendMetric( this.href );
			} );
		}
	}
});

// ym 86785715, gtag, ga end