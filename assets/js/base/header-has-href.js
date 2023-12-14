
// header-has-href-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function prepareItem( element )
	{
		element.closest( elements.title.selectors ).setAttribute( 'href', element.getAttribute( 'href' ) );
	}

	function forgetItem( element )
	{
        element.closest( elements.title.selectors ).setAttribute( 'href', value.hrefNo );
    }

	const value = {
		hrefNo : '#'
	};

    const elements = {
		item : {
			selectors : '.legal-menu .legal-has-href'
		},

		title : {
			selectors : '.item-title'
		},
	};

    function headerCutInit()
	{
		if ( window.matchMedia( '( min-width: 768px )' ).matches )
		{
			document.querySelectorAll( elements.item.selectors ).forEach( prepareItem );
		}
		else
		{
			document.querySelectorAll( elements.item.selectors ).forEach( forgetItem );
		}
	}

    // headerCutInit();

	window.addEventListener( 'resize', headerCutInit, false );
} );

// header-has-href end