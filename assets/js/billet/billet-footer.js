// billet-footer-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function toggleFooter( element )
	{
		element.classList.toggle( classes.active );
	}

	function toggleControl( event )
	{
		event.currentTarget.closest( selectors.billetItem ).querySelectorAll( selectors.billetFooter ).forEach( toggleFooter );

		event.currentTarget.classList.toggle( classes.active );
	}

	function setFooter( element )
	{
		element.addEventListener( 'click', toggleControl, false );
	}

	const classes = {
		active: 'legal-active',

		shortStr: 'legal-short-tnc',
	};

	const selectors = {
		// billet: '.billet',

		billetItem: '.billet-item',

		billetFooterControl: '.billet-item .billet-footer-control',
		
		billetFooter: '.billet-item .billet-footer',

		billetTncStr: '.billet-item .billet-footer p:first-of-type'
	};

	// document.querySelectorAll( selectors.billetFooterControl ).forEach( setFooter );

	function overflow(e) {
		return e.scrollWidth > e.offsetWidth || e.scrollHeight > e.offsetHeight;
	}

	function defineOverflow( str ) {
		if (overflow(str)) {
			// console.log('Текст не умещается');
			document.querySelectorAll( selectors.billetFooterControl ).forEach( setFooter );
			} else {
			// console.log('Текст умещается');
			str.parentNode.classList.add( classes.shortStr );
		};
	};

	document.querySelectorAll( selectors.billetTncStr ).forEach( defineOverflow );
} );

// billet-footer-js end