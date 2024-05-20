// compilation-about-js start

document.addEventListener( 'DOMContentLoaded', function ()
{

	function choosePicture() {

		const wrapper = document.querySelector( '.compilation-about-wrapper' );

		const casinoWrapper = document.querySelector( '.legal-casino' );

		const picture = document.querySelector( '.compilation-about-wrapper picture source' );

		console.log( picture );

		/* return picture.srcset='http://old.match.center/wp-content/themes/mc-theme/assets/img/compilation/compilation-bookmaker.svg'; */

		if ( wrapper.contains( casinoWrapper ) ){
			return picture.srcset='http://old.match.center/wp-content/themes/mc-theme/assets/img/compilation/compilation-bookmaker.svg';
		} else {
			return picture.srcset='http://old.match.center/wp-content/themes/mc-theme/assets/img/compilation/compilation-casino.svg';
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