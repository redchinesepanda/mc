// wpml-lang-switcher-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    const classes = {
		active : 'legal-active',

		switcher : 'lang-switcher',

		current : 'lang-current',
	};

    const elements = {
		footer : {
			selector : '.legal-footer-wrapper'
		},

		switcher : {
			selectors : '.lang-switcher'
		},

		current : {
			selector : '.lang-current'
		},

		title : {
			selector : '.lang-title'
		}
	};

    function spoilerToggle( event )
    {
        event.currentTarget.classList.toggle( classes.active );

        // event.currentTarget.nextElementSibling.classList.toggle( classes.active );
        
        event.currentTarget.closest( elements.current.selector ).nextElementSibling.classList.toggle( classes.active );
    }

    function langPrepare( lang )
    {
        lang.addEventListener( 'click', spoilerToggle, false );
    }

    function spoilerPrepare( switcher )
    {
        // switcher.querySelectorAll( elements.current.selector ).forEach( langPrepare );
        
        switcher.querySelectorAll( elements.title.selector ).forEach( langPrepare );
    }

    document.querySelectorAll( elements.switcher.selector ).forEach( spoilerPrepare );

    function toggle( event ) 
    {
        const switchers = document.getElementsByClassName( classes.switcher );

        for ( let switcher of switchers ) {
            let button = switcher.getElementsByClassName( classes.current ).item( 0 );

            let avaible = button.nextElementSibling;

            if ( !avaible.contains( event.target ) && !button.contains( event.target )  ) {
                button.classList.remove( classes.active );

                avaible.classList.remove( classes.active );
            }
        }
    }

    function prepare( element ) {

        element.addEventListener( 'click', toggle );
    }

    document.querySelectorAll( elements.footer.selector ).forEach( prepare );
} );

// wpml-lang-switcher-js