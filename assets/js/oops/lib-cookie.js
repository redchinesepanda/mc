// lib-cookie start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function setCookie( name, value, options )
	{
		options = options || {};

		var expires = options.expires;

		if ( typeof expires == "number" && expires )
		{
			var d = new Date();

			d.setTime( d.getTime() + expires * 1000) ;

			expires = options.expires = d;
		}
		if ( expires && expires.toUTCString )
		{
			options.expires = expires.toUTCString();
		}

		value = encodeURIComponent( value );

		var updatedCookie = name + "=" + value;

		for ( var propName in options )
		{
			updatedCookie += "; " + propName;

			var propValue = options[ propName ];

			if ( propValue !== true )
			{
				updatedCookie += "=" + propValue;
			}
		}

		// console.log( 'app.wazzup24.com setCookie updatedCookie: ' + JSON.stringify( updatedCookie ) );

		document.cookie = updatedCookie;

		// console.log( 'app.wazzup24.com setCookie document.cookie: ' + JSON.stringify( document.cookie ) );
	}
	
	function getCookie( name )
	{
		// console.log( 'app.wazzup24.com getCookie document.cookie: ' + JSON.stringify( document.cookie ) );

		// let matches = document.cookie.match(new RegExp(
		// 	"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
		// ));

		let matches = document.cookie.match( new RegExp(
			name.replace( /([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1' ) + "=([^;]*)"
		) );

		// console.log( 'app.wazzup24.com getCookie matches: ' + JSON.stringify( matches ) );

		return matches ? decodeURIComponent( matches[1] ) : undefined;
	}
} );

// lib-cookie end