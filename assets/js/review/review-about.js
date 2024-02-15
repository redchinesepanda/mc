// review-about start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function checkState( event )
	{
		console.log( window.scrollY );
	}

	const selectors = {
		aboutRight : '.review-about .about-right'
	};

	document.addEventListener( 'scroll', checkState, false );
} );

// review-about-js end