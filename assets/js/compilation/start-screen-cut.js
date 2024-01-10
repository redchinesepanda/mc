// review-cut-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function toggleItem( element )
	{
		element.classList.toggle( 'legal-active' );
	}

	function toggleDataset( event )
	{
		event.currentTarget.classList.toggle( 'legal-active' );

		event.currentTarget.parentElement.querySelectorAll(
			'.legal-cut-item[data-cut-set-id="' + event.currentTarget.dataset.cutSetId + '"]'
		)
		.forEach( toggleItem );

		if ( event.currentTarget.dataset.remove )
		{
			event.currentTarget.remove();
		};

	}

	function prepareControl( element )
	{

		element.dataset.cutSetId = document.setId;
		
		if ( element.classList.contains( 'legal-cut-control' ) )
		{
			element.addEventListener( 'click', toggleDataset, false );
			element.addEventListener( 'click', hideControl );

			// setID++;

			document.setId++;
		} 
	}

	const elements = {
		cut : {
			selectors : '.legal-main-screen .legal-cut-item, .legal-section-main-screen .legal-cut-control'
		}
	};

	function reviewCutInit()
	{
		// let setID = 0;
	
		document.setId = 0;

		document.querySelectorAll(

			[ elements.cut.selectors ].join( ', ' )
		)
		.forEach( prepareControl );
	}

	reviewCutInit();

	window.addEventListener( 'resize', reviewCutInit, false );
} );

// review-cut-js end