// review-anchors-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	
	document.querySelectorAll('.swiper').forEach(el => {
		/*--------------------Swiper--------------*/
		new Swiper(el, {
			loop: false,
			slidesPerView: 'auto',
			initialSlide: 0,
		});
	})
	
} );

// review-anchors-js end