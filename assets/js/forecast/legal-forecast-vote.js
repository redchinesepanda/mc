// legal-forecast-vote-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    const classes = {
		active: 'legal-active',

		wrapperText: 'wrapper-text'
	};
	
    const selectors = {
		voteLabel: '.wp-polls .form_radio_btn label',

		voteButtonSend: '.wp-polls .Button-my-style',

		voteList: '.wp-polls .wp-polls-ans li'
	};

    function buttonDisable( event )
	{
        // console.log('скрипт подключился');
		document.querySelector( selectors.voteButtonSend ).classList.add( classes.active );
	}

	document.querySelectorAll( selectors.voteLabel ).forEach(i => {
		i.addEventListener( 'click', buttonDisable );  
  	}); 

	function wrap( parent ) {
		const wrapper = document.createElement('div');
		wrapper.classList = classes.wrapperText;
		parent.childNodes.forEach(ch => wrapper.appendChild(ch));
		console.log(parent.childNodes);
		parent.appendChild(wrapper);
	}
	
	document.querySelectorAll( selectors.voteList ).forEach(li => wrap( li ));
	
} );

// legal-forecast-vote-js end