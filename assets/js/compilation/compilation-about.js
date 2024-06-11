// compilation-about-js start

document.addEventListener( 'DOMContentLoaded', function () {

	const selectors = {

		stringSwiper : '.home .compilation-about-wrapper .swiper-wrapper',

		cutControl : '.compilation-about .legal-cut-control',

		paragraph : '.compilation-about .section-content-text:not( .legal-cut-item )',

	};

	const classes = {
		active : 'legal-active',

		shortStr: 'legal-short-str',
	};

	// заполнение ширины контейнера свайпером старт

	function overflow(e) {
		console.log( e.scrollWidth );
		console.log( e.offsetWidth );
		return e.scrollWidth > e.offsetWidth || e.scrollHeight > e.offsetHeight;
	}

	function defineOverflow( str ) {
		if ( !str ) {
            return;
        };

		// return overflow(str) === false ? str.parentNode.classList.add( classes.shortStr ) : false;
		return setTimeout(overflow(str), 1000) === false ? str.parentNode.classList.add( classes.shortStr ) : false;
	/* 	if (overflow(str)) {
			console.log('Текст не умещается');
		} else {
			console.log('Текст умещается');
			str.parentNode.classList.add( classes.shortStr );
		}; */
	};

	defineOverflow( document.querySelector( selectors.stringSwiper ) );

	// заполнение ширины контейнера свайпером конец

	// сокращение текста до многоточия старт

	let paragr = document.querySelectorAll( selectors.paragraph );

	function clampParagr( element )
	{
		element.classList.add( classes.active );
	};

	function openParagr()
	{
		// element.classList.remove( classes.active );
		// paragr.classList.remove( classes.active );
		paragr.forEach( ( elem ) => {
			elem.classList.remove( classes.active );
		});
	}

	function initClamp( cut ) {
		if ( !cut ) {
			// console.log('нет спойлера');
            return;
        };

		// console.log('есть спойлер');

		if ( !paragr ) {
            return;
        };

		paragr.forEach( clampParagr );

		cut.addEventListener( 'click', openParagr, false );

		/* if ( cut.classList.contains( classes.active ) ) {
			paragr.forEach( openParagr );
		} */

	};

	initClamp( document.querySelector( selectors.cutControl ) );

	// сокращение текста до многоточия конец

} );

// compilation-about-js end