// review-gallery-swipe-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function handleGesture( element )
	{
		let x = element.dataset.touchendX - element.dataset.touchstartX;

		let y = element.dataset.touchendY - element.dataset.touchstartY;

		let xy = Math.abs( x / y );

		let yx = Math.abs( y / x );

		if ( Math.abs( x ) > element.dataset.treshold || Math.abs( y ) > element.dataset.treshold )
		{
			if ( yx <= limit )
			{
				if ( x < 0 )
				{
					console.log( "left" );
				}
				else
				{
					console.log( "right" );
				}
			}
			if ( xy <= limit )
			{
				if ( y < 0 )
				{
					console.log( "top" );
				}
				else
				{
					console.log( "bottom" );
				}
			}
		}
		else
		{
			console.log( "tap" );
		}
	}

	function touchStart( event )
	{
		event.currentTarget.dataset.touchstartX = event.changedTouches[0].screenX;

		event.currentTarget.dataset.touchstartY = event.changedTouches[0].screenY;

		console.log( 'touchStart' );

		console.log( event.currentTarget.dataset );
	}

	function touchEnd( event )
	{
		event.currentTarget.dataset.touchendX = event.changedTouches[0].screenX;

		event.currentTarget.dataset.touchendY = event.changedTouches[0].screenY;

		console.log( 'touchEnd' );
		
		console.log( event.currentTarget.dataset );

		handleGesture( event.currentTarget );
	}

	function initDataset( element )
	{
		element.dataset.pageWidth = window.innerWidth || document.body.clientWidth;

		element.dataset.treshold = Math.max( 1, Math.floor( 0.01 * ( element.dataset.pageWidth ) ) );

		element.dataset.touchstartX = 0;

		element.dataset.touchstartY = 0;

		element.dataset.touchendX = 0;

		element.dataset.touchendY = 0;

		element.dataset.limit = Math.tan( 45 * 1.5 / 180 * Math.PI );
	}

	function setTouch( element )
	{
		initDataset( element );

		element.addEventListener( 'touchstart', touchStart );

		element.addEventListener( 'touchend', touchEnd );
	}

	// let pageWidth = window.innerWidth || document.body.clientWidth;

	// let treshold = Math.max( 1, Math.floor( 0.01 * ( pageWidth ) ) );

	// let touchstartX = 0;

	// let touchstartY = 0;

	// let touchendX = 0;

	// let touchendY = 0;

	// const limit = Math.tan( 45 * 1.5 / 180 * Math.PI );

	// const gestureZone = document.getElementById( 'modalContent' );

	// gestureZone.addEventListener( 'touchstart', function( event )
	// {
	// 	touchstartX = event.changedTouches[0].screenX;
	// 	touchstartY = event.changedTouches[0].screenY;
	// }, false );

	// gestureZone.addEventListener( 'touchend', function( event )
	// {
	// 	touchendX = event.changedTouches[0].screenX;
	// 	touchendY = event.changedTouches[0].screenY;
	// 	handleGesture( event );
	// }, false );

	// function handleGesture(e)
	// {
	// 	let x = touchendX - touchstartX;

	// 	let y = touchendY - touchstartY;

	// 	let xy = Math.abs( x / y );

	// 	let yx = Math.abs( y / x );

	// 	if ( Math.abs( x ) > treshold || Math.abs( y ) > treshold )
	// 	{
	// 		if ( yx <= limit )
	// 		{
	// 			if ( x < 0 )
	// 			{
	// 				console.log( "left" );
	// 			}
	// 			else
	// 			{
	// 				console.log( "right" );
	// 			}
	// 		}
	// 		if ( xy <= limit )
	// 		{
	// 			if ( y < 0 )
	// 			{
	// 				console.log( "top" );
	// 			}
	// 			else
	// 			{
	// 				console.log( "bottom" );
	// 			}
	// 		}
	// 	}
	// 	else
	// 	{
	// 		console.log( "tap" );
	// 	}
	// }

	const properties = {
		columnGap : 'column-gap',
	};

	const selectors = {
		imageset : '.tcb-post-content .legal-imageset',

		imagesetWrapper : '.tcb-post-content .legal-imageset-wrapper',

		imagesetCurrent : function( index )
		{
			return '.legal-imageset-' + index;
		},

		imagesetWrapperCurrent : function( index )
		{
			return '.legal-imageset-wrapper-' + index;
		},

		imagesetBackward : '.imageset-backward',

		imagesetForward : '.imageset-forward',
		
		imageFirst : function()
		{
			return this.imageset + ' .imageset-item:first-of-type';
		},

		imageActive : ' .legal-active'
	};

	const classes = {
		imagesetCurrent : function( index )
		{
			return 'legal-imageset-' + index;
		},

		imagesetWrapperCurrent : function( index )
		{
			return 'legal-imageset-wrapper-' + index;
		},

		imageActive : 'legal-active'
	};

	console.log( selectors.imagesetWrapper );
	
	document.querySelectorAll( selectors.imagesetWrapper ).forEach( setTouch );
	
	// document.querySelectorAll( selectors.imagesetWrapper ).forEach( slider );

	// function setActive( element )
	// {
	// 	element.classList.add( classes.imageActive );
	// }

	// document.querySelectorAll( selectors.imageFirst() ).forEach( setActive );
	  
} );

// review-gallery-swipe-js end