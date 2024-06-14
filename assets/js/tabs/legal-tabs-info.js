// legal-tabs-info-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    // console.log('Скрипт legal-tabs-info подключён')

    const selectors = {

		firstTabContent : '.legal-tabs-info .legal-tab-content.legal-active',

        tabsContent : '.legal-tabs-info .legal-tab-content',

	};

    const firstTabInfoContent = document.querySelector( selectors.firstTabContent );

    const tabsInfoContent = document.querySelectorAll( selectors.tabsContent );

    let heightTextFirstTab = firstTabInfoContent.scrollHeight + 'px';

    console.log( heightTextFirstTab );

    // firstTabInfoContent.setAttribute( 'data-height', heightTextFirstTab );

    function setHeight( element )
	{
		element.style.setProperty('--element-height', heightTextFirstTab);
	}

    tabsInfoContent.forEach( setHeight );

    

} );

// legal-tabs-info-js end