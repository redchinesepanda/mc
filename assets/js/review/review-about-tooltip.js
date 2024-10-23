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
		tooltipContainer: '.legal-tooltip-container',

		tooltipControl: '.legal-tooltip-control',

		tooltip: '.legal-tooltip',

		tooltipClose: '.legal-tooltip-close',

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

	function prepareElements( element )
	{
		// console.log( 'prepareElements' );

		element.addEventListener( 'click', toggleModal, false );

		element.parentElement.querySelector( selectors.tooltipClose ).addEventListener( 'click', closeModal, false );
	}

	function controlInit( arg )
	{	
		// console.log( 'controlInit' );

		// console.log( arg.tooltipContainer );

		document.querySelectorAll( arg.tooltipContainer ).forEach( prepareElements );
	}

	function tooltipInit()
	{
		// console.log( 'tooltipInit' );

		// console.log( args );

		args.forEach( controlInit );
	}

	tooltipInit();

	// document.querySelectorAll( selectors.aboutAchievement ).forEach( prepareElements );

	// закрытие по клику на фон. Начало

	// let tooltipBackground = document.querySelector( selectors.tooltip );

	// function closeBackgroundTooltip() {
	// 	if( tooltipBackground.classList.contains( classes.active ) ) {
	// 		tooltipBackground.classList.remove( classes.active );
	// 	}
	// }

	// if ( document.querySelector( selectors.aboutAchievement ) ) {
	// 	tooltipBackground.addEventListener( 'click', closeBackgroundTooltip );
	// };

	// закрытие по клику на фон. Конец

} );

// about-achievement-tooltip-js end 