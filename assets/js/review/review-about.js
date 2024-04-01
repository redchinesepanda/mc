// review-about start

document.addEventListener( 'DOMContentLoaded', function ()
{
	// function suspendBonus( event )
	// {
	// 	document.querySelector( selectors.reviewAboutBonus ).classList.remove( classes.moved );
	// }

	function suspendBonus( event )
	{
		// document.querySelector( selectors.sidebarBonus ).classList.remove( classes.moved );

		modify( suspendMoved );
	}

	function initBonus( event )
	{
		// if ( document.querySelector( selectors.reviewAboutBonus ) !== null )
		// {
		// 	// document.querySelector( selectors.reviewAboutBonus ).classList.add( classes.moved );
		// }
			
		modify( setMoved );
	}

	// function move( element, selector )
	// {
	// 	if ( document.querySelector( selector ) !== null )
	// 	{
	// 		element.appendChild( document.querySelector( selector ) );
	// 	}
	// }

	// function moveBack( element )
	// {
	// 	move( element, selectors.sidebarBonus );
	// }

	// function moveToSidebar( element )
	// {
	// 	move( element, selectors.reviewAboutBonus );
	// }

	// function checkState( event )
	// {
	// 	let state = localStorage.getItem( 'reviewAboutScroll' );

	// 	if ( window.scrollY > 0 && state != 1 )
	// 	{
	// 		localStorage.setItem( 'reviewAboutScroll', 1 );

	// 		document.querySelectorAll( selectors.sidebar ).forEach( moveToSidebar );
	// 	}

	// 	if ( window.scrollY == 0 && state == 1 )
	// 	{
	// 		localStorage.setItem( 'reviewAboutScroll', 0 );

	// 		document.querySelectorAll( selectors.reviewAbout ).forEach( moveBack );
	// 	}
	// }
	
	function setMoved( element )
	{
		element.classList.add( classes.moved );
	}

	function suspendMoved( element )
	{
		element.classList.remove( classes.moved );
	}
	
	function checkState( event )
	{
		let state = localStorage.getItem( 'reviewAboutScroll' );

		if ( window.scrollY > 0 && state != 1 )
		{
			localStorage.setItem( 'reviewAboutScroll', 1 );

			// document.querySelector( selectors.sidebarBonus ).classList.add( classes.moved );

			modify( setMoved );
		}

		if ( window.scrollY == 0 && state == 1 )
		{
			localStorage.setItem( 'reviewAboutScroll', 0 );

			// document.querySelector( selectors.sidebarBonus ).classList.remove( classes.moved );

			modify( suspendMoved );
		}
	}

	// function checkSticky( event )
	// {
	// 	let state = localStorage.getItem( 'reviewAboutSticky' );

	// 	if ( window.scrollY > 0 && state != 1 )
	// 	{
	// 		localStorage.setItem( 'reviewAboutSticky', 1 );

	// 		document.querySelector( selectors.reviewAboutBonus ).classList.add( classes.sticky );
	// 	}

	// 	if ( window.scrollY == 0 && state == 1 )
	// 	{
	// 		localStorage.setItem( 'reviewAboutSticky', 0 );

	// 		document.querySelector( selectors.reviewAboutBonus ).classList.remove( classes.sticky );
	// 	}
	// }
	
	function setSticky( element )
	{
		element.classList.add( classes.sticky );
	}

	function suspendSticky( element )
	{
		element.classList.remove( classes.sticky );
	}

	function modify( action )
	{
		document.querySelectorAll( [ selectors.sidebarBonus, selectors.sidebarAction ].join( ', ' ) ).forEach( action );
	}

	function checkSticky( event )
	{
		let state = localStorage.getItem( 'reviewAboutSticky' );

		/* if ( window.scrollY > 0 && state != 1 ) */
		if ( window.scrollY > 550 )
		{
			localStorage.setItem( 'reviewAboutSticky', 1 );

			// document.querySelector( selectors.sidebarBonus ).classList.add( classes.sticky );

			// document.querySelectorAll( [ selectors.sidebarBonus, selectors.sidebarAction ].join( ', ' ) ).forEach( setSticky );

			modify( setSticky );
		}

		/* if ( window.scrollY == 0 && state == 1 ) */
		
		if ( window.scrollY <= 550 )
		{
			localStorage.setItem( 'reviewAboutSticky', 0 );

			// document.querySelector( selectors.sidebarBonus ).classList.remove( classes.sticky );
			
			// document.querySelectorAll( [ selectors.sidebarBonus, selectors.sidebarAction ].join( ', ' ) ).forEach( suspendSticky );

			modify( suspendSticky );
		}
	}

	const selectors = {
		reviewAbout : '.review-about.legal-mode-default',

		reviewAboutBonus : '.review-about.legal-mode-default .about-right',

		sidebar : '.legal-review-page-sidebar',

		sidebarBonus : '.legal-review-page-sidebar .about-right',

		sidebarAction : '.legal-bonus-sidebar .bonus-about-action',
	};

	const classes = {
		moved: 'moved-bonus',

		sticky: 'sticky-bonus',

		animated: 'animated-bonus',
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

	const itemsMobile = [
		{
			event: events.scroll,

			action: suspendBonus,

			args: { once: true }
		},

		{
			event: events.scroll,

			action: checkSticky,

			args: false
		}
	];

	function reviewAboutInit()
	{
		if ( window.matchMedia( '( min-width: 960px )' ).matches )
		{
			itemsMobile.forEach( function ( item ) {
				document.removeEventListener( item.event, item.action, item.args );
			} );

			items.forEach( function ( item ) {
				document.addEventListener( item.event, item.action, item.args );
			} );

			localStorage.setItem( 'reviewAboutScroll', 0 );
		}
		else
		{
			// document.querySelectorAll( selectors.reviewAbout ).forEach( moveBack );

			items.forEach( function ( item ) {
				document.removeEventListener( item.event, item.action, item.args );
			} );

			itemsMobile.forEach( function ( item ) {
				document.addEventListener( item.event, item.action, item.args );
			} );
		}
	}

	reviewAboutInit();

	window.addEventListener( events.resize, reviewAboutInit, false );
} );

// review-about-js end