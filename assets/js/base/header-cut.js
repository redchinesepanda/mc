
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
        if ( element.children.length > 6 )
        {
            [ ...element.children ].slice( 6 ).forEach( prepareItem );

            // console.log( 'element.children.length : ' + element.children.length );

			element.appendChild( prepareControl() );
        }
	}

    const elements = {
		menu : {
			selectors : 'legal-menu .sub-menu'
		}
	};

    document.querySelectorAll( elements.menu.selectors ).forEach( prepareItems );
} );

// header-cut-js end