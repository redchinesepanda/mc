// review-anchors-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleItems( event )
	{
		event.currentTarget.parentElement.classList.toggle( 'legal-active' );
	}

	const args = [
		{
			'selector' : '.anchors-title',

			'event' : 'click',

			'action' : toggleItems
		},
	];

	function toggleInit()
	{
		if ( window.matchMedia( '( max-width: 768px )' ).matches ) {
			document.querySelector( arg.selector ).addEventListener( arg.event, arg.action, false );
		} else {
			document.querySelector( arg.selector ).removeEventListener( arg.event, arg.action, false );
		}
	}

	toggleInit();

	window.addEventListener( 'resize', toggleInit, false );
} );

// review-anchors-js end