// review-anchors-js start

document.addEventListener( 'DOMContentLoaded', function ()
{

	document.querySelectorAll('.swiper').forEach(el => {
		/* --------------------Swiper-------------- */
		const swiper = new Swiper(el, {
			loop: false,
			slidesPerView: 'auto',
			spaceBetween: 8,
		});

		swiper.on('slideChange', function () {
			// console.log('slide changed');
		});

		swiper.on('reachBeginning', function () {
			// console.log('slide reachBeginning');

			el.classList.add('legal-active-start');
			el.classList.remove('legal-active-end');
		}); 

		swiper.on('reachEnd', function () {
			// console.log('slide reachEnd');

			el.classList.add('legal-active-end');
			el.classList.remove('legal-active-start');
		});

		swiper.on('init', function() {
			const selectors = {

				stringSwiper : '.home .compilation-about-wrapper .swiper-wrapper',
		
				swiperSlide : '.home .compilation-about-wrapper .swiper-slide',
		
				cutControl : '.compilation-about .legal-cut-control',
		
				paragraph : '.compilation-about .section-content-text:first-of-type',
		
			};
		
			const classes = {
				active : 'legal-active',
		
				shortStr: 'legal-short-str',
		
				clamp : 'legal-clamp',
			};
			
			let summ = 0;

			function calcWidth (elem) {
				if ( !elem ) {
					return;
				};

				let withMarginElem = 8;

				let withBorderElem = 2;

				let fullWidthElem = elem.clientWidth + withMarginElem + withBorderElem;

				console.log('offsetWidthElem:', fullWidthElem);

				summ += fullWidthElem;

			};

			function overflow(e) {
				console.log( 'summ:', summ );
				console.log( 'offsetWidthContainer:', e.offsetWidth );
				return summ > e.offsetWidth || e.scrollHeight > e.offsetHeight;
			} 
			
			function defineOverflow( elem ) {
				if ( !elem ) {
					return;
				};

				document.querySelectorAll( selectors.swiperSlide ).forEach( calcWidth );

				return overflow(elem) === false ? elem.parentNode.classList.add( classes.shortStr ) : false;
			
			};

			defineOverflow( document.querySelector( selectors.stringSwiper ) );

		});
	});

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
		click : 'click',

		scroll : 'scroll',
	};

	const selectors = {
		anchorsItem : '.review-anchors .anchors-item[href^="#"]',

		buttonToTop : '.legal-section-anchors .legal-to-top',

		// stringSwiper : '.home .compilation-about-wrapper .swiper-wrapper'
	};

	const classes = {
		active : 'legal-active',

		// shortStr: 'legal-short-str',
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

	function scrollToTop( event )
	{
		// window.scrollTo( {...settings.behavior, ...settings.top} );

		window.scrollTo( {
			top: 0,

			left: 0,

			behavior: 'smooth',
		} );
	}
	
	function initToTop( buttonToTop )
	{
		if ( window.pageYOffset > 300 )
		{
			buttonToTop.classList.add( classes.active );
		}
		else
		{
			buttonToTop.classList.remove( classes.active );
		}

		buttonToTop.addEventListener( events.click, scrollToTop );
	}

	function initScroll()
	{
		document.querySelectorAll( selectors.buttonToTop ).forEach( initToTop );	
    }
   
    window.addEventListener( events.scroll, initScroll );

	// const buttonToTop = document.querySelector( selectors.buttonToTop );
   
    // window.addEventListener("scroll", function () {
	// 	if(!buttonToTop) return;
	// 	if(window.pageYOffset > 300) {
	// 		buttonToTop.classList.add( 'legal-active' );
	// 	} else {
	// 		buttonToTop.classList.remove( 'legal-active' );
	// 	}
    // });
   
    // buttonToTop.addEventListener("click", function (event) {
	//   window.scrollTo( {...settings.behavior, ...settings.top} );
    // });
	/*button-to-top end*/

} );

// review-anchors-js end