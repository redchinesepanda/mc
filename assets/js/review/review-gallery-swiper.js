// review-gallery-swiper-js start

let reviewGalleySwiper = ( function()
{
	"use strict";

	return {
		swipeForward : 'swipeforward',

		swipeForwardEvent : function( id )
		{
			return new CustomEvent(
				this.swipeForward,

				{
					detail: {
						id: () => id
					},
				}
			)
		},

		swipeBackward : 'swipebackward',

		swipeBackwardEvent : function( id )
		{
			return new CustomEvent(
				this.swipeBackward,

				{
					detail: {
						id: () => id
					},
				}
			)
		}
	};
} )();

document.addEventListener( 'DOMContentLoaded', function ()
{
	function handleSwipe( element )
	{
		if ( element.dataset.touchendX - element.dataset.touchstartX < 0 )
		{
			element.dispatchEvent( reviewGalleySwiper.swipeForwardEvent( element.dataset.id ) );
		}
		else
		{
			if ( element.dataset.touchendX - element.dataset.touchstartX > 0 )
			{
				element.dispatchEvent( reviewGalleySwiper.swipeBackwardEvent( element.dataset.id ) );
			}
			else
			{
				element.dispatchEvent( reviewGalleyOops.oopsOpenEvent( element.dataset.id ) );

				console.log( reviewGalleyOops.oopsOpenEvent( element.dataset.id ) );
			}
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

	const selectors = {
		imageset : '.tcb-post-content .legal-imageset',

		imagesetWrapper : '.tcb-post-content .legal-imageset-wrapper'
	};

	function slider( element )
	{
		element.querySelectorAll( selectors.imageset ).forEach( setTouch );
	}

	document.querySelectorAll( selectors.imagesetWrapper ).forEach( slider );
	  
} );

// review-gallery-swiper-js end