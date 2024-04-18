// oops-age start

document.addEventListener( 'DOMContentLoaded', function ()
{
	let oopsCookieName = 'legal-oops-age';

	let oopsCookieClass = 'legal-active';

	let oopsCookiesWrapper = '.legal-oops-age-wrapper'

	function acceptCookie( event )
	{
		LegalCookie.setCookie( oopsCookieName, 'accepted', LegalCookie.options );

		event.currentTarget.closest( oopsCookiesWrapper ).classList.remove( oopsCookieClass );
	}

	document.querySelectorAll( oopsCookiesWrapper ).forEach( function ( wrapper )
	{
		if ( LegalCookie.getCookie( oopsCookieName ) === undefined )
		{
			wrapper.querySelectorAll( '.age-button-yes-link' ).forEach( function ( button )
			{
				button.addEventListener( 'click', acceptCookie, false );
			} );

			wrapper.classList.add( oopsCookieClass );
		}
	} );

	// подпись вы уверены при нажатии кнопки нет. start

	const classes = {
		active: 'legal-active',

	};
	
    const selectors = {
		buttonNo: '.legal-oops-age .oops-age-button-no',

		textYouShure: '.legal-oops-age .oops-age-you-shure',

	};

	function pressButtonNoShowText( event )
	{
        console.log('скрипт подключился');
		event.currentTarget.classList.add( classes.active );
		document.querySelector( selectors.textYouShure ).classList.add( classes.active );
	}

	console.log(oopsCookiesWrapper.querySelector( selectors.buttonNo ));

	oopsCookiesWrapper.querySelectorAll( selectors.buttonNo ).forEach(i => {
		i.addEventListener( 'click', pressButtonNoShowText );  
  	});

	// подпись вы уверены при нажатии кнопки нет. end


} );

// oops-cookie age