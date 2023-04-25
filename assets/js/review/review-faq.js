// review-faq-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggle( event )
    {
		event.currentTarget.classList.toggle( 'legal-active' );

		// event.currentTarget.nextElementSibling.classList.toggle( 'legal-active' );

		let content = event.currentTarget.nextElementSibling;

		console.log( 'review-faq toggle content: ' + content );
		
		console.log( 'review-faq toggle content.classList.contains: ' + content.classList.contains( 'legal-active' ) );

		if ( !content.classList.contains( 'legal-active' ) ) {
			content.classList.add( 'legal-active' );

			setTimeout( function () {
				content.classList.add( 'legal-visibile' );
			}, 20 );
		} else {
			content.classList.remove('legal-visibile');    

			content.addEventListener( 'transitionend', function( e ) {
				console.log( 'review-faq toggle transitionend' );

				content.classList.remove( 'legal-active' );
			}, {
				capture: false,
				once: true,
				passive: false
			} );
		}
    }

	document.querySelectorAll( '.tcb-post-content > .faq' ).forEach( function ( faq ) {
		faq.querySelectorAll( '.faq-item-title' ).forEach( function ( item, index ) {
			item.addEventListener( 'click', toggle, false );
		} );
	} );

	// document.querySelectorAll( '.tcb-post-content > .legal-faq-title' ).forEach( function ( faqTitle, index ) {

	let titleID = -1;
	document.querySelectorAll( '.tcb-post-content > .legal-faq-title, .tcb-post-content > .legal-faq-description').forEach( function ( element, index ) {
		if ( element.classList.contains( 'legal-faq-title' ) ) {
			element.dataset.id = index;
			titleID = index;
		} else {
			element.dataset.titleID = titleID;
		}

		console.log( 'review-faq dataset: ' + JSON.stringify( element.dataset ) );
	} );

	// document.querySelectorAll( '.tcb-post-content > .legal-faq-title ~ .legal-faq-description' ).forEach( function ( faqContent, index ) {
	// 	faqContent.dataset.id = 'faq-content-' + index;

	// 	if ( faqContent.nextSibling !== null ) {
	// 		let titleId = faqContent.nextSibling.dataset.id;

	// 		if ( typeof titleId !== 'undefined' ) {
	// 			document.querySelector( '.tcb-post-content > .legal-faq-title[data-id=' + titleId + ']' ).;
	// 		}
	// 	}

	// 	console.log( 'review-faq: ' + faqContent.classList );
	// } );
} );

// review-faq-js end