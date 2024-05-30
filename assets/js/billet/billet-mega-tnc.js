// billet-mega-tnc-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function toggleFooter( element )
	{
		element.classList.add( classes.active );
	}

	function toggleControl( event )
	{
		event.currentTarget.closest( selectors.billetMega ).querySelectorAll( selectors.billetMegaTnc ).forEach( toggleFooter );

		event.currentTarget.classList.add( classes.active );
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
		
		billetMegaTnc: '.legal-billet-mega .billet-mega-tnc',

		billetMegaTncStr: '.legal-billet-mega .billet-mega-tnc p:first-of-type'
	};

	document.querySelectorAll( selectors.billetMegaControl ).forEach( setFooter );

	
	function overflow(e) {
		return e.scrollWidth > e.offsetWidth || e.scrollHeight > e.offsetHeight;
	}

	let tncStr = document.querySelectorAll( selectors.billetMegaTncStr )

	tncStr.forEach((str) => {
		if (overflow(str)) {
			console.log('Текст не умещается');
			// Текст не умещается
			} else {
			console.log('Текст умещается');
			// Текст умещается
		}
	});
	
} );

// billet-mega-tnc-js end