// review-gallery-slider-js start

let reviewGalleySlider = ( function()
{
	"use strict";

	return {
		click : 'click',
	};
} )();

document.addEventListener( 'DOMContentLoaded', function ()
{
	function scrollX( element, shift )
	{
		let imageset = element.closest( selectors.imagesetWrapper )
			.querySelector( selectors.imageset );

		if ( imageset !== null )
		{
			imageset.scroll( {
				top: 0,
				
				left: imageset.scrollLeft + shift,
	
				behavior: "smooth",
			} );
		}
	}

	function getShift( element )
	{
		let shift = 0;

		let imageset = element.closest( selectors.imagesetWrapper )
			.querySelector( selectors.imageset );

		if ( imageset !== null )
		{
			let itemActive = imageset.querySelector( selectors.imageActive );

			if ( itemActive !== null )
			{
				shift = parseInt( itemActive.getBoundingClientRect().width )
					+ parseInt( window.getComputedStyle( imageset, null )
						.getPropertyValue( properties.columnGap )
						.match( /\d+/ ) );

				// console.log( 'getShift columnGap: ' + parseInt( window.getComputedStyle( imageset, null )
				// .getPropertyValue( properties.columnGap )
				// .match( /\d+/ ) ) );

				// console.log( 'getShift width: ' + parseInt( itemActive.getBoundingClientRect().width ) );

				// console.log( 'getShift shift: ' + shift );
			}
		}

		return shift;
	}

	function scrollBackward( event )
	{
		scrollX( event.currentTarget, getShift( event.currentTarget ) * -1 );

		event.currentTarget
			.parentElement
			.querySelector( selectors.imagesetPagination )
			.dispatchEvent( reviewGalleyPagination.pageBackwardEvent( event.currentTarget.parentElement.dataset.id ) );
	}

	function scrollForward( event )
	{
		scrollX( event.currentTarget, getShift( event.currentTarget ) );

		event.currentTarget
			.parentElement
			.querySelector( selectors.imagesetPagination )
			.dispatchEvent( reviewGalleyPagination.pageForwardEvent( event.currentTarget.parentElement.dataset.id ) );
	}

	function setBackward( element )
	{
		element.addEventListener( 'click', scrollBackward );
	}

	function setForward( element )
	{
		element.addEventListener( 'click', scrollForward );
	}

	// function setSwipeForward( element )
	// {
	// 	element.addEventListener( reviewGalleySwiper.swipeForward, scrollForward );
	// }

	// function setSwipeBackward( element )
	// {
	// 	element.addEventListener( reviewGalleySwiper.swipeBackward, scrollBackward );
	// }

	function oopsOpen( event )
	{
		event.currentTarget.parentElement.dispatchEvent( reviewGalleyOops.oopsOpenEvent( event.currentTarget.dataset.id ) );

		console.log( 'handleSwipe click' );
	}

	function setSwipe( element )
	{
		element.addEventListener( reviewGalleySwiper.swipeForward, scrollForward );

		element.addEventListener( reviewGalleySwiper.swipeBackward, scrollBackward );

		element.addEventListener( reviewGalleySlider.click, oopsOpen );
	}

	function slider( element, index )
	{
		element.dataset.id = classes.imagesetWrapperCurrent( index );

		element.querySelectorAll( selectors.imagesetBackward ).forEach( setBackward );

		element.querySelectorAll( selectors.imagesetForward ).forEach( setForward );
	
		// element.querySelectorAll( selectors.imageset ).forEach( setSwipeForward );

		// element.querySelectorAll( selectors.imageset ).forEach( setSwipeBackward );

		element.querySelectorAll( selectors.imageset ).forEach( setSwipe );
	}

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

		imageActive : ' .legal-active',

		imagesetPagination : '.imageset-pagination',
		
		imagesetOops : '.tcb-post-content .legal-imageset-oops'
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
	
	document.querySelectorAll( selectors.imagesetWrapper ).forEach( slider );

	function setActive( element )
	{
		element.classList.add( classes.imageActive );
	}

	document.querySelectorAll( selectors.imageFirst() ).forEach( setActive );

	function oopsReady( event )
	{
		document.querySelectorAll( selectors.imagesetOops ).forEach( slider );
	}

	document.addEventListener( reviewGalleyOops.oopsReady, oopsReady, false );
	  
} );

// review-gallery-slider-js end