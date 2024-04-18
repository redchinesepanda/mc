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

		// voteList: '.wp-polls .wp-polls-ans li',

		// linkView: '.wp-polls a'
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
	
} );

// legal-forecast-vote-js end