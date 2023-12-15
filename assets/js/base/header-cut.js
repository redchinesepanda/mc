
// header-cut-js start

document.addEventListener( 'DOMContentLoaded', function ()
{

    function removeControl( element )
	{
		this.remove();
	}

    function prepareControl()
	{
        let control = document.createElement( 'span' );

		control.classList.add( classes.cutControl );

		control.dataset.contentDefault = legalHeaderCutText.default;

		control.dataset.contentActive = legalHeaderCutText.active;

		control.addEventListener( 'clicks', removeControl, false );

		return control;
    }

    function prepareItem( element )
	{
        element.classList.add( classes.cutItem );
    }

    function prepareItems( element )
	{
		// console.log( element.querySelectorAll( elements.item.selectors ).length );

		let items = element.querySelectorAll( elements.item.selectors );

        if ( items.length > 6 )
        {
            [ ...items ].slice( 6 ).forEach( prepareItem );

			// console.log( items.length );
			
			element.appendChild( prepareControl() );
        }
	}

    function removeCutControl( element )
	{
        element.remove();
    }

	function forgetItem( element )
	{
        element.classList.remove( classes.cutItem );
    }

    // function forgetItems( element )
	// {
	// 	// console.log( element.querySelectorAll( elements.item.selectors ) );

    //     element.querySelectorAll( elements.item.selectors ).forEach( forgetItem );

	// 	// console.log( element.querySelector( elements.cutControl.selectors ) );

	// 	element.querySelector( elements.cutControl.selectors ).remove();
	// }

	const classes = {
		cutItem : 'legal-cut-item',

		cutControl : 'legal-cut-control',
	}; 

    const elements = {
		menu : {
			selectors : '.legal-menu > .menu-item-has-children > .sub-menu > .menu-group > .menu-item-has-children > .sub-menu'
		},

		item : {
			selectors : ':scope .menu-item'
		},

		items : {
			selectors : '.legal-menu .menu-item'
		},

		cutControl : {
			selectors : '.legal-menu .legal-cut-control'
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
			document.querySelectorAll( elements.items.selectors ).forEach( forgetItem );

			document.querySelectorAll( elements.cutControl.selectors ).forEach( removeCutControl );
		}
	}

    // headerCutInit();

	window.addEventListener( 'resize', headerCutInit, false );

    // document.querySelectorAll( elements.menu.selectors ).forEach( prepareItems );
} );

// header-cut-js end