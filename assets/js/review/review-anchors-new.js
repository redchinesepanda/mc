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
		args.forEach( function ( arg ) {
			let anchorsTitle = document.querySelector( arg.selector );

			if ( anchorsTitle != null )
			{
				if ( window.matchMedia( '( max-width: 767px )' ).matches )
				{
					anchorsTitle.addEventListener( arg.event, arg.action, false );
	
					// document.querySelector( arg.selector ).addEventListener( arg.event, arg.action, false );
				} else {
					anchorsTitle.removeEventListener( arg.event, arg.action, false );
	
					// document.querySelector( arg.selector ).removeEventListener( arg.event, arg.action, false );
				}
			}
		} );
	}

	toggleInit();

	window.addEventListener( 'resize', toggleInit, false );
} );

// review-anchors-js end