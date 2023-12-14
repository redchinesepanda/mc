
// header-cut-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function prepareControl()
	{
        let control = document.createElement( 'span' );

		control.classList.add( 'menu-item', 'legal-cut-control' );

		control.dataset.contentDefault = 'Open test';

		control.dataset.contentActive = 'Close test';

		return control;
    }

    function prepareItem( element )
	{
        element.classList.add( 'legal-cut-item' );
    }

    function prepareItems( element )
	{
		console.log( element.querySelectorAll( elements.item.selectors ).length );

        if ( element.querySelectorAll( elements.item.selectors ).length > 6 )
        {
            [ ...element.children ].slice( 6 ).forEach( prepareItem );
			
			element.appendChild( prepareControl() );
        }
	}

	function forgetItem( element )
	{
        element.classList.remove( 'legal-cut-item' );
    }

    function forgetItems( element )
	{
		// console.log( element.querySelectorAll( elements.item.selectors ) );

        element.querySelectorAll( elements.item.selectors ).forEach( forgetItem );
	}

    const elements = {
		menu : {
			selectors : '.legal-menu > .menu-item-has-children > .sub-menu .menu-item-has-children > .sub-menu'
		},

		item : {
			selectors : ':scope .menu-item'
		},

		itemInGroup : {
			selectors : ':scope > .menu-group > .menu-item'
		}
	};

    function cutInit()
	{
		if ( window.matchMedia( '( min-width: 768px )' ).matches )
		{
			document.querySelectorAll( elements.menu.selectors ).forEach( prepareItems );
		}
		else
		{
			document.querySelectorAll( elements.menu.selectors ).forEach( forgetItems );
		}
	}

    cutInit();

    // document.querySelectorAll( elements.menu.selectors ).forEach( prepareItems );
} );

// header-cut-js end