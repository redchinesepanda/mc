// review-about start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function initBonus( event )
	{
		document.querySelector( selectors.reviewAboutBonus ).classList.add( classes.moved );
	}

	function moveBack( element )
	{
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

	const events = {
		scroll: 'scroll',

		resize: 'resize'
	};

	const items = [
		{
			event: events.scroll,

			action: initBonus,

			args: { once: true }
		},

		{
			event: events.scroll,

			action: checkState,

			args: false
		}
	];

	function reviewAboutInit()
	{
		if ( window.matchMedia( '( min-width: 960px )' ).matches )
		{
			items.forEach( function ( item ) {
				document.addEventListener( item.event, item.action, item.args );
			} );

			// document.addEventListener( events.scroll, initBonus, { once: true } );

			// document.addEventListener( events.scroll, checkState, false );

			localStorage.setItem( 'reviewAboutScroll', 0 );
		}
		else
		{
			items.forEach( function ( item ) {
				document.removeEventListener( item.event, item.action, item.args );
			} );

			// document.removeEventListener( events.scroll, initBonus, { once: true } );

			// document.removeEventListener( events.scroll, checkState, false );
		}
	}

	// reviewAboutInit();

	window.addEventListener( events.resize, reviewAboutInit, false );

	// document.addEventListener( 'scroll', initBonus, { once: true } );

	// document.addEventListener( 'scroll', checkState, false );

	// localStorage.setItem( 'reviewAboutScroll', 0 );
} );

// review-about-js end