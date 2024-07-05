// review-gallery-slider-js start

let reviewGalleySlider = ( function()
{
	"use strict";

	return {
		click : 'click',

		selectors : {
			imagesetWrapper : '.tcb-post-content .legal-imageset-wrapper',

			imageset : '.tcb-post-content .legal-imageset',
	
			imageActive : ' .imageset-item.legal-active'
		},

		properties : {
			columnGap : 'column-gap',
		},

		getShift : function ( element )
		{
			let shift = 0;

			let imageset = element.closest( this.selectors.imagesetWrapper )
				.querySelector( this.selectors.imageset );

			if ( imageset !== null )
			{
				let itemActive = imageset.querySelector( this.selectors.imageActive );

				if ( itemActive !== null )
				{
					shift = parseInt( itemActive.getBoundingClientRect().width )
						+ parseInt( window.getComputedStyle( imageset, null )
							.getPropertyValue( this.properties.columnGap )
							.match( /\d+/ ) );
				}
			}

			return shift;
		},

		scrollX : function ( element, shift = null )
		{
			let imageset = element.closest( this.selectors.imagesetWrapper )
				.querySelector( this.selectors.imageset );

			if ( imageset !== null )
			{
				let scrollArgs = {
					top: 0,
					
					left: 0,
		
					behavior: 'instant',
				};

				if ( shift !== null )
				{
					scrollArgs = {
						top: 0,
						
						left: imageset.scrollLeft + shift,
			
						behavior: 'smooth',
					};
				}

				imageset.scroll( scrollArgs );
			}
		},

		scrollSatrt : function ( element )
		{
			let imageset = element.closest( this.selectors.imagesetWrapper )
				.querySelector( this.selectors.imageset );

			if ( imageset !== null )
			{
				imageset.scroll( {
					top: 0,
					
					left: 0,
		
					behavior: "smooth",
				} );
			}
		}
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

	function scrollBackward( event )
	{
		scrollX( event.currentTarget, reviewGalleySlider.getShift( event.currentTarget ) * -1 );

		event.currentTarget
			.parentElement
			.querySelector( selectors.imagesetPagination )
			.dispatchEvent( reviewGalleyPagination.pageBackwardEvent( event.currentTarget.parentElement.dataset.id ) );
	}

	function scrollForward( event )
	{
		scrollX( event.currentTarget, reviewGalleySlider.getShift( event.currentTarget ) );

		event.currentTarget
			.parentElement
			.querySelector( selectors.imagesetPagination )
			.dispatchEvent( reviewGalleyPagination.pageForwardEvent( event.currentTarget.parentElement.dataset.id ) );
	}

	function setActive( element )
	{
		element.addEventListener( 'click', scrollActive );
	}

	function setBackward( element )
	{
		element.addEventListener( 'click', scrollBackward );
	}

	function setForward( element )
	{
		element.addEventListener( 'click', scrollForward );
	}

	function oopsOpen( event )
	{
		if ( event.currentTarget.contains( event.target ) )
		{
			setActive( event.target.closest( selectors.imagesetItem ) );
		}
	
		event.currentTarget.parentElement.dispatchEvent( reviewGalleyOops.oopsOpenEvent( event.currentTarget.dataset.id ) );

		// reviewGalleySlider.scrollX( event.currentTarget, null );
	}

	function setSwipe( element )
	{
		element.addEventListener( reviewGalleySwiper.swipeForward, scrollForward );

		element.addEventListener( reviewGalleySwiper.swipeBackward, scrollBackward );

		if ( !element.parentElement.classList.contains( classes.imagesetOops ) )
		{
			element.addEventListener( reviewGalleySlider.click, oopsOpen );
		}
	}

	function slider( element, index )
	{
		element.dataset.id = classes.imagesetWrapperCurrent( index ) + this.suffix;

		element.querySelectorAll( selectors.imagesetBackward ).forEach( setBackward );

		element.querySelectorAll( selectors.imagesetForward ).forEach( setForward );

		element.querySelectorAll( selectors.imageset ).forEach( setSwipe );
	}

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

		imageActive : ' .imageset-item.legal-active',

		imagesetPagination : '.imageset-pagination',

		imagesetOops : '.tcb-post-content .legal-imageset-oops',

		imagesetItem : '.imageset-item'
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

		imageActive : 'legal-active',
		
		imagesetOops : 'legal-imageset-oops'
	};

	function suspendActive( element )
	{
		element.classList.remove( classes.imageActive );
	}

	function setActive( element )
	{
		element.closest( selectors.imageset ).querySelectorAll( selectors.imagesetItem ).forEach( suspendActive );

		element.classList.add( classes.imageActive );
	}

	document.querySelectorAll( selectors.imageFirst() ).forEach( setActive );
	
	document.querySelectorAll( selectors.imagesetWrapper ).forEach( slider, { suffix : '-main' } );

	function oopsReady( event )
	{
		document.querySelectorAll( selectors.imagesetOops ).forEach( slider, { suffix : '-oops' } );
	}

	document.addEventListener( reviewGalleyOops.oopsReady, oopsReady, false );
	  
} );

// review-gallery-slider-js end