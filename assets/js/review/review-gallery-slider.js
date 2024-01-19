// review-offers start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function next( element )
	{
		const slideWidth = slide.clientWidth;

		slidesContainer.scrollLeft += slideWidth + offset;
	}

	function previous( element )
	{
		const slideWidth = slide.clientWidth;

		slidesContainer.scrollLeft -= slideWidth + offset;
	}

	function swipe( element )
	{
		const slidesContainer = element.querySelector( '.legal-other-offers' );

		const slide = slidesContainer.querySelector( '.offers-item' );

		const nextButton = element.querySelector( '.offers-arrow-next' );

		const prevButton = element.querySelector( '.offers-arrow-prev' );

		let offset = 0;

		if ( window.matchMedia( '( min-width: 768px )' ).matches ) {
			offset = 18;
		}

		nextButton.addEventListener( "click", next );
	
		prevButton.addEventListener( "click", previous );
	}

	const selectors = {
		imagesetWrapper : '.tcb-post-content .legal-imageset-wrapper',

		imageset : '.tcb-post-content .legal-imageset',
	};

	document.querySelectorAll( selectors.imagesetWrapper ).forEach( swipe );
} );

// review-offers-js end