// review-faq-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    // function toggle( event )
    // {
	// 	event.currentTarget.classList.toggle( 'legal-active' );

	// 	// event.currentTarget.nextElementSibling.classList.toggle( 'legal-active' );

	// 	let content = event.currentTarget.nextElementSibling;

	// 	console.log( 'review-faq toggle content: ' + content );
		
	// 	console.log( 'review-faq toggle content.classList.contains: ' + content.classList.contains( 'legal-active' ) );

	// 	if ( !content.classList.contains( 'legal-active' ) ) {
	// 		content.classList.add( 'legal-active' );

	// 		setTimeout( function () {
	// 			content.classList.add( 'legal-visibile' );
	// 		}, 20 );
	// 	} else {
	// 		content.classList.remove('legal-visibile');    

	// 		content.addEventListener( 'transitionend', function( e ) {
	// 			console.log( 'review-faq toggle transitionend' );

	// 			content.classList.remove( 'legal-active' );
	// 		}, {
	// 			capture: false,
	// 			once: true,
	// 			passive: false
	// 		} );
	// 	}
    // }

	// document.querySelectorAll( '.tcb-post-content > .faq' ).forEach( function ( faq ) {
	// 	faq.querySelectorAll( '.faq-item-title' ).forEach( function ( item, index ) {
	// 		item.addEventListener( 'click', toggle, false );
	// 	} );
	// } );

	function toggleDataset( event )
	{
		event.currentTarget.classList.toggle( 'legal-active' );

		document.querySelectorAll( '.tcb-post-content > .legal-faq-description[data-title*="' + event.currentTarget.dataset.id + '"]').forEach( function ( element ) {
			element.classList.toggle( 'legal-active' );
		} );
	}

	let titleID = -1;
	document.querySelectorAll( '.tcb-post-content > .legal-faq-title, .tcb-post-content > .legal-faq-description').forEach( function ( element ) {
		if ( element.classList.contains( 'legal-faq-title' ) ) {
			titleID++;
			element.dataset.id = titleID;
			element.addEventListener( 'click', toggleDataset, false );
		} else {
			element.dataset.title = titleID;
		}
	} );
} );

// review-faq-js end