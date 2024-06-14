// legal-tabs-info-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    // console.log('Скрипт legal-tabs-info подключён')

    const selectors = {

		highestTabContent : '.legal-tabs-info .legal-tab-content.legal-active',

        tabsContent : '.legal-tabs-info .legal-tab-content',

	};

    const highestTabInfoContent = document.querySelector( selectors.highestTabContent );

    const tabsInfoContent = document.querySelectorAll( selectors.tabsContent );

    let heightTextFirstTab = highestTabInfoContent.scrollHeight + 10 + 'px';

    console.log( heightTextFirstTab );

    // highestTabInfoContent.setAttribute( 'data-height', heightTextFirstTab );

    function setHeight( element )
	{
		element.style.setProperty('--element-height', heightTextFirstTab);
	}

    tabsInfoContent.forEach( setHeight );

    

} );

// legal-tabs-info-js end