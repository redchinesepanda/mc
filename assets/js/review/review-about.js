// review-about start

document.addEventListener( 'DOMContentLoaded', function ()
{
	// function moveBonusToReviewAbout( element )
	// {
	// 	element.appendChild( document.querySelector( selectors.sidebarBonus ) );
	// }

	// function moveBonusToSidebar( element )
	// {
	// 	element.appendChild( document.querySelector( selectors.reviewAboutBonus ) );
	// }

	function checkState( event )
	{
		console.log( 'checkState' );

		console.log( 'window.scrollY: ' + window.scrollY );

		console.log( 'reviewAboutScroll: ' + localStorage.getItem( 'reviewAboutScroll' ) );

		let state = localStorage.getItem( 'reviewAboutScroll' );

		console.log( 'state != true: ' + ( state != true ) );

		if ( window.scrollY > 0 && state != true )
		{
			localStorage.setItem( 'reviewAboutScroll', true );

			console.log( 'reviewAboutScroll move: ' + localStorage.getItem( 'reviewAboutScroll' ) );

			// document.querySelectorAll( selectors.sidebar ).forEach( moveBonusToSidebar );
		}

		console.log( '== 0: ' + ( window.scrollY == 0 ) );

		console.log( '== true: ' + ( localStorage.getItem( 'reviewAboutScroll' ) == true ) );

		if ( window.scrollY == 0 && localStorage.getItem( 'reviewAboutScroll' ) == true )
		{
			localStorage.setItem( 'reviewAboutScroll', false );

			console.log( 'reviewAboutScroll back: ' + localStorage.getItem( 'reviewAboutScroll' ) );

			// document.querySelectorAll( selectors.reviewAbout ).forEach( moveBonusToReviewAbout );
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