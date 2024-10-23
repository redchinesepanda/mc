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
			// 'tooltipContainer' : '.review-about .about-achievement',
			
			'tooltipContainer' : '.review-about .about-achievement .achievement-item'
		},

		{
			// 'tooltipContainer' : '.legal-review-page-sidebar .bonus-stats-items',
			
			'tooltipContainer' : '.review-bonus-stats .stats-item-tooltip'
		}
	];

	const selectors = {
		tooltipContainer: '.legal-tooltip-container',

		tooltipOpen: '.legal-tooltip-open',

		tooltip: '.legal-tooltip',

		tooltipClose: '.legal-tooltip-close',

		// tooltipOpen: '.review-about .achievement-name',
		
		// tooltipClose: '.review-about .achievement-tooltip-close',

		// tooltip: '.review-about .achievement-tooltip-background',

		aboutAchievement: '.review-about .about-achievement',

		// tooltipContainer: '.legal-review-page-sidebar .bonus-stats-items',

		tooltipSet: function ( id ) {
			return '[data-tooltip-set="' + id + '"]';
		}
	};

	function addSet( element )
	{
		element.classList.toggle( classes.active );
	}

	function removeSet( element )
	{
		element.classList.toggle( classes.active );
	}

	function toggleSet( element )
	{
		element.classList.toggle( classes.active );
	}

	function toggleModal( event )
	{
		// event.currentTarget.closest( selectors.aboutAchievement ).querySelectorAll( selectors.tooltipSet( event.currentTarget.dataset.tooltipSet ) ).forEach( toggleSet );
		// toggleSet( event.currentTarget );

		console.log( 'toggleModal' );

		console.log( event.currentTarget );

		event.currentTarget.closest( selectors.tooltipContainer )
			.querySelectorAll( selectors.tooltipSet( event.currentTarget.dataset.tooltipSet ) )
			.forEach( toggleSet );
	}

	function closeModal( event )
	{
		// event.currentTarget.closest( selectors.aboutAchievement ).querySelectorAll( selectors.tooltipSet( event.currentTarget.dataset.tooltipSet ) ).forEach( toggleSet );
		// toggleSet( event.currentTarget );

		console.log( 'closeModal' );

		console.log( event.currentTarget );

		// event.currentTarget.closest( selectors.tooltipContainer )
		// 	.querySelectorAll( selectors.tooltipSet( event.currentTarget.dataset.tooltipSet ) )
		// 	.forEach( toggleSet );
		
		event.currentTarget.closest( selectors.tooltip ).forEach( toggleSet );
	}

	function openModal( event )
	{
		// event.currentTarget.closest( selectors.aboutAchievement ).querySelectorAll( selectors.tooltipSet( event.currentTarget.dataset.tooltipSet ) ).forEach( toggleSet );
		// toggleSet( event.currentTarget );

		console.log( 'openModal' );

		console.log( event.currentTarget );

		// event.currentTarget.closest( selectors.tooltipContainer )
		// 	.querySelectorAll( selectors.tooltipSet( event.currentTarget.dataset.tooltipSet ) )
		// 	.forEach( addSet );
		
		event.currentTarget
			.querySelectorAll( selectors.tooltip )
			.forEach( addSet );
	}

	function prepareClose( element )
	{
		console.log( 'prepareClose' );

		console.log( element );

		// element.dataset.tooltipSet = this.dataset.tooltipSet;

		// element.addEventListener( 'click', toggleModal, false );
		
		element.addEventListener( 'click', closeModal, false );

		// console.log('prepareClose:', element);
	}

	// function prepareModal( element )
	// {
	// 	console.log( 'prepareModal' );

	// 	element.dataset.tooltipSet = this.dataset.tooltipSet;

	// 	// console.log('prepareModal:', element);
	// }
	
	// function prepareTooltip( element )
	// {
	// 	console.log( 'prepareTooltip' );

	// 	console.log( element );

	// 	console.log( element.dataset.tooltipSet );

	// 	// if ( !element ) {
    //     //     return;
    //     // };

	// 	// if ( element.classList.contains( classes.tooltipItem ) )
	// 	// {
	// 	// 	element.parentNode.classList.add( classes.tooltipContainer );
	// 	// }

	// 	element.addEventListener( 'click', openModal, false );

	// 	// element.dataset.tooltipSet = this.dataset.tooltipSet;

	// 	// this.querySelectorAll( selectors.tooltip ).forEach( prepareModal, element );
		
	// 	// element.querySelectorAll( selectors.tooltip ).forEach( prepareModal, element );

	// 	// this.querySelectorAll( selectors.tooltipClose ).forEach( prepareClose, element );

	// 	// console.log( selectors.tooltipClose );

	// 	element.querySelectorAll( selectors.tooltipClose ).forEach( prepareClose, element );
		
	// 	// .addEventListener( 'click', toggleModal, false );
	// }

	function prepareElements( element, elementID )
	{
		console.log( 'prepareElements' );

		// console.log(`${element}, ${elementID}, ${this}`);
		
		// console.log( `${element}, ${elementID}` );

		// console.log( element );

		// element.dataset.tooltipSet = elementID;

		// console.log( elementID );

		// console.log( element.dataset.tooltipSet );

		// if ( ! element ) {
        //     return;
        // };

		// element.querySelectorAll( selectors.tooltipOpen ).forEach( prepareTooltip, element );
		
		// prepareTooltip( element );

		element.addEventListener( 'click', openModal, false );

		element.querySelectorAll( selectors.tooltipClose ).forEach( prepareClose, element );
	}

	function tooltipInit() {
		args.forEach( function ( arg ) {
			// console.log( arg.tooltipContainer );

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