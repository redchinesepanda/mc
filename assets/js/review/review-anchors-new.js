// review-anchors-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	document.querySelectorAll('.swiper').forEach(el => {
		/*--------------------Swiper--------------*/
		new Swiper(el, {
			loop: false,
			slidesPerView: 'auto',
			/* initialSlide: 3, */
			/* centeredSlides: true, */
		});
	})

	const settings = {
		scroll : {
			behavior: 'smooth'
		}
	};

	const attributes = {
		href : 'href'
	};

	const events = {
		click : 'click'
	};

	const selectors = {
		anchorsItem : '.review-anchors .anchors-item[href^="#"]'
	};
	
	document.querySelectorAll( selectors.anchorsItem ).forEach( anchor => {
		anchor.addEventListener( events.click, function (e) {
			e.preventDefault();
	
			let element = document.querySelector( this.getAttribute( attributes.href ) );

			if ( element !== null )
			{
				element.scrollIntoView( settings.scroll );
			}
		} );
	} );
} );

// review-anchors-js end