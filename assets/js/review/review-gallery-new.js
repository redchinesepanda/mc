// review-gallery start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function popupNext( event )
	{
		let button = event.currentTarget;

		let imageset = document.getElementById( button.dataset.imageset );

		let next = button.dataset.next;

		if( typeof next !== 'undefined' ) {
			let item = imageset.querySelector( '.imageset-item[data-id="' + next + '"]' );

			item.click();
		}
	}

	function popupRemove( event )
	{
		if ( event.target === this ) {
			event.currentTarget.remove();
		}
	}

	function popup( event )
    {
		let content = document.querySelector( '.tcb-post-content' );

		if ( content.querySelector( '.legal-gallery' ) === null ) {
			let popup = document.createElement( 'div' );
		
			popup.classList.add( 'legal-gallery' );

			popup.addEventListener( 'click', popupRemove, false );

			let left = document.createElement( 'div' );
			
			left.classList.add( 'legal-left' );

			left.addEventListener( 'click', popupNext, false );

			popup.appendChild( left );

			let right = document.createElement( 'div' );
			
			right.classList.add( 'legal-right' );

			right.addEventListener( 'click', popupNext, false );

			popup.appendChild( right );

			content.appendChild( popup );
		}
	}

	function preload_image( url, popup )
	{
		let img = new Image();

		img.onload = function()
		{
			popup.style.backgroundImage = 'url( \'' + this.src + '\' )';
		};
	  
		img.src = url;
	} 

	async function popupUpdate( event )
	{
		let item = event.currentTarget;

		let content = document.querySelector( '.tcb-post-content' );
		
		let popup = content.querySelector( '.legal-gallery' );
		
		let url = item.querySelector( '.item-image' ).dataset.src;

		preload_image( url, popup );

		let left = popup.querySelector( '.legal-left' );

		left.dataset.imageset = item.dataset.imageset;

		if ( item.previousElementSibling !== null ) {
			left.dataset.next = item.previousElementSibling.dataset.id;
		}

		let right = popup.querySelector( '.legal-right' );

		right.dataset.imageset = item.dataset.imageset;

		if ( item.nextElementSibling !== null ) {
			right.dataset.next = item.nextElementSibling.dataset.id;
		}
	}

	// document.querySelectorAll( '.tcb-post-content .legal-imageset' ).forEach( function ( imageset, index ) {
	// 	imageset.id = 'imageset-' + index;

	// 	imageset.querySelectorAll( '.imageset-item' ).forEach( function ( item, index ) {

	// 		item.dataset.imageset = imageset.id;

	// 		item.dataset.id = index;

	// 		item.addEventListener( 'click', popup, false );

	// 		item.addEventListener( 'click', popupUpdate, false );
	// 	} );
	// } );

	// const swiper = new Swiper( '.swiper-container', {
	// 	// Optional parameters
	// 	// direction: 'vertical',
	// 	direction: 'horizontal',

	// 	// loop: true,
	// 	loop: false,
	  
	// 	// If we need pagination
	// 	pagination: {
	// 	  el: '.swiper-pagination',
	// 	},
	  
	// 	// Navigation arrows
	// 	navigation: {
	// 	  nextEl: '.swiper-button-next',

	// 	  prevEl: '.swiper-button-prev',
	// 	},
	  
	// 	// And if we need scrollbar
	// 	// scrollbar: {
	// 	//   el: '.swiper-scrollbar',
	// 	// },
	// });

	function swiper( element, index )
	{
		element.classList.add( classes.imagesetWrapperCurrent( index ) );

		let mySwiper = new Swiper ( selectors.imagesetWrapperCurrent( index ), {
			speed: 400,
			spaceBetween: 100,
			initialSlide: 0,
			//truewrapper adoptsheight of active slide
			autoHeight: false,
			// Optional parameters
			direction: 'horizontal',
			loop: true,
			// delay between transitions in ms
			autoplay: 5000,
			autoplayStopOnLast: false, // loop false also
			// If we need pagination
			pagination: selectors.imagesetWrapperCurrent( index ) + ' .swiper-pagination',
			paginationType: "bullets",
			
			// Navigation arrows
			nextButton: selectors.imagesetWrapperCurrent( index ) + ' .swiper-button-next',
			prevButton: selectors.imagesetWrapperCurrent( index ) + ' .swiper-button-prev',
			
			// And if we need scrollbar
			//scrollbar: '.swiper-scrollbar',
			// "slide", "fade", "cube", "coverflow" or "flip"
			effect: 'slide',
			// Distance between slides in px.
			spaceBetween: 60,
			//
			slidesPerView: 2,
			//
			centeredSlides: true,
			//
			slidesOffsetBefore: 0,
			//
			grabCursor: true,
		} ); 
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
		}
	};

	const classes = {
		imagesetCurrent : function( index )
		{
			return 'legal-imageset-' + index;
		},

		imagesetWrapperCurrent : function( index )
		{
			return 'legal-imageset-wrapper-' + index;
		}
	};
	
	document.querySelectorAll( selectors.imagesetWrapper ).forEach( swiper );
	  
} );

// review-gallery-js end