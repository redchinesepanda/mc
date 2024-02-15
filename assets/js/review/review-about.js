// review-about start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function appendItem( element )
	{
		element.appendChild( document.querySelector( selectors.reviewAboutRight ) );
	}

	function checkState( event )
	{
		console.log( window.scrollY );

		if ( window.scrollY > 0 && !localStorage.getItem( 'reviewAboutScroll' ) )
		{
			localStorage.setItem( 'reviewAboutScroll', true );

			document.querySelectorAll( selectors.sidebar ).forEach( appendItem );
		}

		if ( window.scrollY == 0 )
		{
			localStorage.setItem( 'reviewAboutScroll', false );

			document.querySelectorAll( selectors.reviewAbout ).forEach( appendItem );
		}
	}

	const selectors = {
		reviewAbout : '.review-about',

		reviewAboutRight : '.review-about .about-right',

		sidebar : '.legal-review-page-sidebar'
	};

	document.addEventListener( 'scroll', checkState, false );
} );

// review-about-js end