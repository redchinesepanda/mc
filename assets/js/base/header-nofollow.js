document.addEventListener( 'DOMContentLoaded', function () {
	// console.log( 'legal-nofollow-kz start' );

	if ( window.location.href.includes( '/kz/bonusy' ) ) {
		if ( document.documentElement.getAttribute( 'lang' ) == 'ru-KZ' ) {
			const wrapper = document.getElementById( 'wrapper' );

			if (wrapper !== null) {

				const links = wrapper.getElementsByTagName('a');

				const includes = [ window.location.hostname + '/go' ];

				// console.log( 'legal-nofollow-kz includes: ' + JSON.stringify( includes ) );

				const origin = window.location.origin;

				for ( const link of links ) {
					let nofollow = false;

					let url = new URL( link.href, origin);
					
					for ( const include of includes ) {
						if ( url.href.includes( include ) ) {
							nofollow = true;
						}
					}

					if ( nofollow ) {
						if ( link.getAttribute( 'rel' ) === null ) {
							link.setAttribute( 'rel', 'nofollow' );

							// console.log( 'legal-nofollow-kz url: ' + JSON.stringify( url ) );
						}
					}
				}
			}
		}
	}

	// console.log( 'legal-nofollow-kz end' );
} );