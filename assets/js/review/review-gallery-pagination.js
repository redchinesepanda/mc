// review-gallery-pagination-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function pageForward( event )
	{
		let pageForward = event.currentTarget.querySelector( selectors.paginationItemActive ).nextSibling;

		if ( pageForward !== null )
		{
			event.currentTarget.classList.remove( classes.paginationItemActive );

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

		this.querySelector( selectors.imagesetPagination ).addEventListener( 'pageforward', pageForward, false );
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