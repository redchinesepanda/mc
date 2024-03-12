// compilation-tooltip-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function toggleSet( element )
	{
		element.classList.toggle( classes.active );
	}

	function toggleModal( event )
	{
		event.currentTarget.closest( selectors.compilation ).querySelectorAll( selectors.tooltipSet( event.currentTarget.dataset.tooltipSet ) ).forEach( toggleSet );
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

		element.querySelectorAll( selectors.tooltipOpen ).forEach( prepareTooltip, element );
	}

	const classes = {
		active: 'legal-active',
	};

	const selectors = {
		tooltipOpen: '.legal-compilation .compilation-attention-tooltip',
		
		tooltipClose: '.legal-tooltip .legal-tooltip-close',

		tooltip: '.legal-tooltip',

		compilation: '.legal-compilation',

		tooltipSet: function ( id ) {
			return '[data-tooltip-set="' + id + '"]';
		}
	};

	document.querySelectorAll( selectors.compilation ).forEach( prepareElements );
} );

// compilation-tooltip-js end