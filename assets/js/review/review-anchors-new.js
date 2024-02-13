// review-anchors-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	
	document.querySelectorAll('.swiper').forEach(el => {
		/*--------------------Swiper--------------*/
		new Swiper(el, {
			loop: false,
			slidesPerView: 'auto',
		});
	})
	
} );

// review-anchors-js end