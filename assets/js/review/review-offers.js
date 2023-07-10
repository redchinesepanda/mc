// review-offers start

document.addEventListener( 'DOMContentLoaded', function ()
{
	document.querySelectorAll( '.legal-other-offers-wrapper' ).forEach( function ( wrapper, index ) {
		const slidesContainer = wrapper.querySelector( '.legal-other-offers' );

		const slide = slidesContainer.querySelector( '.offers-item' );

		const nextButton = wrapper.querySelector( '.offers-arrow-next' );

		const prevButton = wrapper.querySelector( '.offers-arrow-prev' );

		let offset = 0;

		if ( window.matchMedia( '( min-width: 768px )' ).matches ) {
			offset = 18;
		}

		nextButton.addEventListener( "click", () => {
			const slideWidth = slide.clientWidth;
	
			slidesContainer.scrollLeft += slideWidth + offset;
		} );
	
		prevButton.addEventListener( "click", () => {
			const slideWidth = slide.clientWidth;
	
			slidesContainer.scrollLeft -= slideWidth + offset;
		} );
	} );
} );

// review-offers-js end