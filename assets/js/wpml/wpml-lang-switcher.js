// wpml-lang-switcher-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    const classes = {
		active : 'legal-active',

		switcher : 'lang-switcher',

		current : 'lang-current',
	};

    const selectors = {
		footer : '.legal-footer-wrapper',

		switcher : '.lang-switcher',

		current : '.lang-current',

		title : '.lang-title'
	};

    function spoilerToggle( event )
    {
        event.currentTarget.classList.toggle( classes.active );

        // event.currentTarget.nextElementSibling.classList.toggle( classes.active );
        
        event.currentTarget.closest( selectors.current ).nextElementSibling.classList.toggle( classes.active );
    }

    function langPrepare( lang )
    {
        lang.addEventListener( 'click', spoilerToggle, false );
    }

    function spoilerPrepare( switcher )
    {
        // switcher.querySelectorAll( elements.current ).forEach( langPrepare );
        
        switcher.querySelectorAll( selectors.title ).forEach( langPrepare );
    }

    document.querySelectorAll( selectors.switcher ).forEach( spoilerPrepare ); 

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

    document.querySelectorAll( selectors.footer ).forEach( prepare );
} );

// wpml-lang-switcher-js