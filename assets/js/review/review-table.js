
// review-table-js start

document.addEventListener( 'DOMContentLoaded', function ()
{

    function prepareCell( element )
	{
		element.dataset.columnName = 'test';
	}

    function prepareColumn( element, index )
	{
        console.log( selectors.currentCell( index + 1 ) );

		element.closest( selectors.table ).querySelectorAll( selectors.currentCell( index + 1 ) ).forEach( prepareCell );
    }

    // function prepareItem( element )
	// {
	// 	console.log( selectors.firstRowCells );

    //     element.querySelectorAll( selectors.firstRowCells ).forEach( prepareColumn )
    // }

    // function prepareItems( element )
	// {
	// 	console.log( selectors.thead );

	// 	element.querySelectorAll( selectors.thead ).forEach( prepareItem );
	// }

    // function removeCutControl( element )
	// {
    //     element.remove();
    // }

	// function forgetItem( element )
	// {
    //     // element.classList.remove( classes.cutItem );
        
	// 	element.classList.remove( classes.cutItem, classes.active );

    //     // delete element.dataset.cutSetId;
    // }

	// const classes = {
	// 	cutItem : 'legal-cut-item',

	// 	cutControl : 'legal-cut-control',

	// 	active : 'legal-active',

	// 	hide : 'legal-hide',
	// };

    const selectors = {
		table : '.tcb-post-content table:not( .legal-row-rowspan, .legal-check )',

		thead : 'thead',
		
		firstRowCells : 'thead tr:first-child > *',

		currentCell : function( number )
		{
			return 'tbody tr > :nth-child(' + number + ')';
		}
	};

    function headerTableInit()
	{
		if ( window.matchMedia( '( max-width: 959px )' ).matches )
		{
			// console.log( selectors.table );

			// document.querySelectorAll( selectors.table ).forEach( prepareItems );
			
			console.log( selectors.firstRowCells );

			document.querySelectorAll( selectors.firstRowCells ).forEach( prepareColumn );
		}
	}

	window.addEventListener( 'resize', headerTableInit, false );
} );

// review-table-js end