// review-anchors-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleItems( event )
	{
		event.currentTarget.parentElement.classList.toggle( 'legal-active' );
	}

    document.querySelector( '.anchors-title' ).addEventListener( 'click', toggleItems, false );
} );

// review-anchors-js end