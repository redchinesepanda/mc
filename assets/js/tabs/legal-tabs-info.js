// legal-tabs-info-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    // console.log('Скрипт legal-tabs-info подключён')

    const selectors = {

		tabContent : '.legal-tabs-info .legal-tab-content.legal-active',


	};

    const tabInfoContent = document.querySelector( selectors.tabContent );

    let heightTextTab = tabInfoContent.scrollHeight;

    console.log( heightTextTab );

    tabInfoContent.setAttribute( 'data-height', heightTextTab );

    

} );

// legal-tabs-info-js end