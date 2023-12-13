
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
        console.log( 'element.children.length : ' + element.children.length );

        if ( element.children.length > 6 )
        {
            [ ...element.children ].slice( 6 ).forEach( prepareItem );

            

			element.appendChild( prepareControl() );
        }
	}

    const elements = {
		menu : {
			selectors : '.legal-menu .sub-menu'
		}
	};

    // function cutInit()
	// {
	// 	if ( window.matchMedia( '( min-width: 768px )' ).matches )
	// 	{
	// 		document.querySelectorAll( elements.menu.selectors ).forEach( prepareItems );
	// 	}
	// 	else
	// 	{
			
	// 	}
	// }

    // cutInit();

    document.querySelectorAll( elements.menu.selectors ).forEach( prepareItems );
} );

// header-cut-js end