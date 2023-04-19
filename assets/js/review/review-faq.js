// review-faq-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggle( event )
    {
		event.currentTarget.classList.toggle( 'legal-active' );

		console.log( 'review-faq event.target: ' + event.target );

		console.log( 'review-faq event.currentTarget: ' + event.currentTarget );

		console.log( 'review-faq event.currentTarget.nextSibling: ' + event.currentTarget.nextSibling );

		event.target.nextSibling.classList.toggle( 'legal-active' );
    }

	document.querySelectorAll( '.tcb-post-content > .faq' ).forEach( function ( faq ) {
		faq.querySelectorAll( '.faq-item-title' ).forEach( function ( item, index ) {
			item.addEventListener( 'click', toggle, false );
		} );
	} );
} );

// review-faq-js end