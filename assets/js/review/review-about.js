// review-about start

document.addEventListener( 'DOMContentLoaded', function ()
{
	let storage = {
		field : {
			scroll: 'reviewAboutScroll',
		},

		getState : function()
		{
			return localStorage.getItem( this.field.scroll );
		},

		initState : function()
		{
			return localStorage.setItem( this.field.scroll, 1 );
		},

		suspendState : function()
		{
			return localStorage.setItem( this.field.scroll, 0 );
		},

		checkStateSuspended : function()
		{
			return this.getState() != 1;
		},

		checkStateReady : function()
		{
			return this.getState() == 1;
		}
	};

	let scroll = {
		offset : {
			moved: 0,
	
			sticky: 550
		},

		checkMoved : function()
		{
			return window.scrollY > this.offset.moved;
		},

		checkMovedBack : function()
		{
			return window.scrollY <= this.offset.moved;
		},

		checkSticky : function()
		{
			return window.scrollY > this.offset.sticky;
		},

		checkStickyBack : function()
		{
			return window.scrollY <= this.offset.sticky;
		},
	};

	// let move = {
	// 	move : function( element, selector )
	// 	{
	// 		if ( document.querySelector( selector ) !== null )
	// 		{
	// 			element.appendChild( document.querySelector( selector ) );
	// 		}
	// 	},

	// 	moveBack : function( element )
	// 	{
	// 		move( element, selectors.sidebarBonus );
	// 	},

	// 	moveToSidebar : function( element )
	// 	{
	// 		move( element, selectors.reviewAboutBonus );
	// 	},

	// 	checkState : function( event )
	// 	{
	// 		let state = localStorage.getItem( 'reviewAboutScroll' );

	// 		if ( window.scrollY > 0 && state != 1 )
	// 		{
	// 			localStorage.setItem( 'reviewAboutScroll', 1 );

	// 			document.querySelectorAll( selectors.sidebar ).forEach( moveToSidebar );
	// 		}

	// 		if ( window.scrollY == 0 && state == 1 )
	// 		{
	// 			localStorage.setItem( 'reviewAboutScroll', 0 );

	// 			document.querySelectorAll( selectors.reviewAbout ).forEach( moveBack );
	// 		}
	// 	}
	// };

	const selectors = {
		reviewAbout : '.review-about.legal-mode-default',

		reviewAboutBonus : '.review-about.legal-mode-default .about-right',

		sidebar : '.legal-review-page-sidebar',

		sidebarBonus : '.legal-review-page-sidebar .about-right',

		sidebarAction : '.legal-bonus-sidebar .bonus-about-action',
	};

	let state = {
		classes : {
			moved: 'moved-bonus',

			sticky: 'sticky-bonus',

			animated: 'animated-bonus',
		},

		modify : function( action )
		{
			document.querySelectorAll(
				[ selectors.sidebarBonus, selectors.sidebarAction ].join( ', ' )
			).forEach( action );
		},
		
		setMoved : function( element )
		{
			element.classList.add( this.classes.moved );
		},

		suspendMoved : function( element )
		{
			element.classList.remove( this.classes.moved );
		},

		setSticky : function( element )
		{
			element.classList.add( this.classes.sticky );
		},

		suspendSticky : function( element )
		{
			element.classList.remove( this.classes.sticky );
		},

		suspendBonus : function( event )
		{
			this.modify( this.suspendMoved );
		},

		initBonus : function( event )
		{
			this.modify( this.setMoved );
		},

		checkState : function( event )
		{
			if ( scroll.checkMoved() && storage.checkStateSuspended() )
			{
				storage.initState();
				
				this.modify( this.setMoved );
			}

			if ( scroll.checkMovedBack() && storage.checkStateReady() )
			{
				storage.suspendState();
				
				this.modify( this.suspendMoved );
			}
		},

		checkSticky : function( event )
		{
			if ( scroll.checkSticky && storage.checkStateSuspended() )
			{
				storage.initState();

				this.modify( this.setSticky );
			}

			if ( scroll.checkStickyBack() && storage.checkStateReady() )
			{
				storage.suspendState();

				this.modify( this.suspendSticky );
			}
		}
	};
	
	// function suspendBonus( event )
	// {
	// 	modify( suspendMoved );
	// }

	// function initBonus( event )
	// {
	// 	modify( setMoved );
	// }
	
	// function setMoved( element )
	// {
	// 	element.classList.add( classes.moved );
	// }

	// function suspendMoved( element )
	// {
	// 	element.classList.remove( classes.moved );
	// }

	// const storage = {
	// 	scroll: 'reviewAboutScroll',
	// };
	
	// function checkState( event )
	// {
	// 	// let state = localStorage.getItem( 'reviewAboutScroll' );
		
	// 	// let state = localStorage.getItem( storage.scroll );

	// 	// if ( window.scrollY > offset.moved && state != 1 )
		
	// 	// if ( window.scrollY > offset.moved && checkStateSuspended() )
		
	// 	// if ( window.scrollY > offset.moved && storage.checkStateSuspended() )
		
	// 	if ( scroll.checkMoved() && storage.checkStateSuspended() )
	// 	{
	// 		// localStorage.setItem( 'reviewAboutScroll', 1 );
			
	// 		// localStorage.setItem( storage.scroll, 1 );

	// 		// initState();
			
	// 		storage.initState();

	// 		// document.querySelector( selectors.sidebarBonus ).classList.add( classes.moved );

	// 		// modify( setMoved );
			
	// 		state.modify( state.setMoved );
	// 	}

	// 	// if ( window.scrollY == offset.moved && state == 1 )
		
	// 	// if ( window.scrollY == offset.moved && checkStateReady() )
		
	// 	// if ( window.scrollY == offset.moved && storage.checkStateReady() )
		
	// 	if ( scroll.checkMovedBack() && storage.checkStateReady() )
	// 	{
	// 		// localStorage.setItem( 'reviewAboutScroll', 0 );
			
	// 		// localStorage.setItem( storage.scroll, 0 );

	// 		// suspendState();
			
	// 		storage.suspendState();

	// 		// document.querySelector( selectors.sidebarBonus ).classList.remove( classes.moved );

	// 		// modify( suspendMoved );
			
	// 		state.modify( state.suspendMoved );
	// 	}
	// }

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
	
	// function setSticky( element )
	// {
	// 	element.classList.add( classes.sticky );
	// }

	// function suspendSticky( element )
	// {
	// 	element.classList.remove( classes.sticky );
	// }

	// function modify( action )
	// {
	// 	document.querySelectorAll( [ selectors.sidebarBonus, selectors.sidebarAction ].join( ', ' ) ).forEach( action );
	// }

	// const offset = {
	// 	moved: 0,

	// 	sticky: 550
	// };

	// function getState()
	// {
	// 	return localStorage.getItem( storage.scroll );
	// }

	// function initState()
	// {
	// 	return localStorage.setItem( storage.scroll, 1 );
	// }

	// function suspendState()
	// {
	// 	return localStorage.setItem( storage.scroll, 0 );
	// }

	// function checkStateSuspended()
	// {
	// 	return getState() != 1;
	// }

	// function checkStateReady()
	// {
	// 	return getState() == 1;
	// }

	// function checkSticky( event )
	// {
	// 	// let state = localStorage.getItem( 'reviewAboutSticky' );
		
	// 	// let state = localStorage.getItem( storage.scroll );

	// 	/* if ( window.scrollY > 0 && state != 1 ) */
		
	// 	// if ( window.scrollY > 550 )
		
	// 	// if ( window.scrollY > offset.sticky )
		
	// 	// if ( window.scrollY > offset.sticky && checkStateSuspended() )
		
	// 	// if ( window.scrollY > offset.sticky && storage.checkStateSuspended() )
		
	// 	if ( scroll.checkSticky && storage.checkStateSuspended() )
	// 	{
	// 		// localStorage.setItem( 'reviewAboutSticky', 1 );
			
	// 		// localStorage.setItem( storage.scroll, 1 );

	// 		// initState();
			
	// 		storage.initState();

	// 		// document.querySelector( selectors.sidebarBonus ).classList.add( classes.sticky );

	// 		// document.querySelectorAll( [ selectors.sidebarBonus, selectors.sidebarAction ].join( ', ' ) ).forEach( setSticky );

	// 		// modify( setSticky );
			
	// 		state.modify( state.setSticky );
	// 	}

	// 	/* if ( window.scrollY == 0 && state == 1 ) */
		
	// 	// if ( window.scrollY <= 550 )
		
	// 	// if ( window.scrollY <= offset.sticky )
		
	// 	// if ( window.scrollY <= offset.sticky && state == 1 )
		
	// 	// if ( window.scrollY <= offset.sticky && checkStateReady() )
		
	// 	// if ( window.scrollY <= offset.sticky && storage.checkStateReady() )
		
	// 	if ( scroll.checkStickyBack() && storage.checkStateReady() )
	// 	{
	// 		// localStorage.setItem( 'reviewAboutSticky', 0 );
			
	// 		// localStorage.setItem( storage.scroll, 0 );

	// 		// suspendState();
			
	// 		storage.suspendState();

	// 		// document.querySelector( selectors.sidebarBonus ).classList.remove( classes.sticky );
			
	// 		// document.querySelectorAll( [ selectors.sidebarBonus, selectors.sidebarAction ].join( ', ' ) ).forEach( suspendSticky );

	// 		// modify( suspendSticky );
			
	// 		state.modify( state.suspendSticky );
	// 	}
	// }

	// const classes = {
	// 	moved: 'moved-bonus',

	// 	sticky: 'sticky-bonus',

	// 	animated: 'animated-bonus',
	// };

	// let reviewAbout =  {
	
	class ReviewAbout {
		constructor() {}

		events = {
			scroll: 'scroll',
	
			resize: 'resize'
		}

		items = [
			{
				event : this.events.scroll,
				
				action : state.initBonus,
	
				args : { once : true }
			},
	
			{
				event : this.events.scroll,
				
				action : state.checkState,
	
				args : false
			}
		]

		itemsMobile = [
			{
				event : this.events.scroll,
				
				action : state.suspendBonus,
	
				args : { once : true }
			},
	
			{
				event : this.events.scroll,
				
				action : state.checkSticky,
	
				args : false
			}
		]

		static check()
		{
			if ( window.matchMedia( '( min-width: 960px )' ).matches )
			{
				this.itemsMobile.forEach( function ( item ) {
					document.removeEventListener( item.event, item.action, item.args );
				} );
	
				this.items.forEach( function ( item ) {
					document.addEventListener( item.event, item.action, item.args );
				} );
	
				// localStorage.setItem( 'reviewAboutScroll', 0 );

				storage.suspendState();
			}
			else
			{
				this.items.forEach( function ( item ) {
					document.removeEventListener( item.event, item.action, item.args );
				} );
	
				this.itemsMobile.forEach( function ( item ) {
					document.addEventListener( item.event, item.action, item.args );
				} );
			}
		}

		static init()
		{
			this.check();

			window.addEventListener( this.events.resize, this.check, false );
		}
	};

	ReviewAbout.init();
	
	// let reviewAbout = new ReviewAbout();

	// reviewAbout.init();

	// const events = {
	// 	scroll: 'scroll',

	// 	resize: 'resize'
	// };

	// const items = [
	// 	{
	// 		event: events.scroll,

	// 		// action: initBonus,
			
	// 		action: state.initBonus,

	// 		args: { once: true }
	// 	},

	// 	{
	// 		event: events.scroll,

	// 		// action: checkState,
			
	// 		action: state.checkState,

	// 		args: false
	// 	}
	// ];

	// const itemsMobile = [
	// 	{
	// 		event: events.scroll,

	// 		// action: suspendBonus,
			
	// 		action: state.suspendBonus,

	// 		args: { once: true }
	// 	},

	// 	{
	// 		event: events.scroll,

	// 		// action: checkSticky,
			
	// 		action: state.checkSticky,

	// 		args: false
	// 	}
	// ];

	// function reviewAboutInit()
	// {
	// 	if ( window.matchMedia( '( min-width: 960px )' ).matches )
	// 	{
	// 		itemsMobile.forEach( function ( item ) {
	// 			document.removeEventListener( item.event, item.action, item.args );
	// 		} );

	// 		items.forEach( function ( item ) {
	// 			document.addEventListener( item.event, item.action, item.args );
	// 		} );

	// 		localStorage.setItem( 'reviewAboutScroll', 0 );
	// 	}
	// 	else
	// 	{
	// 		items.forEach( function ( item ) {
	// 			document.removeEventListener( item.event, item.action, item.args );
	// 		} );

	// 		itemsMobile.forEach( function ( item ) {
	// 			document.addEventListener( item.event, item.action, item.args );
	// 		} );
	// 	}
	// }

	// reviewAboutInit();

	// window.addEventListener( events.resize, reviewAboutInit, false );
} );

// review-about-js end