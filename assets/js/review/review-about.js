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

	class State {
		static classes = {
			moved: 'moved-bonus',

			sticky: 'sticky-bonus',

			animated: 'animated-bonus',
		}

		// static modify ( action )
		// {
		// 	document.querySelectorAll(
		// 		[ selectors.sidebarBonus, selectors.sidebarAction ].join( ', ' )
		// 	).forEach( action );
		// }

		static getElements () {
			return document.querySelectorAll( [ selectors.sidebarBonus, selectors.sidebarAction ].join( ', ' ) );
		}
		
		static setMoved ( element )
		{
			element.classList.add( this.classes.moved );
		}

		static suspendMoved ( element )
		{
			element.classList.remove( this.classes.moved );
		}

		static setSticky ( element )
		{
			element.classList.add( this.classes.sticky );
		}

		static suspendSticky ( element )
		{
			element.classList.remove( this.classes.sticky );
		}

		static suspendBonus ( event )
		{
			// this.modify( this.suspendMoved );
			
			// State.modify( State.suspendMoved );

			// console.log( this.getElements() );

			// this.getElements().forEach( this.suspendMoved );

			this.getElements().forEach( this.suspendMoved.bind( this ) );
			
			// this.getElements().forEach( State.suspendMoved );
			
			// this.getElements().forEach( function ( element ) {
			// 	State.suspendMoved( element );
			// } );
		}

		static initBonus ( event )
		{
			this.modify( this.setMoved );

			// this.getElements().forEach( this.setMoved );
		}

		static checkState ( event )
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
		}

		static checkSticky ( event )
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
	
	class ReviewAbout {
		static events = {
			scroll: 'scroll',
	
			resize: 'resize'
		}

		static items = [
			{
				event : this.events.scroll,
				
				action : State.initBonus,
	
				args : { once : true }
			},
	
			{
				event : this.events.scroll,
				
				action : State.checkState,
	
				args : false
			}
		]

		static itemsMobile = [
			{
				event : this.events.scroll,
				
				// action : State.suspendBonus,
				
				action : function( event )
				{
					State.suspendBonus( event.currentTarget );
				},
	
				args : { once : true }
			},
	
			{
				event : this.events.scroll,
				
				// action : State.checkSticky,

				action : function( event )
				{
					State.checkSticky( event.currentTarget );
				},
	
				args : false
			}
		]

		static media = {
			mobile : '( min-width: 960px )'
		}

		static check()
		{
			if ( window.matchMedia( this.media.mobile ).matches )
			{
				this.itemsMobile.forEach( function ( item ) {
					document.removeEventListener( item.event, item.action, item.args );
				} );
	
				this.items.forEach( function ( item ) {
					document.addEventListener( item.event, item.action, item.args );
				} );

				Storage.suspendState();
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