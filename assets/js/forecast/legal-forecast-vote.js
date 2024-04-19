// legal-forecast-vote-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    const classes = {
		active: 'legal-active',

		// wrapperText: 'wrapper-text'
	};
	
    const selectors = {
		voteLabel: '.wp-polls .form_radio_btn label',

		voteInput: '.wp-polls .form_radio_btn input',

		voteButtonSend: '.wp-polls .Button-my-style',

		forecastContainer: '.wp-polls',

		linkView: '.wp-polls a'
	};

    function buttonDisable( event )
	{
        // console.log('скрипт подключился');
		document.querySelector( selectors.voteButtonSend ).classList.add( classes.active );
	}

	document.querySelectorAll( selectors.voteLabel ).forEach(i => {
		i.addEventListener( 'click', buttonDisable );  
  	}); 

	/* function inputCheck( event ) {
		if (event.checked) {
			console.log('is checked');
		} else {
			console.log('Checkbox is not checked');
			document.querySelector( selectors.voteButtonSend ).classList.add( classes.active );
		};
	};

	document.querySelectorAll( selectors.voteInput ).forEach(i => {
		i.addEventListener( 'click', inputCheck );
  	}); */

	let forecast = document.querySelector( selectors.forecastContainer );

	let observer = new MutationObserver(mutationRecords => {
		console.log(mutationRecords); // console.log(изменения)
	});

	observer.observe(forecast, {
		childList: true, // наблюдать за непосредственными детьми
		subtree: true, // и более глубокими потомками
		characterDataOldValue: true // передавать старое значение в колбэк
	});
	
} );

// legal-forecast-vote-js end