// about-achievement-tooltip-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function toggleSet( element )
	{
		element.classList.toggle( classes.active );
	}

	function toggleModal( event )
	{
		// event.currentTarget.closest( selectors.aboutAchievement ).querySelectorAll( selectors.tooltipSet( event.currentTarget.dataset.tooltipSet ) ).forEach( toggleSet );
		// event.currentTarget.querySelectorAll( selectors.tooltipSet( event.currentTarget.dataset.tooltipSet ) ).forEach( toggleSet );

		event.currentTarget.closest( selectors.tooltipContainer ).querySelectorAll( selectors.tooltipSet( event.currentTarget.dataset.tooltipSet ) ).forEach( toggleSet );
	}

	function prepareClose( element )
	{
		element.dataset.tooltipSet = this.dataset.tooltipSet;

		element.addEventListener( 'click', toggleModal, false );
	}

	function prepareModal( element )
	{
		element.dataset.tooltipSet = this.dataset.tooltipSet;
	}
	
	function prepareTooltip( element )
	{
		if ( !element ) {
            return;
        };

		element.dataset.tooltipSet = this.dataset.tooltipSet;

		this.querySelectorAll( selectors.tooltip ).forEach( prepareModal, element );

		this.querySelectorAll( selectors.tooltipClose ).forEach( prepareClose, element );

		element.addEventListener( 'click', toggleModal, false );
	}

	function prepareElements( element, index )
	{
		element.dataset.tooltipSet = index;

		/* if( document.querySelector( selectors.aboutAchievement ).contains( document.querySelector( selectors.tooltip ) ) ) {
			element.querySelectorAll( selectors.tooltipOpen ).forEach( prepareTooltip, element );
		}; */
		if ( !element ) {
            return;
        };
		element.querySelectorAll( selectors.tooltipOpen ).forEach( prepareTooltip, element );
		// element.querySelectorAll( args.tooltipOpen ).forEach( prepareTooltip, element );
		
	}

	const classes = {
		active: 'legal-active',
	};

	const args = [
		{
			'tooltipContainer' : '.review-about .about-achievement',

			// 'tooltipOpen' : '.review-about .achievement-name',

			// 'tooltipClose' : '.review-about .achievement-tooltip-close',

			// 'tooltip' : '.review-about .achievement-tooltip-background',
		},

		{
			'tooltipContainer' : '.legal-review-page-sidebar .bonus-stats-items',

			// 'tooltipOpen' : '.legal-review-page-sidebar .stats-item-tooltip',

			// 'tooltipClose' : '.legal-review-page-sidebar .stats-item-tooltip .legal-tooltip-close',

			// 'tooltip' : '.legal-review-page-sidebar .stats-item-tooltip .legal-tooltip',
		},

	];

	const selectors = {
		tooltipOpen: '.legal-tooltip-open',

		tooltipClose: '.legal-tooltip-close',

		tooltip: '.legal-tooltip',

		tooltipContainer: '.legal-tooltip-container',

		// tooltipOpen: '.review-about .achievement-name',
		
		// tooltipClose: '.review-about .achievement-tooltip-close',

		// tooltip: '.review-about .achievement-tooltip-background',

		// aboutAchievement: '.review-about .about-achievement',

		// tooltipContainer: '.legal-review-page-sidebar .bonus-stats-items',

		tooltipSet: function ( id ) {
			return '[data-tooltip-set="' + id + '"]';
		}
	};

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

	/* if ( document.querySelector( selectors.aboutAchievement ).contains( tooltipBackground ) ) {
		tooltipBackground.addEventListener( 'click', closeBackgroundTooltip );
	}; */
	if ( document.querySelector( selectors.aboutAchievement ) ) {
		tooltipBackground.addEventListener( 'click', closeBackgroundTooltip );
	};

	// закрытие по клику на фон. Конец

	// добавление класса к контейнеру тултипа. Начало

	// добавление класса к контейнеру тултипа. конец
} );

// about-achievement-tooltip-js end 