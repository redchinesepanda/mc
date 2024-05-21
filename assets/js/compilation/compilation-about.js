// compilation-about-js start

document.addEventListener( 'DOMContentLoaded', function ()
{

	function choosePicture() {

		const wrapper = document.querySelector( selectors.compilationAbout );

		const casinoWrapper = document.querySelector( selectors.compilationAboutCasino );

		const picture = document.querySelector( selectors.compilationAboutPicture );

		if ( wrapper.contains( casinoWrapper ) ){
			return picture.srcset='/assets/img/compilation/compilation-casino.svg';
		} else {
			return false;
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