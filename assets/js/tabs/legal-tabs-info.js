// legal-tabs-info-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    const selectors = {

		firstTabContent : '.legal-tabs-info .legal-tab-content.legal-active',

        tabsContent : '.legal-tabs-info .legal-tab-content',

	};

    const firstTabInfoContent = document.querySelector( selectors.firstTabContent );

    let strLineHeight = 36;

    let heightTextFirstTab = firstTabInfoContent.scrollHeight + strLineHeight + 'px';

    function setHeight( element ) {
		element.style.setProperty('--element-height', heightTextFirstTab);
	};

    function initDetermineHeight() {
        const tabsInfoContent = document.querySelectorAll( selectors.tabsContent );

        tabsInfoContent.forEach( setHeight );
    };

    initDetermineHeight();

} );

// legal-tabs-info-js end