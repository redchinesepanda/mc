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

	function prepareControl ( setID, element )
	{
		console.log( 'setID: ' + setID );

		console.log( 'this: ' + this );

		this.dataset.cutSetId = setID;
		
		if ( this.classList.contains( 'legal-cut-control' ) )
		{
			setID++;

			this.addEventListener( 'click', toggleDataset, false );
		}
	}

	let setID = 0;
	
	document.querySelectorAll(
		'.tcb-post-content > .legal-cut-item, .tcb-post-content > .legal-cut-control'
	)
	.forEach( prepareControl( setID ), this );
} );

// review-faq-js end