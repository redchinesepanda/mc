// review-anchors-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	document.querySelectorAll('.swiper').forEach(el => {
		/*--------------------Swiper--------------*/
		const swiper = new Swiper(el, {
			loop: false,
			slidesPerView: 'auto',
			/* initialSlide: 3, */
			/* centeredSlides: true, */

		});

		let swiperBoxBlur = document.querySelectorAll('.review-anchors .swiper-initialized');

		swiper.on('slideChange', function () {
			console.log('slide changed');

			/* swiperBoxBlur.forEach(i => {
				i.classList.add('legal-active');
				i.classList.remove('legal-active-end');
			}); */
		});

		swiper.on('reachBeginning', function () {
			console.log('slide reachBeginning');
			
			swiperBoxBlur.forEach(i => {
				i.classList.add('legal-active-start');
				i.classList.remove('legal-active-end');
			});
		}); 

		swiper.on('reachEnd', function () {
			console.log('slide reachEnd');

			swiperBoxBlur.forEach(i => {
				i.classList.add('legal-active-end');
				i.classList.remove('legal-active-start');
			});
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