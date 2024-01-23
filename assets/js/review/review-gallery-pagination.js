// review-gallery-pagination-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	// function handleSwipe( element )
	// {
	// 	if ( element.dataset.touchendX - element.dataset.touchstartX < 0 )
	// 	{
	// 		element.dispatchEvent( events.swipeForward( element.dataset.id ) );
	// 	}
	// 	else
	// 	{
	// 		element.dispatchEvent( events.swipeBackward( element.dataset.id ) );
	// 	}
	// }

	// function handleTouchStart( event )
	// {
	// 	event.preventDefault();
		
	// 	event.currentTarget.dataset.touchstartX = event.changedTouches[0].screenX;
	// }

	// function handleTouchEnd( event )
	// {
	// 	event.preventDefault();

	// 	event.currentTarget.dataset.touchendX = event.changedTouches[0].screenX;

	// 	handleSwipe( event.currentTarget );
	// }

	// function initDataset( element )
	// {
	// 	element.dataset.touchstartX = 0;

	// 	element.dataset.touchendX = 0;
	// }

	// function setTouch( element )
	// {
	// 	initDataset( element );

	// 	element.addEventListener( 'touchstart', handleTouchStart, false );

	// 	element.addEventListener( 'touchend', handleTouchEnd, false );
	// }

	function pageForward( element )
	{
		let pageForward = element.querySelector( selectors.paginationItemActive ).nextSibling;

		if ( pageForward !== null )
		{
			element.classList.remove( classes.paginationItemActive );

			pageForward.classList.add( classes.paginationItemActive );
		}
	}
	
	function addPaginationItem( element )
	{
		const paginationItem = document.createElement( 'div' );

		paginationItem.classList.add( classes.paginationItem );

		this.querySelector( selectors.imagesetPagination ).appendChild( paginationItem );
	}

	function initPagination( element )
	{
		console.log( element.querySelectorAll( selectors.offScreen ).length );

		element.querySelectorAll( selectors.offScreen ).forEach( addPaginationItem, this );

		this.querySelector( selectors.imagesetPagination ).addEventListener( 'pageForward', pageForward, false );
	}

	function checkOffscreen( element )
	{
		// console.log( 'checkOffscreen' );

		// console.log( 'element left: ' + element.getBoundingClientRect().left );

		// console.log( 'element right: ' + element.getBoundingClientRect().right );

		// console.log( 'wrapper right: ' + this.getBoundingClientRect().right );

		if ( element.getBoundingClientRect().right > this.getBoundingClientRect().right )
		{
			element.classList.add( classes.offScreen );
		}
	}

	const events = {
		pageForward : function( id )
		{
			return new CustomEvent(
				'pageforward',

				{
					detail: {
						id: () => id
					},
				}
			)
		},

		pageBackward : function( id )
		{
			return new CustomEvent(
				'pagebackward',

				{
					detail: {
						id: () => id
					},
				}
			)
		}
	};

	const selectors = {
		imageset : '.tcb-post-content .legal-imageset',

		imagesetWrapper : '.tcb-post-content .legal-imageset-wrapper',

		imagesetItem : '.tcb-post-content .legal-imageset-wrapper .imageset-item',

		offScreen : '.legal-off-screen',

		imagesetPagination : '.imageset-pagination',
		
		paginationItemActive : '.legal-active'
	};
	
	const classes = {
		offScreen : 'legal-off-screen',

		paginationItem : 'pagination-item',

		paginationItemActive : 'legal-active'
	};

	function setPagination( element )
	{
		// console.log( this ); 

		element.querySelectorAll( selectors.imagesetItem ).forEach( checkOffscreen, this );

		// initDataset( element );

		// element.addEventListener( 'touchstart', handleTouchStart, false );

		// element.addEventListener( 'touchend', handleTouchEnd, false );
	}

	function slider( element )
	{
		// console.log( element.classList );

		element.querySelectorAll( selectors.imageset ).forEach( setPagination, element );

		element.querySelectorAll( selectors.imageset ).forEach( initPagination, element );
	}

	document.querySelectorAll( selectors.imagesetWrapper ).forEach( slider );
	  
} );

// review-gallery-pagination-js end