
// header-has-href-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function prepareItem( element )
	{
		element.closest( elements.parent.selectors )
		.querySelector( elements.title.selectors )
		.setAttribute(
			attr.href,
			
			element.querySelector( elements.title.selectors )
			.getAttribute( attr.href )
		);
	}

	function forgetItem( element )
	{
        element.closest( elements.parent.selectors )
		.querySelector( elements.title.selectors )
		.setAttribute( attr.href, value.hrefNo );
    }

	const attr = {
		href : 'href'
	};

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

    function headerHasHrefInit()
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

    // headerHasHrefInit();

	window.addEventListener( 'resize', headerHasHrefInit, false );
} );

// header-has-href end