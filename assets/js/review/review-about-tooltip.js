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

		// tooltipOpen: '.review-about .achievement-name',
		
		// tooltipClose: '.review-about .achievement-tooltip-close',

		// tooltip: '.review-about .achievement-tooltip-background',

		aboutAchievement: '.review-about .about-achievement',

		// tooltipContainer: '.legal-review-page-sidebar .bonus-stats-items',

		tooltipSet: function ( id ) {
			return '[data-tooltip-set="' + id + '"]';
		}
	};
	
	function toggleSet( element )
	{
		element.classList.toggle( classes.active );
	}

	function toggleModal( event )
	{
		// event.currentTarget.closest( selectors.aboutAchievement ).querySelectorAll( selectors.tooltipSet( event.currentTarget.dataset.tooltipSet ) ).forEach( toggleSet );
		// toggleSet( event.currentTarget );

		// console.log( event.currentTarget );

		event.currentTarget.closest( selectors.tooltipContainer ).querySelectorAll( selectors.tooltipSet( event.currentTarget.dataset.tooltipSet ) ).forEach( toggleSet );
	}

	function prepareClose( element )
	{
		element.dataset.tooltipSet = this.dataset.tooltipSet;

		element.addEventListener( 'click', toggleModal, false );

		console.log('prepareClose:', element);
	}

	function prepareModal( element )
	{
		element.dataset.tooltipSet = this.dataset.tooltipSet;

		console.log('prepareModal:', element);
	}
	
	function prepareTooltip( element )
	{
		if ( !element ) {
            return;
        };

		if ( element.classList.contains( 'stats-item-tooltip' ) ) {
			element.parentNode.classList.add( classes.tooltipContainer );
		};

		element.dataset.tooltipSet = this.dataset.tooltipSet;

		this.querySelectorAll( selectors.tooltip ).forEach( prepareModal, element );

		// this.querySelectorAll( selectors.tooltipClose ).forEach( prepareClose, element );

		element.addEventListener( 'click', toggleModal, false );
	}

	function prepareElements( element, index )
	{
		element.dataset.tooltipSet = index;

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