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

		static modify ( action )
		{
			document.querySelectorAll(
				[ selectors.sidebarBonus, selectors.sidebarAction ].join( ', ' )
			).forEach( action );
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

		// static suspendBonus ( event )
		// {
		// 	this.modify( this.suspendMoved.bind( this ) );
		// }

		// static initBonus ( event )
		// {
		// 	this.modify( this.setMoved.bind( this ) );
		// }

		// static suspendBonus ( event )
		// {
		// 	this.modify( this.suspendMoved.bind( this ) );
		// }

		// static initBonus ( event )
		// {
		// 	this.modify( this.setMoved.bind( this ) );
		// }

		// static checkState ( event )
		
		static checkMoved ( event )
		{
			if ( scroll.checkMoved() && storage.checkStateSuspended() )
			{
				storage.initState();
				
				this.modify( this.setMoved.bind( this ) );
			}

			if ( scroll.checkMovedBack() && storage.checkStateReady() )
			{
				storage.suspendState();
				
				this.modify( this.suspendMoved.bind( this ) );
			}
		}

		static checkSticky ( event )
		{
			if ( scroll.checkSticky && storage.checkStateSuspended() )
			{
				storage.initState();

				this.modify( this.setSticky.bind( this ) );
			}

			if ( scroll.checkStickyBack() && storage.checkStateReady() )
			{
				storage.suspendState();

				this.modify( this.suspendSticky.bind( this ) );
			}
		}
	};
	
	class ReviewAbout {
		static events = {
			scroll: 'scroll',
	
			resize: 'resize'
		}

		static items = [
			// {
			// 	event : this.events.scroll,

			// 	action : State.suspendSticky.bind( State ),
	
			// 	args : { once : true }
			// },

			// {
			// 	event : this.events.scroll,

			// 	action : State.initBonus.bind( State ),
	
			// 	args : { once : true }
			// },
	
			{
				event : this.events.scroll,

				action : State.checkMoved.bind( State ),
	
				args : false
			}
		]

		static itemsMobile = [
			// {
			// 	event : this.events.scroll,

			// 	action : State.suspendMoved.bind( State ),
	
			// 	args : { once : true }
			// },

			// {
			// 	event : this.events.scroll,

			// 	action : State.suspendBonus.bind( State ),
	
			// 	args : { once : true }
			// },
	
			{
				event : this.events.scroll,
				
				action : State.checkSticky.bind( State ),
	
				args : false
			}
		]

		static mediaQuery = {
			desktop : '( min-width: 960px )'
		}

		static removeEvents( item )
		{
			document.removeEventListener( item.event, item.action, item.args );
		}

		static addEvents( item )
		{
			document.addEventListener( item.event, item.action, item.args );
		}

		static initDesktop()
		{
			State.modify( State.suspendSticky.bind( State ) );

			this.itemsMobile.forEach( this.removeEvents );

			this.items.forEach( this.addEvents );

			// this.itemsMobile.forEach( function ( item ) {
			// 	document.removeEventListener( item.event, item.action, item.args );
			// } );

			// this.items.forEach( function ( item ) {
			// 	document.addEventListener( item.event, item.action, item.args );
			// } );

			// storage.suspendState();
		}

		static initMobile()
		{
			State.modify( State.suspendMoved.bind( State ) );

			this.items.forEach( this.removeEvents );

			this.itemsMobile.forEach( this.addEvents );
		}

		static check()
		{
			storage.suspendState();

			if ( window.matchMedia( this.mediaQuery.desktop ).matches )
			{
				this.initDesktop();
			}
			else
			{
				this.initMobile();
			}
		}

		static init()
		{
			this.check();

			window.addEventListener( this.events.resize, this.check.bind( this ), false );
		}
	};

	ReviewAbout.init();
} );

// review-about-js end