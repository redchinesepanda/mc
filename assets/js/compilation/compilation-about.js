// compilation-about-js start

document.addEventListener( 'DOMContentLoaded', function () {

	console.log( 'compilation-about-js start' );

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
		return e.scrollWidth > e.offsetWidth || e.scrollHeight > e.offsetHeight;
	}

	function defineOverflow( str ) {
		if ( !str ) {
            return;
        };

		return overflow(str) === false ? str.parentNode.classList.add( classes.shortStr ) : false;
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

	function clampParagr( element )
	{
		element.classList.add( classes.active );
	};

	function openParagr( element )
	{
		element.classList.remove( classes.active );
	}

	function initClamp( cut ) {
		if ( !cut ) {
			console.log('нет спойлера');
            return;
        };

		console.log('есть спойлер');

		let paragr = document.querySelectorAll( selectors.paragraph );

		if ( !paragr ) {
            return;
        };

		paragr.forEach( clampParagr );

		if ( cut.classList.contains( classes.active ) ) {
			paragr.forEach( openParagr );
		}

	};

	initClamp( document.querySelector( selectors.cutControl ) );

	// сокращение текста до многоточия конец

} );

// compilation-about-js end