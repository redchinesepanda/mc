// billet-mega-tnc-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function toggleFooter( element )
	{
		element.classList.toggle( classes.active );
	}

	function toggleControl( event )
	{
		event.currentTarget.closest( selectors.billetMega ).querySelectorAll( selectors.billetMegaTnc ).forEach( toggleFooter );

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
		billetMega: '.legal-billet-mega',

		billetMegaControl: '.legal-billet-mega .billet-mega-tnc .billet-mega-tnc-control',
		
		billetMegaTnc: '.legal-billet-mega .billet-mega-tnc'
	};

	document.querySelectorAll( selectors.billetMegaControl ).forEach( setFooter );
} );

// billet-mega-tnc-js end