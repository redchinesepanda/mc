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

		oopsReady : 'oopsready',

		oopsReadyEvent : function( id )
		{
			return new CustomEvent(
				this.oopsReady,

				{
					detail: {
						id: () => id
					},
				}
			)
		},

		click : 'click',
		// click : 'pointerup',
	};
} )();

document.addEventListener( 'DOMContentLoaded', function ()
{
	function oopsRemove( event )
	{
		if ( event.target === event.currentTarget )
		{
			event.currentTarget.remove();
		}
	}

	function preloadSrc( element, src )
	{
		let image = new Image();

		image.onload = function()
		{
			element.src = this.src;

			this.remove();
		};
	  
		image.src = src;
	}

	function setSrc( element )
	{
		preloadSrc( element, element.dataset.src );

		element.removeAttribute( 'width' );

		element.removeAttribute( 'height' );
	}

	function oopsOpen( event )
	{
		let imagesetOops = event.currentTarget.cloneNode( true );

		imagesetOops.classList.add( classes.imagesetOops );

		imagesetOops.querySelectorAll( selectors.itemImage ).forEach( setSrc );

		imagesetOops.addEventListener( reviewGalleyOops.click, oopsRemove, false );

		event.currentTarget.parentElement.insertBefore( imagesetOops, event.currentTarget );

		document.dispatchEvent( reviewGalleyOops.oopsReadyEvent( event.currentTarget.dataset.id ) );
	}

	const selectors = {
		imageset : '.tcb-post-content .legal-imageset',

		imagesetWrapper : '.tcb-post-content .legal-imageset-wrapper',

		itemImage : '.item-image'
	};

	const classes = {
		imagesetWrapperActive : 'legal-active',

		imagesetOops : 'legal-imageset-oops'
	};

	function oops( element )
	{
		element.addEventListener( reviewGalleyOops.oopsOpen, oopsOpen, false );
		// element.addEventListener( reviewGalleyOops.oopsOpen, oopsOpen, { passive: true } );
	}

	document.querySelectorAll( selectors.imagesetWrapper ).forEach( oops );
	  
} );

// review-gallery-swiper-js end