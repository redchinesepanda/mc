// review-anchors-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	document.querySelectorAll('.swiper').forEach(el => {
		/*--------------------Swiper--------------*/
		const swiper = new Swiper(el, {
			loop: false,
			slidesPerView: 'auto',
			spaceBetween: 8,
		});

		swiper.on('slideChange', function () {
			/* console.log('slide changed'); */
		});

		swiper.on('reachBeginning', function () {
			/* console.log('slide reachBeginning'); */

			el.classList.add('legal-active-start');
			el.classList.remove('legal-active-end');
		}); 

		swiper.on('reachEnd', function () {
			/* console.log('slide reachEnd'); */

			el.classList.add('legal-active-end');
			el.classList.remove('legal-active-start');
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

	// заполнение ширины контейнера свайпером старт

	/* function overflow(e) {
		return e.scrollWidth > e.offsetWidth || e.scrollHeight > e.offsetHeight;
	} */

	function defineOverflow( str ) {
		if ( !str ) {
            return;
        };
		// console.log(`${str} Элемент найден`);
		return overflow(str) === false ? str.parentNode.classList.add( classes.shortStr ) : false;
	/* 	if (overflow(str)) {
			console.log('Текст не умещается');
		} else {
			console.log('Текст умещается');
			str.parentNode.classList.add( classes.shortStr );
		}; */
	};

	// defineOverflow( document.querySelector(selectors.stringSwiper ) );

	// document.querySelector( '.compilation-about .swiper-wrapper' ).forEach( defineOverflow );

	// заполнение ширины контейнера свайпером конец


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