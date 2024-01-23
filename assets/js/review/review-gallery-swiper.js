// review-gallery-swipe-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function handleSwipe( element )
	{
		if ( element.dataset.touchendX - element.dataset.touchstartX < 0 )
		{
			element.dispatchEvent( events.swipeForward( element.dataset.id ) );

			console.log( events.swipeForward( element.dataset.id ) );

			console.log( "right" );
		}
		else
		{
			console.log( "left" );
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

		swipebackward : function( id )
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

	const properties = {
		columnGap : 'column-gap',
	};

	const selectors = {
		imageset : '.tcb-post-content .legal-imageset',

		imagesetWrapper : '.tcb-post-content .legal-imageset-wrapper',

		imagesetCurrent : function( index )
		{
			return '.legal-imageset-' + index;
		},

		imagesetWrapperCurrent : function( index )
		{
			return '.legal-imageset-wrapper-' + index;
		},

		imagesetBackward : '.imageset-backward',

		imagesetForward : '.imageset-forward',
		
		imageFirst : function()
		{
			return this.imageset + ' .imageset-item:first-of-type';
		},

		imageActive : ' .legal-active'
	};

	const classes = {
		imagesetCurrent : function( index )
		{
			return 'legal-imageset-' + index;
		},

		imagesetWrapperCurrent : function( index )
		{
			return 'legal-imageset-wrapper-' + index;
		},

		imageActive : 'legal-active'
	};

	console.log( selectors.imagesetWrapper );
	
	// document.querySelectorAll( selectors.imagesetWrapper ).forEach( setTouch );

	function slider( element )
	{
		element.querySelectorAll( selectors.imageset ).forEach( setTouch );
	}

	document.querySelectorAll( selectors.imagesetWrapper ).forEach( slider );
	
	// document.querySelectorAll( selectors.imagesetWrapper ).forEach( slider );

	// function setActive( element )
	// {
	// 	element.classList.add( classes.imageActive );
	// }

	// document.querySelectorAll( selectors.imageFirst() ).forEach( setActive );
	  
} );

// review-gallery-swipe-js end