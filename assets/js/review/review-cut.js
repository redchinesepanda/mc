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
		}
	}

	// function prepareControl( element )
	// {
	// 	element.dataset.cutSetId = setID;
		
	// 	if ( element.classList.contains( 'legal-cut-control' ) )
	// 	{
	// 		element.addEventListener( 'click', toggleDataset, false );

	// 		setID++;
	// 	}
	// }

	function prepareControl( element )
	{
		// element.dataset.cutSetId = setID;

		element.dataset.cutSetId = document.setId;
		
		if ( element.classList.contains( 'legal-cut-control' ) )
		{
			element.addEventListener( 'click', toggleDataset, false );

			// setID++;

			document.setId++;
		}
	}

	const elements = {
		cut : {
			selectors : '.tcb-post-content > .legal-cut-item, .tcb-post-content > .legal-cut-control'
		},

		menu : {
			selectors : '.legal-menu .legal-cut-item, .legal-menu .legal-cut-control'
		},

		compilationAbout : {
			selectors : '.compilation-about .legal-cut-item, .compilation-about .legal-cut-control'
		},

		reviewAbout : {
			selectors : '.review-about .legal-cut-item, .review-about .legal-cut-control'
		}
	};

	function reviewCutInit()
	{
		// let setID = 0;
	
		document.setId = 0;

		document.querySelectorAll(
			// '.tcb-post-content > .legal-cut-item, .tcb-post-content > .legal-cut-control'
			
			// '.tcb-post-content > .legal-cut-item, .tcb-post-content > .legal-cut-control, .legal-menu .legal-cut-item, .legal-menu .legal-cut-control'

			[ elements.cut.selectors, elements.menu.selectors, elements.compilationAbout.selectors, elements.reviewAbout.selectors ].join( ', ' )
		)
		.forEach( prepareControl );
		// .forEach( LegalCut.prepareControl, setData );
	}

	reviewCutInit();

	window.addEventListener( 'resize', reviewCutInit, false );
} );

// review-cut-js end