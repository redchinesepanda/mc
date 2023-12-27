
// review-table-js start

document.addEventListener( 'DOMContentLoaded', function ()
{

    function forgetCell( element )
	{
		delete element.dataset.columnName;
	}

    function prepareCell( element )
	{
		element.dataset.columnName = this.textContent;
	}

    function prepareColumn( element, index )
	{
        [ ...element.closest( selectors.table ).querySelectorAll( selectors.currentCell( index + 2 ) )].forEach( prepareCell, element );
    }

    function prepareItem( element )
	{
		element.querySelectorAll( selectors.firstRowCells ).forEach( prepareColumn )
    }

    const selectors = {
		table : '.tcb-post-content table:not( .legal-row-rowspan, .legal-check )',

		thead : 'thead',
		
		firstRowCells : 'thead tr:first-child > :not( :first-child )',

		currentCell : function( number )
		{
			return 'tbody tr > :nth-child(' + number + ')';
		},

		allCells : this.table + ' tr > *'
	};

    function headerTableInit()
	{
		if ( window.matchMedia( '( max-width: 959px )' ).matches )
		{
			document.querySelectorAll( selectors.table ).forEach( prepareItem );
		}
		else 
		{
			console.log( selectors.allCells );

			document.querySelectorAll( selectors.allCells ).forEach( forgetCell );
		}
	}

	window.addEventListener( 'resize', headerTableInit, false );
} );

// review-table-js end