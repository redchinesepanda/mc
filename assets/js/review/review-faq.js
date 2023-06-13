// review-faq-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
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