// review-gallery-caption-js start

document.addEventListener('DOMContentLoaded', function () {

	const selectors = {

		imagesetWrapper: '.tcb-post-content .legal-imageset-wrapper',

		imageset: '.tcb-post-content .legal-imageset:not( .columns-3 )',

		imageActive: ' .imageset-item.legal-active',

	};

	function initCaption( imageset ) {
		if ( !imageset ) {
			console.log('нет картинок');
            return;
        };

		/* console.log('есть картинки');

		if ( !paragr ) {
            return;
        };

		paragr.forEach( clampParagr );

		cut.addEventListener( 'click', openParagr, false ); */

		/* if ( cut.classList.contains( classes.active ) ) {
			paragr.forEach( openParagr );
		} */

	};

	document.querySelectorAll( selectors.imageset ).forEach( initCaption );

});

// review-gallery-caption-js end