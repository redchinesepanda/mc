// review-gallery-swiper-js start

let reviewGalleySwiper = ( function()
{
	"use strict";

	return {
		swipeForward : 'swipeforward',

		swipeForwardEvent : function( valueID )
		{
			return new CustomEvent(
				this.swipeForward,

				{
					detail: {
						// id: () => id

						id: valueID
					},
				}
			)
		},

		swipeBackward : 'swipebackward',

		swipeBackwardEvent : function( valueID )
		{
			return new CustomEvent(
				this.swipeBackward,

				{
					detail: {
						// id: () => id
						
						id: valueID
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
				element.parentElement.dispatchEvent( reviewGalleyOops.oopsOpenEvent( element.dataset.id ) );
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

	const types = {
		touchstart: 'touchstart',

		touchend: 'touchend',
	};

	function setTouch( element )
	{
		initDataset( element );

		element.addEventListener( types.touchstart, handleTouchStart, false );
		element.addEventListener( types.touchend, handleTouchEnd, false );

		// element.addEventListener( types.touchend, handleTouchEnd, { passive: true }, false );

		// element.addEventListener( types.touchend, handleTouchMove, false );
	}

	const selectors = {
		imageset : '.tcb-post-content .legal-imageset',

		imagesetWrapper : '.tcb-post-content .legal-imageset-wrapper',

		imagesetOops : '.tcb-post-content .legal-imageset-oops'
	};

	function slider( element )
	{
		element.querySelectorAll( selectors.imageset ).forEach( setTouch );
	}

	document.querySelectorAll( selectors.imagesetWrapper ).forEach( slider );

	function oopsReady( event )
	{
		document.querySelectorAll( selectors.imagesetOops ).forEach( slider );
	}

	document.addEventListener( reviewGalleyOops.oopsReady, oopsReady, false );
	  
} );

// review-gallery-swiper-js end