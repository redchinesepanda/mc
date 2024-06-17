// legal-tabs-info-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    // console.log('Скрипт legal-tabs-info подключён')

    const selectors = {

		firstTabContent : '.legal-tabs-info .legal-tab-content.legal-active',

        tabsContent : '.legal-tabs-info .legal-tab-content',

	};

    // console.log( heightTextFirstTab );

    // firstTabInfoContent.setAttribute( 'data-height', heightTextFirstTab );

    function setHeight( element ) {
        const firstTabInfoContent = document.querySelector( selectors.firstTabContent );

        let strLineHeight = 36;

        let heightTextFirstTab = firstTabInfoContent.scrollHeight + strLineHeight + 'px';

		element.style.setProperty('--element-height', heightTextFirstTab);
	}

    function initDetermineHeight() {
        const tabsInfoContent = document.querySelectorAll( selectors.tabsContent );

        tabsInfoContent.forEach( setHeight );
    }

    initDetermineHeight()


    

} );

// legal-tabs-info-js end