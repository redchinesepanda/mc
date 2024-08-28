// Yandex.Metrika goal oops start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function reachGoalOops() 
	{
        ym( 86785715, 'reachGoal', 'show-not-a-partner-popup' );
    }

    function prepareCheckOoops( element )
    {
		element.addEventListener( 'click', reachGoalOops, false );
	}

    const selector = {
        checkOops : 'a.check-oops[href="#"]'
    };

    function checkOoopsInit()
    {
        document.querySelectorAll( selector.checkOops ).forEach( prepareCheckOoops );
    }

    if ( MetrikaLib.checkCookie() )
	{
		// checkOoopsInit();

        MetrikaLib.userInit( checkOoopsInit );
	}

	document.addEventListener( LegalCookieOops.oopsCookieHandler, checkOoopsInit, { once: true } );
} );

// Yandex.Metrika goal oops end