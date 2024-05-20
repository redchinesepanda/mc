// compilation-about-js start

document.addEventListener( 'DOMContentLoaded', function ()
{

	function choosePicture() {

		const wrapper = document.querySelector( '.compilation-about-wrapper' );

		const casinoWrapper = document.querySelector( '.legal-casino' );

		const picture = document.querySelector( '.compilation-about-wrapper picture source' );

		if ( wrapper.contains( casinoWrapper ) ){
			return picture.srcset='http://old.match.center/wp-content/themes/mc-theme/assets/img/compilation/compilation-casino.svg';
		} else {
			return false;
		};
	};

/* 	const selectors = {

		compilationAbout: '.compilation-about-wrapper',

		compilationAboutCasino: '.legal-casino',

		compilationAboutPicture: '.compilation-about-wrapper picture source',
	}; */
	
	choosePicture();
} );

// compilation-about-js end