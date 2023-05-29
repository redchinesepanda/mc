// header-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function toggleBlock( event )
	{
		let element = event.currentTarget;

		element.classList.toggle( 'legal-active' );
	}

    function toggleLink( event )
	{
		let element = event.target;

		if ( element.hasAttribute( 'href' ) ) {

			if ( !element.parentElement.classList.contains( 'legal-active' ) ) {
				event.preventDefault();
			}
		}
	}

    document.querySelectorAll( '.legal-menu .menu-item').forEach( function ( element ) {
		element.addEventListener( 'click', toggleBlock, false );
	} );

    document.querySelectorAll( '.legal-menu .menu-item > a').forEach( function ( element ) {
		element.addEventListener( 'click', toggleLink, false );
	} );
} );

// header-js end