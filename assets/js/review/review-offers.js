// review-offers start

document.addEventListener( 'DOMContentLoaded', function ()
{
	// const slidesContainer = document.getElementById( 'legal-other-offers' );

	const slidesContainer = document.querySelector( '.legal-other-offers' );

	console.log( 'review-offers slidesContainer: ' + slidesContainer );
	
	const slide = document.querySelector( ".slide" );

	const prevButton = document.getElementById( "slide-arrow-prev" );

	const nextButton = document.getElementById( "slide-arrow-next" );

	const offset = 20;

	nextButton.addEventListener( "click", () => {
		const slideWidth = slide.clientWidth;

		slidesContainer.scrollLeft += slideWidth + offset;
	} );

	prevButton.addEventListener( "click", () => {
		const slideWidth = slide.clientWidth;

		slidesContainer.scrollLeft -= slideWidth + offset;
	} );
} );

// review-offers-js end