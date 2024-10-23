// about-achievement-tooltip-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	const classes = {
		active: 'legal-active',

		tooltipContainer: 'legal-tooltip-container',

		tooltipItem: 'stats-item-tooltip'
	};

	const args = [
		{
			'tooltipContainer' : '.review-about .about-achievement .achievement-item'
		},

		{
			'tooltipContainer' : '.review-bonus-stats .stats-item-tooltip'
		}
	];

	const selectors = {
		body: 'body',

		tooltipContainer: '.legal-tooltip-container',

		tooltipControl: '.legal-tooltip-control',

		tooltip: '.legal-tooltip',

		tooltipClose: '.legal-tooltip-close',

		tooltipWrapper: '.legal-tooltip-wrapper',

		aboutAchievement: '.review-about .about-achievement',

		tooltipSet: function ( id ) {
			return '[data-tooltip-set="' + id + '"]';
		}
	};

	function removeSet( element )
	{
		element.classList.remove( classes.active );
	}

	function toggleSet( element )
	{
		element.classList.toggle( classes.active );
	}

	let tooltip = document.querySelectorAll( selectors.tooltip );

	function closeModalFromBody( event ) {
		//начало скрытия по клику вне зоны
		// let tooltip = document.querySelectorAll( selectors.tooltip );

		tooltip.forEach( (elem) => {
			console.log('поиск по боди');

			if ( !elem.contains( event.target ) && elem.classList.contains( classes.active ) ) {
				elem.classList.remove( classes.active );
			}

		});
		/* tooltip.forEach( (elem) => {
			console.log(elem);
			elem.classList.remove( classes.active );
		}); */
		
		//конец скрытия по клику вне зоны
	};

	function closeModal( event )
	{
		// console.log( 'closeModal' );
		// console.log( 'event.currentTarget', event.currentTarget );
		// console.log( 'event.currentTarget.closest( selectors.tooltip', event.currentTarget.closest( selectors.tooltip ));

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
		// console.log( 'prepareElements' );

		element.addEventListener( 'click', toggleModal, false );

		element.parentElement.querySelector( selectors.tooltipClose ).addEventListener( 'click', closeModal, false );

		let body = document.querySelector( selectors.body );

		body.addEventListener( 'click', closeModalFromBody, false );

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

		// console.log( arg.tooltipContainer );

		document.querySelectorAll( arg.tooltipContainer ).forEach( prepareElements );
	}

	function tooltipInit()
	{
		args.forEach( controlInit );
	}

	tooltipInit();

	window.addEventListener( 'resize', tooltipInit, false );


} );

// about-achievement-tooltip-js end 