
// review-table-js start

document.addEventListener( 'DOMContentLoaded', function ()
{

    // function hideControl( event )
	// {
	// 	event.currentTarget.classList.add( classes.hide ); 
	// }

    function prepareColumn( element, index )
	{
        console.log( selectors.currentCell( index ) )
    }

    function prepareItem( element )
	{
        element.querySelectorAll( selectors.firstRow ).forEach( prepareColumn )
    }

    function prepareItems( element )
	{
		// console.log( element.querySelectorAll( elements.item.selectors ).length );

		element.querySelectorAll( selectors.thead ).forEach( prepareItem );
	}

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
		
		firstRow : ':scope > tr:first-child',

		currentCell : function( number ) {
			return 'tr > :nth-child-' + number;
		}
	};

    function headerTableInit()
	{
		if ( window.matchMedia( '( max-width: 959px )' ).matches )
		{
			document.querySelectorAll( selectors.table ).forEach( prepareItems );
		}
	}

	window.addEventListener( 'resize', headerTableInit, false );
} );

// review-table-js end