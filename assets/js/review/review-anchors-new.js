// review-anchors-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	const selectors = {
		anchorsItem : '.review-anchors .anchors-item[href^="#"]',

		buttonToTop : '.legal-section-anchors .legal-to-top',

		allSwiper : '.swiper:not( .review-anchors-swiper )',

		anchorsSwiper : '.review-anchors-swiper',

		// stringSwiper : '.home .compilation-about-wrapper .swiper-wrapper'
	};

	const classes = {
		active : 'legal-active',

		startSwipe : 'legal-active-start',

		endSwipe : 'legal-active-end',

		// shortStr: 'legal-short-str',
	};

	// swiper init start

	document.querySelectorAll( selectors.allSwiper ).forEach(el => {
		/* --------------------Swiper-------------- */
		const swiper = new Swiper(el, {
			loop: false,
			slidesPerView: 'auto',
			spaceBetween: 8,
		});

		/* swiper.on('slideChange', function () {
			console.log('slide changed');
		}); */

		swiper.on('reachBeginning', function () {
			// console.log('slide reachBeginning');

			el.classList.add( classes.startSwipe );
			el.classList.remove( classes.endSwipe );
		}); 

		swiper.on('reachEnd', function () {
			// console.log('slide reachEnd');

			el.classList.add( classes.endSwipe );
			el.classList.remove( classes.startSwipe );
		});
	});

/* 	document.querySelectorAll( selectors.anchorsSwiper ).forEach(el => {
		const swiperAnchors = new Swiper(el, {
			loop: false,
			slidesPerView: 'auto',
			spaceBetween: 8,
			navigation: {
				nextEl: '.anchors-btn-next',
				prevEl: '.anchors-btn-prev',
			},
		});

		swiperAnchors.on('reachBeginning', function () {
			el.classList.add( classes.startSwipe );
			el.classList.remove( classes.endSwipe );
		}); 

		swiperAnchors.on('reachEnd', function () {
			el.classList.add( classes.endSwipe );
			el.classList.remove( classes.startSwipe );
		});
	}); */

	function swiperAnchorsDesc ( el ) {
		const swiperAnchors = new Swiper(el, {
		  loop: false,
		  slidesPerView: 'auto',
		  spaceBetween: 8,
		  navigation: {
			nextEl: '.anchors-btn-next',
			prevEl: '.anchors-btn-prev',
		  },
		});
	  
		swiperAnchors.on('reachBeginning', function () {
		  console.log('slide reachBeginning');
		  el.classList.add( classes.startSwipe );
		  el.classList.remove( classes.endSwipe );
		}); 
	  
		swiperAnchors.on('reachEnd', function () {
		  console.log('slide reachEnd');
		  el.classList.add( classes.endSwipe );
		  el.classList.remove( classes.startSwipe );
		});
	  };
	  
	  function swiperAnchorsMobile ( el ) {
		const swiperAnchorsMobile = new Swiper(el, {
		  loop: false,
		  slidesPerView: 'auto',
		  spaceBetween: 8,
		});
	  
		swiperAnchorsMobile.on('reachBeginning', function () {
		  console.log('slide reachBeginning');
		  el.classList.add( classes.startSwipe );
		  el.classList.remove( classes.endSwipe );
		}); 
	  
		swiperAnchorsMobile.on('reachEnd', function () {
		  console.log('slide reachEnd');
		  el.classList.add( classes.endSwipe );
		  el.classList.remove( classes.startSwipe );
		});
	  };
	  
	  function swiperAnchorsInit()
	  {
		if ( window.matchMedia( '( min-width: 768px )' ).matches )
		{
		  document.querySelectorAll( selectors.anchorsSwiper ).forEach( swiperAnchorsDesc );
		}
		else
		{
		  document.querySelectorAll( selectors.anchorsSwiper ).forEach( swiperAnchorsMobile );
		}
	  };
	  
	  swiperAnchorsInit();
	  
	  window.addEventListener( 'resize', swiperAnchorsInit, false );

	// function swiperInit( el )
	// {
	// 	const swiper = new Swiper(el, {
	// 		loop: false,
	// 		slidesPerView: 'auto',
	// 		spaceBetween: 8,
	// 	});

	// 	swiper.on('slideChange', function () {
	// 		// console.log('slide changed');
	// 	});

	// 	swiper.on('reachBeginning', function () {
	// 		// console.log('slide reachBeginning');

	// 		el.classList.add('legal-active-start');
	// 		el.classList.remove('legal-active-end');
	// 	}); 

	// 	swiper.on('reachEnd', function () {
	// 		// console.log('slide reachEnd');

	// 		el.classList.add('legal-active-end');
	// 		el.classList.remove('legal-active-start');
	// 	});
	// }

	// function swiperInitAll()
	// {
	// 	document.querySelectorAll( '.swiper' ).forEach( swiperInit );
	// }

	// MetrikaLib.userInit( swiperInitAll );

	// swiper init end

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