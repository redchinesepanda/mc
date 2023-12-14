
// header-cut-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function prepareControl()
	{
        let control = document.createElement( 'span' );

		control.classList.add( 'legal-cut-control' );

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
		// console.log( element.querySelectorAll( elements.item.selectors ).length );

		let items = element.querySelectorAll( elements.item.selectors );

        if ( items.length > 6 )
        {
            [ ...items ].slice( 6 ).forEach( prepareItem );

			console.log( items.length );
			
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

		// console.log( element.querySelector( elements.cutControl.selectors ) );

		element.querySelector( elements.cutControl.selectors ).remove();
	}

    const elements = {
		menu : {
			selectors : '.legal-menu > .menu-item-has-children > .sub-menu > .menu-group > .menu-item-has-children > .sub-menu'
		},

		item : {
			selectors : ':scope .menu-item'
		},

		// itemInGroup : {
		// 	selectors : ':scope > .menu-group > .menu-item'
		// },

		cutControl : {
			selectors : ':scope > .legal-cut-control'
		}
	};

    function headerCutInit()
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

    headerCutInit();

	window.addEventListener( 'resize', headerCutInit, false );

    // document.querySelectorAll( elements.menu.selectors ).forEach( prepareItems );
} );

// header-cut-js end