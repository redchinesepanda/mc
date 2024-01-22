// review-gallery start

document.addEventListener( 'DOMContentLoaded', function ()
{
	// function popupNext( event )
	// {
	// 	let button = event.currentTarget;

	// 	let imageset = document.getElementById( button.dataset.imageset );

	// 	let next = button.dataset.next;

	// 	if( typeof next !== 'undefined' ) {
	// 		let item = imageset.querySelector( '.imageset-item[data-id="' + next + '"]' );

	// 		item.click();
	// 	}
	// }

	// function popupRemove( event )
	// {
	// 	if ( event.target === this ) {
	// 		event.currentTarget.remove();
	// 	}
	// }

	// function popup( event )
    // {
	// 	let content = document.querySelector( '.tcb-post-content' );

	// 	if ( content.querySelector( '.legal-gallery' ) === null ) {
	// 		let popup = document.createElement( 'div' );
		
	// 		popup.classList.add( 'legal-gallery' );

	// 		popup.addEventListener( 'click', popupRemove, false );

	// 		let left = document.createElement( 'div' );
			
	// 		left.classList.add( 'legal-left' );

	// 		left.addEventListener( 'click', popupNext, false );

	// 		popup.appendChild( left );

	// 		let right = document.createElement( 'div' );
			
	// 		right.classList.add( 'legal-right' );

	// 		right.addEventListener( 'click', popupNext, false );

	// 		popup.appendChild( right );

	// 		content.appendChild( popup );
	// 	}
	// }

	// function preload_image( url, popup )
	// {
	// 	let img = new Image();

	// 	img.onload = function()
	// 	{
	// 		popup.style.backgroundImage = 'url( \'' + this.src + '\' )';
	// 	};
	  
	// 	img.src = url;
	// } 

	// async function popupUpdate( event )
	// {
	// 	let item = event.currentTarget;

	// 	let content = document.querySelector( '.tcb-post-content' );
		
	// 	let popup = content.querySelector( '.legal-gallery' );
		
	// 	let url = item.querySelector( '.item-image' ).dataset.src;

	// 	preload_image( url, popup );

	// 	let left = popup.querySelector( '.legal-left' );

	// 	left.dataset.imageset = item.dataset.imageset;

	// 	if ( item.previousElementSibling !== null ) {
	// 		left.dataset.next = item.previousElementSibling.dataset.id;
	// 	}

	// 	let right = popup.querySelector( '.legal-right' );

	// 	right.dataset.imageset = item.dataset.imageset;

	// 	if ( item.nextElementSibling !== null ) {
	// 		right.dataset.next = item.nextElementSibling.dataset.id;
	// 	}
	// }

	function scrollX( element, shift )
	{
		let imageset = element.closest( selectors.imagesetWrapper )
			.querySelector( selectors.imageset );

		if ( imageset !== null )
		{
			// imageset.scroll({
			// 	top: 0,
	
			// 	left: shift,
	
			// 	behavior: "smooth",
			// });

			imageset.scrollLeft += shift;
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
				shift = itemActive.getBoundingClientRect().width
					+ window.getComputedStyle( imageset, null )
						.getPropertyValue( properties.columnGap )
						.match( /\d+/ );

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

// review-gallery-js end