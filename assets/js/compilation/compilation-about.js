// compilation-about-js start

document.addEventListener( 'DOMContentLoaded', function ()
{

	function choosePicture() {

		const wrapper = document.querySelector( '.compilation-about-wrapper' );

		const casinoWrapper = document.querySelector( '.legal-casino' );

		const picture = document.querySelector( '.compilation-about-wrapper picture source' );

		console.log( picture );

		if ( wrapper.closest( casinoWrapper ) ) {
			picture.srcset='/assets/img/compilation/compilation-bookmaker.svg';
		}; /* else {
			return true;
		}; */
	};

/* 	const selectors = {

		compilationAbout: '.compilation-about-wrapper',

		compilationAboutCasino: '.legal-casino',

		compilationAboutPicture: '.compilation-about-wrapper picture source',
	}; */
	
	choosePicture();
} );

// compilation-about-js end