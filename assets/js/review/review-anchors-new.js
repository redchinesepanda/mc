// review-anchors-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	document.querySelectorAll('.swiper').forEach(el => {
		/*--------------------Swiper--------------*/
		const swiper = new Swiper(el, {
			loop: false,
			slidesPerView: 'auto',
		});

		let swiperBoxBlur = document.querySelectorAll('.review-anchors .swiper-initialized');

		swiper.on('slideChange', function () {
			/* console.log('slide changed'); */
		});

		swiper.on('reachBeginning', function () {
			/* console.log('slide reachBeginning'); */
			
			swiperBoxBlur.forEach(i => {
				i.classList.add('legal-active-start');
				i.classList.remove('legal-active-end');
			});
		}); 

		swiper.on('reachEnd', function () {
			/* console.log('slide reachEnd'); */

			swiperBoxBlur.forEach(i => {
				i.classList.add('legal-active-end');
				i.classList.remove('legal-active-start');
			});
		});
	})

	const settings = {
		behavior : {
			behavior: 'smooth'
		},

		top : {
			top: 0,
		}
	};

	const attributes = {
		href : 'href'
	};

	const events = {
		click : 'click'
	};

	const selectors = {
		anchorsItem : '.review-anchors .anchors-item[href^="#"]',

		buttonToTop : '.anchors .legal-to-top'
	};
	
	document.querySelectorAll( selectors.anchorsItem ).forEach( anchor => {
		anchor.addEventListener( events.click, function (e) {
			e.preventDefault();
	
			let element = document.querySelector( this.getAttribute( attributes.href ) );

			if ( element !== null )
			{
				element.scrollIntoView( settings.behavior ); 
			}
		} );
	} );

	/*button-to-top start*/
	const buttonToTop = document.querySelector( selectors.buttonToTop );
   
    window.addEventListener("scroll", function () {
		if(!buttonToTop) return;
		if(window.pageYOffset > 300) {
			buttonToTop.classList.add( 'legal-active' );
		} else {
			buttonToTop.classList.remove( 'legal-active' );
		}
    });
   
    buttonToTop.addEventListener("click", function (event) {
	  window.scrollTo( {...settings.behavior, ...settings.top} );
    });
	/*button-to-top end*/

} );

// review-anchors-js end