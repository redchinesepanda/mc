// about-achievement-tooltip-js start

document.addEventListener( 'DOMContentLoaded', function ()
{

	const classes = {
		active: 'legal-active',

		tooltipContainer: 'legal-tooltip-container',
	};

	const args = [
		{
			'tooltipContainer' : '.review-about .about-achievement',
		},

		{
			'tooltipContainer' : '.legal-review-page-sidebar .bonus-stats-items',
		},

	];

	const selectors = {
		tooltipOpen: '.legal-tooltip-open',

		tooltipClose: '.legal-tooltip-close',

		tooltip: '.legal-tooltip',

		tooltipContainer: '.legal-tooltip-container',

		aboutAchievement: '.review-about .about-achievement',

	};

	function toggleSet( event )
	{
		console.log('клик по открытияю', event);

		console.log( event.target.closest( selectors.tooltipContainer ) );
		event.target.closest( selectors.tooltipContainer ).classList.toggle( classes.active );
	}

	function toggleClose( event )
	{
		console.log('должно удалиться')
		event.target.closest( selectors.tooltipContainer ).classList.remove( classes.active );
	}

	function prepareClose( element )
	{
		element.addEventListener( 'click', toggleClose, false );
	}

	function prepareTooltip( element )
	{
		if ( !element ) {
            return;
        };

		if ( element.classList.contains( 'stats-item-tooltip' ) ) {
			element.parentNode.classList.add( classes.tooltipContainer );
		};

		// this.querySelectorAll( selectors.tooltipClose ).forEach( prepareClose, element );

		element.addEventListener( 'click', toggleSet, false );
	}

	function prepareElements( element )
	{
		if ( !element ) {
            return;
        };

		element.querySelectorAll( selectors.tooltipOpen ).forEach( prepareTooltip, element );
		
	}

	function tooltipInit() {
		args.forEach( function ( arg ) {
			document.querySelectorAll( arg.tooltipContainer ).forEach( prepareElements );
		} );
	}

	tooltipInit();

	// document.querySelectorAll( selectors.aboutAchievement ).forEach( prepareElements );

	// закрытие по клику на фон. Начало
	let tooltipBackground = document.querySelector( selectors.tooltip );

	function closeBackgroundTooltip() {
		if( tooltipBackground.classList.contains( classes.active ) ) {
			tooltipBackground.classList.remove( classes.active );
		}
	}

	if ( document.querySelector( selectors.aboutAchievement ) ) {
		tooltipBackground.addEventListener( 'click', closeBackgroundTooltip );
	};

	// закрытие по клику на фон. Конец

} );

// about-achievement-tooltip-js end 