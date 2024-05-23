// about-achievement-tooltip-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function toggleSet( element )
	{
		element.classList.toggle( classes.active );
	}

	function toggleModal( event )
	{
		event.currentTarget.closest( selectors.aboutAchievement ).querySelectorAll( selectors.tooltipSet( event.currentTarget.dataset.tooltipSet ) ).forEach( toggleSet );
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
		element.dataset.tooltipSet = this.dataset.tooltipSet;

		this.querySelectorAll( selectors.tooltip ).forEach( prepareModal, element );

		this.querySelectorAll( selectors.tooltipClose ).forEach( prepareClose, element );

		element.addEventListener( 'click', toggleModal, false );
	}

	function prepareElements( element, index )
	{
		element.dataset.tooltipSet = index;

		/* element.querySelectorAll( selectors.tooltipOpen ).forEach( prepareTooltip, element ); */
		if( document.querySelector( selectors.aboutAchievement ).contains( document.querySelector( selectors.tooltip ) ) ) {
			element.querySelectorAll( selectors.tooltipOpen ).forEach( prepareTooltip, element );
		} else false;
	}

	const classes = {
		active: 'legal-active',
	};

	const selectors = {
		tooltipOpen: '.review-about .achievement-name',
		
		tooltipClose: '.review-about .achievement-tooltip-close',

		tooltip: '.review-about .achievement-tooltip-background',

		aboutAchievement: '.review-about .about-achievement',

		tooltipSet: function ( id ) {
			return '[data-tooltip-set="' + id + '"]';
		}
	};

	document.querySelectorAll( selectors.aboutAchievement ).forEach( prepareElements );

	// закрытие по клику на фон. Начало
	let tooltipBackground = document.querySelector( selectors.tooltip );

	function closeBackgroundTooltip() {
		if( tooltipBackground.classList.contains( classes.active ) ) {
			tooltipBackground.classList.remove( classes.active );
		}
	}

	tooltipBackground.addEventListener( 'click', closeBackgroundTooltip );
	// закрытие по клику на фон. Конец
} );

// about-achievement-tooltip-js end 