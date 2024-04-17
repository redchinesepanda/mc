// legal-forecast-vote-js start

document.addEventListener( 'DOMContentLoaded', function () {

    const classes = {
		active: 'legal-active',
	};
	
    const selectors = {
		voteLabel: '.wp-polls .form_radio_btn label',

		voteButtonSend: '.wp-polls .Button-my-style'
	};

    function buttonDisable( event ) {
        console.log('скрипт подключился');
		document.querySelector( selectors.voteButtonSend ).classList.toggle( classes.active );
	}

    document.querySelector( selectors.voteLabel ).addEventListener( 'click', buttonDisable );

} );

// legal-forecast-vote-js end 