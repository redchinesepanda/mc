// ym 86785715, gtag, ga start

document.addEventListener( 'DOMContentLoaded', function () {
	if ( !document.body.classList.contains( 'logged-in' ) ) {
		var YandexMetrikaId = 86785715,
			refs = document.querySelectorAll( 'a[href^="/go/"' );

		for ( var ref of refs ) {
			ref.addEventListener( 'click', function ( e ) {
				let prefix = 'goal-';

				if ( this.href.indexOf( '/ca/' ) !== -1 ) {
					prefix += 'casino-';
				}

				var parts = this.href.replace( /\/$/, '' ).match( /\go\/(.+)/i )[1].split( '/' ),
					goalName = prefix + parts.slice(-1),
					goalParams = { page: window.location.toString(), label: parts[ 1 ] };

				if ( window[ 'yaCounter' + YandexMetrikaId ] ) {
					window[ 'yaCounter' + YandexMetrikaId ].reachGoal( goalName, goalParams );
				} else if ( window[ 'ym' ] ) {
					window[ 'ym' ]( YandexMetrikaId, 'reachGoal', goalName, goalParams );
				}

				if ( window[ 'gtag' ] ) {
					window[ 'gtag' ]( 'event', 'conversion', { event_category: goalName, event_label: goalParams.label } );
				} else if ( window[ 'ga' ] ) {
					window[ 'ga' ]( 'send', 'event', { eventCategory: 'conversion', eventAction: goalName, eventLabel: goalParams.label } );
				}
			} );
		}
	}
});

// ym 86785715, gtag, ga end