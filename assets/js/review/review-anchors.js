// review-anchors-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleItems( event )
	{
		event.currentTarget.parentElement.classList.toggle( 'legal-active' );
	}

	function toggleInit()
	{
		if ( window.matchMedia( '( max-width: 768px )' ).matches ) {
			document.querySelector( '.anchors-title' ).addEventListener( 'click', toggleItems, false );
		} else {
			document.querySelector( '.anchors-title' ).removeEventListener( 'click', toggleItems, false );
		}
	}

	toggleInit();

	window.addEventListener( 'resize', toggleInit, false );
} );

// review-anchors-js end