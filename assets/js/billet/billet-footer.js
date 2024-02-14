// billet-footer-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function toggleFooter( element )
	{
		element.classList.toggle( classes.active );
	}

	function toggleControl( event )
	{
		event.currentTarget.closest( selectors.billet ).querySelectorAll( selectors.billetFooter ).forEach( toggleFooter );

		event.currentTarget.classList.toggle( classes.active );
	}

	function setFooter( element )
	{
		element.addEventListener( 'click', toggleControl, false );
	}

	const classes = {
		active: 'legal-active',
	};

	const selectors = {
		billet: '.billet',

		billetFooterControl: '.billet .billet-footer-control',
		
		billetFooter: '.billet-footer'
	};

	document.querySelectorAll( selectors.billetFooterControl ).forEach( setFooter );
} );

// billet-footer-js end