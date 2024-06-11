// compilation-about-js start

document.addEventListener( 'DOMContentLoaded', function () {

	console.log( 'compilation-about-js start' );

	const selectors = {

		stringSwiper : '.home .compilation-about-wrapper .swiper-wrapper'
	};

	const classes = {
		active : 'legal-active',

		shortStr: 'legal-short-str',
	};

	// заполнение ширины контейнера свайпером старт

	function overflow(e) {
		return e.scrollWidth > e.offsetWidth || e.scrollHeight > e.offsetHeight;
	}

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

	defineOverflow( document.querySelector(selectors.stringSwiper ) );

	// document.querySelector( '.compilation-about .swiper-wrapper' ).forEach( defineOverflow );

	// заполнение ширины контейнера свайпером конец

} );

// compilation-about-js end