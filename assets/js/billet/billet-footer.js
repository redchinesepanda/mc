// billet-footer-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
/* 	function toggleFooter( element )
	{
		element.classList.add( classes.active );
	} */

	function toggleControl( event )
	{
		/* event.currentTarget.closest( selectors.billetMega ).querySelectorAll( selectors.billetMegaTnc ).forEach( toggleFooter );

		event.currentTarget.classList.add( classes.active ); */

		event.target.closest('div').classList.add( classes.active );

	}

	function setFooter( element )
	{
		element.addEventListener( 'click', toggleControl, false );
	}

	const classes = {
		active: 'legal-active',

		shortStr: 'legal-short-tnc',
	};

/* 	const selectors = {
		billetMega: '.legal-billet-mega',

		billetMegaControl: '.legal-billet-mega .billet-mega-tnc .billet-mega-tnc-control',
		
		billetMegaTnc: '.legal-billet-mega .billet-mega-tnc',

		billetMegaTncStr: '.legal-billet-mega .billet-mega-tnc p:first-of-type'
	}; */

	const args = [
		{
			'selector' : '.billet-item .billet-footer-control',

			'string' : '.billet-item .billet-footer p:first-of-type',
		},

		{
			'selector' : '.legal-billet-mega .billet-mega-tnc .billet-mega-tnc-control',

			'string' : '.legal-billet-mega .billet-mega-tnc p:first-of-type',
		},

	];

	// document.querySelectorAll( selectors.billetMegaControl ).forEach( setFooter );

	function overflow(e) {
		return e.scrollWidth > e.offsetWidth || e.scrollHeight > e.offsetHeight;
	}

	function defineOverflow( str ) {
		if (overflow(str)) {
			// console.log('Текст не умещается');
			// document.querySelectorAll( selectors.billetMegaControl ).forEach( setFooter );
			 str.parentNode.classList.remove( classes.shortStr );
			args.forEach( function ( arg ) {
				document.querySelectorAll( arg.selector ).forEach( setFooter );
			} );
			} else {
			// console.log('Текст умещается');
			str.parentNode.classList.add( classes.shortStr );
		};
	};

	// document.querySelectorAll( selectors.billetMegaTncStr ).forEach( defineOverflow );

	function spoilerinit() {
		console.log('Кликнули по табу, запустили функцию');
		args.forEach( function ( arg ) {
			document.querySelectorAll( arg.string ).forEach( defineOverflow );
		} );
	}

	spoilerinit();

	document.querySelectorAll('.legal-tabs .legal-tab-title').forEach( (tab) => {
        console.log(`${tab} Таб найден`);
        tab.addEventListener( 'click', spoilerinit, false );
	});
	
} );

// billet-footer-js end