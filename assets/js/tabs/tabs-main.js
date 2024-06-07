// tabs-main-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function tabToggle( event )
    {
        let tabs = document.getElementById( event.currentTarget.dataset.tabs );

        tabs.querySelectorAll( '.legal-tab-title' ).forEach( ( title ) => {
            title.classList.remove( 'legal-active' );
        });

        tabs.querySelectorAll( '.legal-tab-content' ).forEach( ( content ) => {
            content.classList.remove( 'legal-active' );
        });
        
        event.currentTarget.classList.add( 'legal-active' );

        tabs.querySelector( '.legal-content-' + event.currentTarget.dataset.content ).classList.add( 'legal-active' );
    }

    Array.from( document.getElementsByClassName( 'legal-tabs' ) ).forEach( function callback( tabs, index ) {
        tabs.id = "legal-tabs-" + index;

        let titles = tabs.getElementsByClassName( 'legal-tab-title' );

        for ( let title of titles ) {
            title.dataset.tabs = tabs.id;

            title.addEventListener( 'click', tabToggle, false );
            // title.addEventListener( 'click', function(event) { tabToggle(event); spoilerinit(); }, false );
        }
    });





    document.querySelectorAll('.legal-tabs .legal-tab-title').forEach( (tab) => {
        console.log('Таб нажат')
        tab.addEventListener( 'click', spoilerinit, false );
    });

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
		args.forEach( function ( arg ) {
			document.querySelectorAll( arg.string ).forEach( defineOverflow );
		} );
	}
} );

// tabs-main-js end