// review-about start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function moveBack( element )
	{
		console.log( element );

		console.log( document.querySelector( selectors.sidebarBonus ) );

		element.appendChild( document.querySelector( selectors.sidebarBonus ) );
	}

	function moveToSidebar( element )
	{
		console.log( element );

		console.log( document.querySelector( selectors.reviewAboutBonus ) );

		element.appendChild( document.querySelector( selectors.reviewAboutBonus ) );
	}

	function checkState( event )
	{
		console.log( 'checkState' );

		// console.log( 'window.scrollY: ' + window.scrollY );

		// console.log( 'reviewAboutScroll: ' + localStorage.getItem( 'reviewAboutScroll' ) );

		let state = localStorage.getItem( 'reviewAboutScroll' );

		// console.log( 'state != 1: ' + ( state != 1 ) );

		if ( window.scrollY > 0 && state != 1 )
		{
			localStorage.setItem( 'reviewAboutScroll', 1 );

			// console.log( 'reviewAboutScroll move: ' + localStorage.getItem( 'reviewAboutScroll' ) );

			document.querySelectorAll( selectors.sidebar ).forEach( moveToSidebar );
		}

		// console.log( '== 0: ' + ( window.scrollY == 0 ) );

		// console.log( 'state == 1: ' + ( localStorage.getItem( 'reviewAboutScroll' ) == 1 ) );

		if ( window.scrollY == 0 && state == 1 )
		{
			localStorage.setItem( 'reviewAboutScroll', 0 );

			// console.log( 'reviewAboutScroll back: ' + localStorage.getItem( 'reviewAboutScroll' ) );

			document.querySelectorAll( selectors.reviewAbout ).forEach( moveBack );
		}
	}

	const selectors = {
		reviewAbout : '.review-about',

		reviewAboutBonus : '.review-about .about-right',

		sidebar : '.legal-review-page-sidebar',

		sidebarBonus : '.legal-review-page-sidebar .about-right',
	};

	document.addEventListener( 'scroll', checkState, false );
} );

// review-about-js end