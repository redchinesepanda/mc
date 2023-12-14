
// header-has-href-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function prepareItem( element )
	{
		console.log( element.closest( elements.parent.selectors ) );

		console.log( element.closest( elements.parent.selectors ).querySelector( elements.title.selectors ) );

		console.log( element.getAttribute( 'href' ) );

		element.closest( elements.parent.selectors ).querySelector( elements.title.selectors ).setAttribute( 'href', element.getAttribute( 'href' ) );
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

		parent : {
			selectors : '.menu-item'
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