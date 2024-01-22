// review-gallery-slider-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function scrollX( element, shift )
	{
		console.log( 'scrollX shift: ' + shift );

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

	function scrollfBackward( event )
	{
		// scrollX( event.currentTarget, -100 );

		scrollX( event.currentTarget, getShift( event.currentTarget ) * -1 );
	}

	function scrollForward( event )
	{
		// scrollX( event.currentTarget, 100 );
		
		scrollX( event.currentTarget, getShift( event.currentTarget ) );
	}

	function setBackward( element )
	{
		element.addEventListener( 'click', scrollfBackward );
	}

	function setForward( element )
	{
		element.addEventListener( 'click', scrollForward );
	}

	function slider( element, index )
	{
		element.classList.add( classes.imagesetWrapperCurrent( index ) );

		element.querySelectorAll( selectors.imagesetBackward ).forEach( setBackward );

		element.querySelectorAll( selectors.imagesetForward ).forEach( setForward );
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
	
	document.querySelectorAll( selectors.imagesetWrapper ).forEach( slider );

	function setActive( element )
	{
		element.classList.add( classes.imageActive );
	}

	document.querySelectorAll( selectors.imageFirst() ).forEach( setActive );
	  
} );

// review-gallery-slider-js end