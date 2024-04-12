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

		this.querySelectorAll( selectors.tooltip ).forEach( toggleSet, element );

		element.addEventListener( 'click', toggleModal, false );
	}

	function prepareElements( element, index )
	{
		element.dataset.tooltipSet = index;

		element.querySelectorAll( selectors.tooltipOpen ).forEach( prepareTooltip, element );
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
} );

// about-achievement-tooltip-js end 