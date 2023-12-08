// review-faq-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function toggleDataset( event )
	{
		// event.currentTarget.classList.toggle( 'legal-active' );

		// document.querySelectorAll( '.tcb-post-content > .legal-faq-description[data-title*="' + event.currentTarget.dataset.id + '"]').forEach( function ( element ) {
		// 	element.classList.toggle( 'legal-active' );
		// } );
	}

	function prepareControl ( element, index )
	{
		if ( element.classList.contains( 'legal-cut-control' ) )
		{
			element.addEventListener( 'click', toggleDataset, false );
		}
		
		element.dataset.cutSetId = index;
	}
	
	document.querySelectorAll(
		'.tcb-post-content > .legal-cut-item, .tcb-post-content > .legal-cut-control'
	)
	.forEach( prepareControl );
} );

// review-faq-js end