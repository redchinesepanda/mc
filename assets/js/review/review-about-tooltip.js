// about-achievement-tooltip-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	const classes = {
		active: 'legal-active',

		// tooltipContainer: 'legal-tooltip-container',

		// tooltipItem: 'stats-item-tooltip'
	};

	const args = [
		{
			'tooltipControl' : '.review-about .about-achievement .achievement-item'
		},

		{
			'tooltipControl' : '.review-bonus-stats .stats-item-tooltip'
		},

		{
			'tooltipControl' : '.review-about .about-data .about-rating'
		}
	];

	const selectors = {
		body: 'body',

		// tooltipContainer: '.legal-tooltip-container',

		// tooltipControl: '.legal-tooltip-control',

		tooltip: '.legal-tooltip',

		tooltipClose: '.legal-tooltip-close',

		tooltipWrapper: '.legal-tooltip-wrapper',

		// aboutAchievement: '.review-about .about-achievement',

		tooltipSet: function ( id ) {
			return '[data-tooltip-set="' + id + '"]';
		}
	};

	function removeSet( element )
	{
		element.classList.remove( classes.active );
	}

	//начало скрытия по клику вне зоны
	function closeModalFromBody( event ) {
		let tooltip = document.querySelectorAll( selectors.tooltip );

		tooltip.forEach( (elem) => {
			let tooltipControl = elem.previousElementSibling;

			if ( !elem.contains( event.target ) && !tooltipControl.contains( event.target ) ) {
				removeSet( elem );
			}
		});
	};

	function findClickBody() {
		let body = document.querySelector( selectors.body );

		body.addEventListener( 'click', closeModalFromBody, false );
	};
	//конец скрытия по клику вне зоны

	function toggleSet( element )
	{
		element.classList.toggle( classes.active );

		findClickBody();
	}

	function closeModal( event )
	{
		// console.log( 'closeModal' );

		removeSet( event.currentTarget.closest( selectors.tooltip ) );
	}

	function toggleModal( event )
	{
		// console.log( 'toggleModal' );

		toggleSet( event.currentTarget );

		toggleSet( event.currentTarget.parentElement.querySelector( selectors.tooltip ) );

	}

	const mediaQuery = {
		desktop : '( min-width: 960px )'
	}

	function prepareElements( element )
	{
		// console.log( 'prepareElements: element', element );

		if ( !element.parentElement.querySelector( selectors.tooltip && !element.parentElement.querySelector( selectors.tooltipClose ) ) ) {
			return;
		}

		element.addEventListener( 'click', toggleModal, false );

		element.parentElement.querySelector( selectors.tooltipClose ).addEventListener( 'click', closeModal, false );

		let tooltipWrapper = element.parentElement.querySelector( selectors.tooltipWrapper );
	
		if ( tooltipWrapper )
		{
			if ( ! window.matchMedia( mediaQuery.desktop ).matches )
			{
				tooltipWrapper.addEventListener( 'click', closeModal, false );
			}
			else
			{
				tooltipWrapper.removeEventListener( 'click', closeModal, false );
			}
		}
	}

	function controlInit( arg )
	{	
		// console.log( 'controlInit' );

		document.querySelectorAll( arg.tooltipControl ).forEach( prepareElements );
	}

	function tooltipInit()
	{
		args.forEach( controlInit );
	}

	tooltipInit();

	window.addEventListener( 'resize', tooltipInit, false );


} );

// about-achievement-tooltip-js end 