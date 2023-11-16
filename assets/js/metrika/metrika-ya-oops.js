// Yandex.Metrika goal oops start

document.addEventListener( 'DOMContentLoaded', function ()
{
    function reachGoalOops() 
	{
        ym( 86785715, 'reachGoal', 'show-not-a-partner-popup' );
    }

    document.querySelectorAll( 'a.check-oops[href="#"]').forEach( function ( element ) {
		element.addEventListener( 'click', reachGoalOops, false );
	} );
} );

// Yandex.Metrika goal oops end