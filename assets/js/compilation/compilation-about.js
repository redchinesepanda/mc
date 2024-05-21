// compilation-about-js start

document.addEventListener( 'DOMContentLoaded', function ()
{

	function choosePicture() {

		const wrapper = document.querySelector( selectors.compilationAbout );

		const casinoWrapper = document.querySelector( selectors.compilationAboutCasino );

		const picture = document.querySelector( selectors.compilationAboutPicture );

		if ( wrapper.contains( casinoWrapper ) ){
			return picture.srcset='http://old.match.center/wp-content/themes/mc-theme/assets/img/compilation/compilation-casino.svg';
		} else {
			/* return false; */ 
			return console.log("Стандартная картинка");
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