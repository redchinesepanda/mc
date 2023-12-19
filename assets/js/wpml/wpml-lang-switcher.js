// wpml-lang-switcher-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function spoilerToggle( event )
    {
        event.currentTarget.classList.toggle( classes.active );

        event.currentTarget.nextElementSibling.classList.toggle( classes.active );
    }

    function langPrepare( lang )
    {
        lang.addEventListener( 'click', spoilerToggle, false );
    }

    function spoilerPrepare( switcher )
    {
        switcher.querySelectorAll( elements.current.selectors ).forEach( langPrepare );
    }

    document.querySelectorAll( elements.switcher.selectors ).forEach( spoilerPrepare );

    const classes = {
		active : 'legal-active',

		switcher : 'lang-switcher',

		current : 'lang-current',
	};

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

    const elements = {
		footer : {
			selectors : '.legal-footer-wrapper'
		},

		switcher : {
			selectors : '.lang-switcher'
		},

		current : {
			selectors : '.lang-current'
		},
	};

    document.querySelectorAll( elements.footer.selectors ).forEach( prepare );
} );

// wpml-lang-switcher-js