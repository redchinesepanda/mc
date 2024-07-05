// review-gallery-caption-js start

document.addEventListener('DOMContentLoaded', function () {

	const selectors = {

		imageset: '.tcb-post-content .legal-imageset:not( .columns-3 )',

		image: '.item-image',

		caption: '.item-caption',

	};

	function initCaption( imageset ) {
		
		console.log('есть картинки');

		let img = imageset.querySelector( selectors.image );

		let caption = imageset.querySelector( selectors.caption );

		let imgWidth = img.getAttribute( 'width' ) + 'px';

		caption.style.setProperty('--element-wigth', imgWidth);

		console.log( imgWidth );

	};

	document.querySelectorAll( selectors.imageset ).forEach( initCaption );

});

// review-gallery-caption-js end