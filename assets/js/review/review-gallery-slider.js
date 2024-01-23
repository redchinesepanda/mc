// review-gallery-slider-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function scrollX( element, shift )
	{
		// console.log( 'scrollX shift: ' + shift );

		let imageset = element.closest( selectors.imagesetWrapper )
			.querySelector( selectors.imageset );

		if ( imageset !== null )
		{
			imageset.scroll({
				top: 0,
	
				// left: shift,
				
				left: imageset.scrollLeft + shift,
	
				behavior: "smooth",
			});

			// imageset.scrollLeft += shift;
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

				// console.log( 'getShift columnGap: ' + window.getComputedStyle( imageset, null )
				// .getPropertyValue( properties.columnGap ).match( /\d+/ ) );

				// console.log( 'getShift width: ' + itemActive.getBoundingClientRect().width );
			}
		}

		return shift;
	}

	function scrollBackward( event )
	{
		// scrollX( event.currentTarget, -100 );

		scrollX( event.currentTarget, getShift( event.currentTarget ) * -1 );

		event.currentTarget
			.parentElement
			.querySelector( selectors.imagesetPagination )
			// .dispatchEvent( events.pageBackward( event.currentTarget.parentElement.dataset.id ) );
			.dispatchEvent( reviewGalleyPagination.pageBackwardEvent( event.currentTarget.parentElement.dataset.id ) );
	}

	function scrollForward( event )
	{
		// scrollX( event.currentTarget, 100 );
		
		scrollX( event.currentTarget, getShift( event.currentTarget ) );

		event.currentTarget
			.parentElement
			.querySelector( selectors.imagesetPagination )
			// .dispatchEvent( events.pageForward( event.currentTarget.parentElement.dataset.id ) );
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

	function setSwipeForward( element )
	{
		element.addEventListener( reviewGalleySwipe.swipeForward, scrollForward );
	}

	function setSwipeBackward( element )
	{
		element.addEventListener( reviewGalleySwipe.swipeBackward, scrollBackward );
	}

	function slider( element, index )
	{
		// element.classList.add( classes.imagesetWrapperCurrent( index ) );
		
		element.dataset.id = classes.imagesetWrapperCurrent( index );

		element.querySelectorAll( selectors.imagesetBackward ).forEach( setBackward );

		element.querySelectorAll( selectors.imagesetForward ).forEach( setForward );
	
		element.querySelectorAll( selectors.imageset ).forEach( setSwipeForward );

		element.querySelectorAll( selectors.imageset ).forEach( setSwipeBackward );
	}

	// const events = {
	// 	pageForward : function( id )
	// 	{
	// 		return new CustomEvent(
	// 			'pageforward',

	// 			{
	// 				detail: {
	// 					id: () => id
	// 				},
	// 			}
	// 		)
	// 	},

	// 	pageBackward : function( id )
	// 	{
	// 		return new CustomEvent(
	// 			'pagebackward',

	// 			{
	// 				detail: {
	// 					id: () => id
	// 				},
	// 			}
	// 		)
	// 	}
	// };

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

		imagesetPagination : '.imageset-pagination'
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
	  
} );

// review-gallery-slider-js end