
// header-has-href-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function prepareItem( element )
	{
		element.closest( elements.parent.selectors )
		.querySelector( elements.title.selectors )
		.setAttribute(
			'href',
			
			element.querySelector( elements.title.selectors )
			.getAttribute( 'href' )
		);
	}

	function forgetItem( element )
	{
        element.closest( elements.parent.selectors )
		.querySelector( elements.title.selectors )
		.setAttribute( 'href', value.hrefNo );
    }

	const value = {
		hrefNo : '#'
	};

    const elements = {
		item : {
			selectors : '.legal-menu .legal-has-href'
		},

		parent : {
			selectors : '.menu-item-has-children'
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