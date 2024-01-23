// review-gallery-swipe-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function handleSwipe( element )
	{
		if ( element.dataset.touchendX - element.dataset.touchstartX < 0 )
		{
			element.dispatchEvent( events.swipeForward( element.dataset.id ) );
		}
		else
		{
			element.dispatchEvent( events.swipeBackward( element.dataset.id ) );
		}
	}

	function handleTouchStart( event )
	{
		event.preventDefault();
		
		event.currentTarget.dataset.touchstartX = event.changedTouches[0].screenX;
	}

	function handleTouchEnd( event )
	{
		event.preventDefault();

		event.currentTarget.dataset.touchendX = event.changedTouches[0].screenX;

		handleSwipe( event.currentTarget );
	}

	function initDataset( element )
	{
		element.dataset.touchstartX = 0;

		element.dataset.touchendX = 0;
	}

	function setTouch( element )
	{
		initDataset( element );

		element.addEventListener( 'touchstart', handleTouchStart, false );

		element.addEventListener( 'touchend', handleTouchEnd, false );
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

		imagesetWrapper : '.tcb-post-content .legal-imageset-wrapper'
	};

	console.log( selectors.imagesetWrapper );

	function slider( element )
	{
		element.querySelectorAll( selectors.imageset ).forEach( setTouch );
	}

	document.querySelectorAll( selectors.imagesetWrapper ).forEach( slider );
	  
} );

// review-gallery-swipe-js end