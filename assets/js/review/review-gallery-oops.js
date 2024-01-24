// review-gallery-swiper-js start

let reviewGalleyOops = ( function()
{
	"use strict";

	return {
		oopsOpen : 'oopsopen',

		oopsOpenEvent : function( id )
		{
			return new CustomEvent(
				this.oopsOpen,

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
		console.log( 'oopsOpen' );

		// console.log( event.currentTarget );

		// event.currentTarget.classList.toggle( classes.imagesetWrapperActive );

		let imagesetOops = event.currentTarget.cloneNode( true );

		imagesetOops.classList.add( classes.imagesetOops );

		event.currentTarget.parentElement.insertBefore( imagesetOops, event.currentTarget );
	}

	const selectors = {
		imageset : '.tcb-post-content .legal-imageset',

		imagesetWrapper : '.tcb-post-content .legal-imageset-wrapper'
	};

	const classes = {
		imagesetWrapperActive : 'legal-active',

		imagesetOops : 'legal-imageset-oops'
	};

	function oops( element )
	{
		element.addEventListener( reviewGalleyOops.oopsOpen, oopsOpen, false );
	}

	document.querySelectorAll( selectors.imagesetWrapper ).forEach( oops );
	  
} );

// review-gallery-swiper-js end