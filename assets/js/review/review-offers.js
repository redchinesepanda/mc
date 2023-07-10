// review-offers start

document.addEventListener( 'DOMContentLoaded', function ()
{
	// const slidesContainer = document.getElementById( 'legal-other-offers' );

	document.querySelectorAll( '.legal-other-offers-wrapper' ).forEach( function ( wrapper, index ) {
		const slidesContainer = wrapper.querySelector( '.legal-other-offers' );

		console.log( 'review-offers slidesContainer: ' + slidesContainer.classList );

		const slide = slidesContainer.querySelector( '.offers-item' );

		const prevButton = wrapper.querySelector( '.offers-arrow-prev' );

		const nextButton = wrapper.querySelector( '.offers-arrow-next' );

		const offset = 20;

		nextButton.addEventListener( "click", () => {
			const slideWidth = slide.clientWidth;
	
			slidesContainer.scrollLeft += slideWidth + offset;
		} );
	
		prevButton.addEventListener( "click", () => {
			const slideWidth = slide.clientWidth;
	
			slidesContainer.scrollLeft -= slideWidth + offset;
		} );

		// imageset.id = 'imageset-' + index;

		// imageset.querySelectorAll( '.imageset-item' ).forEach( function ( item, index ) {

		// 	item.dataset.imageset = imageset.id;

		// 	item.dataset.id = index;

		// 	item.addEventListener( 'click', popup, false );

		// 	item.addEventListener( 'click', popupUpdate, false );
		// } );
	} );

	

	// console.log( 'review-offers slidesContainer: ' + slidesContainer.classList );
	
	// const slide = document.querySelector( ".slide" );

	// const prevButton = document.getElementById( "slide-arrow-prev" );

	// const nextButton = document.getElementById( "slide-arrow-next" );

	// const offset = 20;

	// nextButton.addEventListener( "click", () => {
	// 	const slideWidth = slide.clientWidth;

	// 	slidesContainer.scrollLeft += slideWidth + offset;
	// } );

	// prevButton.addEventListener( "click", () => {
	// 	const slideWidth = slide.clientWidth;

	// 	slidesContainer.scrollLeft -= slideWidth + offset;
	// } );
} );

// review-offers-js end