// Yandex.Metrika counter start

// (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
// m[i].l=1*new Date();
// for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
// k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
// (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

// ym(86785715, "init", {
// 	clickmap:true,
// 	trackLinks:true,
// 	accurateTrackBounce:true,
// 	webvisor:true
// });

document.addEventListener( 'DOMContentLoaded', function ()
{
	function ymInit()
	{
		(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
		m[i].l=1*new Date();
		for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
		k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
		(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

		ym(86785715, "init", {
			clickmap:true,
			trackLinks:true,
			accurateTrackBounce:true,
			webvisor:true
		});
	}

	if ( MetrikaLib.checkCookie() )
	{
		// ymInit();

		MetrikaLib.userInit( ymInit );
	}

	document.addEventListener( LegalCookieOops.oopsCookieHandler, ymInit, { once: true } );
	
} );

// Yandex.Metrika counter end