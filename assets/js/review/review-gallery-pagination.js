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

	function checkOffscreen( element )
	{
		console.log( 'checkOffscreen' );

		console.log( element.getBoundingClientRect().right );

		console.log( this.clientWidth );
	}

	const events = {
		swipeForward : function( id )
		{
			return new CustomEvent(
				'swipeforward',

				{
					detail: {
						id: () => id
					},
				}
			)
		},

		swipeBackward : function( id )
		{
			return new CustomEvent(
				'swipebackward',

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

		imagesetItem : '.tcb-post-content .legal-imageset-wrapper .imageset-item'
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
		console.log( element.classlist );
		
		element.querySelectorAll( selectors.imageset ).forEach( setPagination, element );
	}

	document.querySelectorAll( selectors.imagesetWrapper ).forEach( slider );
	  
} );

// review-gallery-pagination-js end