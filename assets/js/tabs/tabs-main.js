// tabs-main-js start

document.addEventListener( 'DOMContentLoaded', function ()
{

    const classes = {
		active: 'legal-active',

		shortStr: 'legal-short-tnc',
	};

    function tabToggle( event )
    {
        let tabs = document.getElementById( event.currentTarget.dataset.tabs );

        tabs.querySelectorAll( '.legal-tab-title' ).forEach( ( title ) => {
            title.classList.remove( classes.active );
        });

        tabs.querySelectorAll( '.legal-tab-content' ).forEach( ( content ) => {
            content.classList.remove( classes.active );
        });
        
        event.currentTarget.classList.add( classes.active );

        tabs.querySelector( '.legal-content-' + event.currentTarget.dataset.content ).classList.add( classes.active );
    }

    Array.from( document.getElementsByClassName( 'legal-tabs' ) ).forEach( function callback( tabs, index ) {
        tabs.id = "legal-tabs-" + index;

        let titles = tabs.getElementsByClassName( 'legal-tab-title' );

        for ( let title of titles ) {
            title.dataset.tabs = tabs.id;

            // title.addEventListener( 'click', tabToggle, false );
            title.addEventListener( 'click', function(event) { tabToggle(event); checkLengthStr(); }, false );
        }
    });

	const selectors = {
        billetTncStr: '.billet-item .billet-footer p:first-of-type'
	};

	function overflow(e) {
		return e.scrollWidth > e.offsetWidth || e.scrollHeight > e.offsetHeight;
	}

	function defineOverflow( str ) {
		if (overflow(str)) {
            str.parentNode.classList.remove( classes.shortStr );
			} else {
			str.parentNode.classList.add( classes.shortStr );
		};
	};

    function checkLengthStr() {
        document.querySelectorAll( selectors.billetTncStr ).forEach( defineOverflow );
    };

} );

// tabs-main-js end