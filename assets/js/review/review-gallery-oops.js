// review-gallery-swiper-js start

let reviewGalleyOops = ( function()
{
	"use strict";

	return {
		oopsOpen : 'oopsopen',

		oopsOpenEvent : function( id )
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
	};
} )();

document.addEventListener( 'DOMContentLoaded', function ()
{
	function oopsOpen( event )
	{
		event.currentTarget.classList.add( classes.imagesetWrapperActive );
	}

	const selectors = {
		imageset : '.tcb-post-content .legal-imageset',

		imagesetWrapper : '.tcb-post-content .legal-imageset-wrapper'
	};

	const classes = {
		imagesetWrapperActive : 'legal-active'
	};

	function oops( element )
	{
		element.addEventListener( reviewGalleyOops.oopsOpen, oopsOpen, false );
	}

	document.querySelectorAll( selectors.imagesetWrapper ).forEach( oops );
	  
} );

// review-gallery-swiper-js end