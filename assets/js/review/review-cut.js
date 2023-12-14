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
	}

	function prepareControl( element )
	{
		element.dataset.cutSetId = setID;
		
		if ( element.classList.contains( 'legal-cut-control' ) )
		{
			element.addEventListener( 'click', toggleDataset, false );

			setID++;
		}
	}

	function prepareControl( element )
	{
		// element.dataset.cutSetId = setID;

		element.dataset.cutSetId = document.dataset.setId;
		
		if ( element.classList.contains( 'legal-cut-control' ) )
		{
			element.addEventListener( 'click', toggleDataset, false );

			// setID++;

			document.dataset.setId++;
		}
	}

	const elements = {
		cut : {
			selectors : '.tcb-post-content > .legal-cut-item, .tcb-post-content > .legal-cut-control'
		},

		menu : {
			selectors : '.legal-menu .legal-cut-item, .legal-menu .legal-cut-control'
		}
	};

	function reviewCutInit()
	{
		let setID = 0;
	
		document.dataset.setId = 0;

		document.querySelectorAll(
			// '.tcb-post-content > .legal-cut-item, .tcb-post-content > .legal-cut-control'
			
			// '.tcb-post-content > .legal-cut-item, .tcb-post-content > .legal-cut-control, .legal-menu .legal-cut-item, .legal-menu .legal-cut-control'

			[ elements.cut.selectors, elements.menu.selectors ].join( ', ' )
		)
		.forEach( prepareControl );
		// .forEach( LegalCut.prepareControl, setData );
	}

	reviewCutInit();

	window.addEventListener( 'resize', reviewCutInit, false );
} );

// review-cut-js end