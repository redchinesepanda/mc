// review-gallery-caption-js start

document.addEventListener('DOMContentLoaded', function () {

	const selectors = {

		imageset: '.tcb-post-content .legal-imageset:not( .columns-3 )',

		image: '.item-image',

		caption: '.item-caption',

	};

	function setWidthCaption( elem ) {
		
		// console.log('есть картинки');

		let img = elem.querySelector( selectors.image );

		let caption = elem.querySelector( selectors.caption );

		let imgWidth = img.getAttribute( 'width' ) + 'px';

		caption.style.setProperty('--element-wigth', imgWidth);

		// console.log( imgWidth );

	};

	document.querySelectorAll( selectors.imageset ).forEach( setWidthCaption );

});

// review-gallery-caption-js end