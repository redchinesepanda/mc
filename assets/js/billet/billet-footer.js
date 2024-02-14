// billet-footer-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function toggleFooter( element )
	{
		element.classList.toggle( classes.active );
	}

	function checkFooter( event )
	{
		event.currentTarget.closest( selectors.billet ).querySelectorAll( selectors.billetFooter ).forEach( toggleFooter );

		event.currentTarget.classList.toggle( classes.active );
	}

	function setFooter( element )
	{
		element.addEventListener( 'click', checkFooter, false );
	}

	const classes = {
		active: 'legal-active',
	};

	const selectors = {
		billet: '.billet',

		billetFooterControl: '.billet .billet-footer-control',
		
		billetFooter: '.billet .billet-footer'
	};

	document.querySelectorAll( selectors.billetFooterControl ).forEach( Footer );
} );

// billet-footer-js end