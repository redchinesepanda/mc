// review-faq-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggle( event )
    {
		event.currentTarget.nextSibling.classList.toggle( 'legal-active' );
    }

	document.querySelectorAll( '.tcb-post-content > .faq' ).forEach( function ( faq ) {
		faq.querySelectorAll( '.faq-item-title' ).forEach( function ( item, index ) {
			item.addEventListener( 'click', toggle, false );
		} );
	} );
} );

// review-faq-js end