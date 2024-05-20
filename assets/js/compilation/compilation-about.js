// compilation-about-js start

document.addEventListener( 'DOMContentLoaded', function ()
{

	function choosePicture() {

		console.log('скрипт подключился');

		const wrapper = document.querySelector( selectors.compilationAbout );

		const casinoWrapper = document.querySelector( selectors.compilationAboutCasino );

		const picture = document.querySelector( selectors.compilationAboutPicture );

		if ( wrapper.closest( casinoWrapper ) ) {
			picture.srcset='/assets/img/compilation/compilation-bookmaker.svg';
		} else {
			return true;
		};
	};

	const selectors = {

		compilationAbout: '.compilation-about-wrapper',

		compilationAboutCasino: '.legal-casino',

		compilationAboutPicture: '.compilation-about-wrapper picture source',
	};
	
	choosePicture();
} );

// compilation-about-js end