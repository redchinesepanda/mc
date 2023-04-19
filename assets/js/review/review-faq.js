// review-faq-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggle( event )
    {
		// event.currentTarget.classList.toggle( 'legal-active' );

		// event.currentTarget.nextElementSibling.classList.toggle( 'legal-active' );

		let content = event.currentTarget.nextElementSibling;

		if ( !content.classList.contains( 'legal-active' )) {
			content.classList.add('legal-visibility');    

			content.addEventListener( 'transitionend', function( e ) {
				content.classList.add( 'legal-active' );
			}, {
				capture: false,
				once: true,
				passive: false
			} );
		} else {
			content.classList.remove( 'legal-active' );

			setTimeout(function () {
				content.classList.remove( 'legal-visibility' );
			}, 20);
		}
    }

	document.querySelectorAll( '.tcb-post-content > .faq' ).forEach( function ( faq ) {
		faq.querySelectorAll( '.faq-item-title' ).forEach( function ( item, index ) {
			item.addEventListener( 'click', toggle, false );
		} );
	} );
} );

// review-faq-js end