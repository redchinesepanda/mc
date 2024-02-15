// review-about start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function initBonus( event )
	{
		document.querySelector( selectors.reviewAboutBonus ).classList.add( classes.moved );
	}

	function moveBack( element )
	{
		console.log( document.querySelector( selectors.sidebarBonus ) );

		if ( document.querySelector( selectors.sidebarBonus ) !== null )
		{
			element.appendChild( document.querySelector( selectors.sidebarBonus ) );
		}
	}

	function moveToSidebar( element )
	{
		element.appendChild( document.querySelector( selectors.reviewAboutBonus ) );
	}

	function checkState( event )
	{
		let state = localStorage.getItem( 'reviewAboutScroll' );

		if ( window.scrollY > 0 && state != 1 )
		{
			localStorage.setItem( 'reviewAboutScroll', 1 );

			document.querySelectorAll( selectors.sidebar ).forEach( moveToSidebar );
		}

		if ( window.scrollY == 0 && state == 1 )
		{
			localStorage.setItem( 'reviewAboutScroll', 0 );

			document.querySelectorAll( selectors.reviewAbout ).forEach( moveBack );
		}
	}

	const selectors = {
		reviewAbout : '.review-about.legal-mode-default',

		reviewAboutBonus : '.review-about.legal-mode-default .about-right',

		sidebar : '.legal-review-page-sidebar',

		sidebarBonus : '.legal-review-page-sidebar .about-right',
	};

	const classes = {
		moved: 'moved-bonus'
	};

	// document.querySelector( selectors.reviewAboutBonus ).classList.add( classes.moved );

	document.addEventListener( 'scroll', initBonus, { once: true } );

	document.addEventListener( 'scroll', checkState, false );
} );

// review-about-js end