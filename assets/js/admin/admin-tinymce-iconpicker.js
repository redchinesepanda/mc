// mce-iconpicker-start

let IconPicker = ( function()
{
	"use strict";

	return {
		target: {},

		initIcons: function ()
		{
			function handleIcon( event )
			{
				event.preventDefault();

				let value = event.target.dataset.category + ' ' + event.target.dataset.icon

				IconPicker.target.value = value;

				tinyMCE.activeEditor.windowManager.close();
			}

			document.querySelectorAll( '.mc-icon-picker a[data-icon]' ).forEach( function ( icon )
			{
				icon.addEventListener( 'click', handleIcon, false );
			} );
		},

		getIcons: function ( icon )
		{
			const xhr = new XMLHttpRequest();

			xhr.onreadystatechange = function()
			{
				if ( xhr.readyState === xhr.DONE && xhr.status === 200 )
				{
					try
					{
						let iconPicker = document.querySelector( '.mc-icon-picker' );
		
						if ( iconPicker != null )
						{
							iconPicker.innerHTML = this.responseText;

							IconPicker.initIcons();
						}
					}
					catch ( error )
					{
						console.error( 'IconPicker.getIcons error' );

						console.error( error );
					}
				}
			}

			try
			{
				// xhr.open( "POST", MCAjax.ajax_url );
				
				// xhr.open( 'POST', '/wp-admin/admin-ajax.php' );
				
				xhr.open( 'GET', '/wp-admin/admin-ajax.php?action=mc_get_icons' );
				
				xhr.setRequestHeader( 'Content-type', 'text/html' );

				xhr.responseType = 'text/html';

				xhr.send();
				
				// xhr.send( 'action=mc_get_icons' );
			}
			catch ( error )
			{
				console.error( 'IconPicker.getIcons error' );

				console.error( error );
			}
		}
	};
} )();

tinymce.PluginManager.add( 'tinymce_iconpicker', function (editor, url)
{
	const openDialogIcons = function ()
	{
		editor.windowManager.open( {
			title: 'All icons',

			width: 1080,

			height: 768,

			body: [
				{
					type: "container",

					html: '<div class="mc-icon-picker-wrapper"></div>'
				}
			]
		} );
	}

	const openDialogIconSettings = function ()
	{
		function insertIconClass( e )
		{
			if ( e.data.mcIconPosition !== '' )
			{
				tinyMCE.activeEditor.selection.getNode().classList.add( e.data.mcIconPosition );
			}

			e.data.mcIconClass.split( ' ' ).forEach( function ( item ) {
				tinyMCE.activeEditor.selection.getNode().classList.add( item );
			} );
		}

		function insertIconElement( e )
		{
			let content = tinyMCE.activeEditor.selection.getContent();

			let contentElement = document.createElement( 'span' );

			contentElement.innerHTML = content;

			if ( e.data.mcIconPosition !== '' )
			{
				contentElement.classList.add( e.data.mcIconPosition );
			}

			e.data.mcIconClass.split( ' ' ).forEach( function ( item ) {
				contentElement.classList.add( item );
			} );

			content = contentElement.outerHTML;

			tinyMCE.activeEditor.selection.setContent( content );
		}

		function insertDataToContent ( e )
		{
			if ( tinyMCE.activeEditor.selection.getContent() !== tinyMCE.activeEditor.selection.getNode().textContent && tinyMCE.activeEditor.selection.getContent() !== '' )
			{
				insertIconElement( e );
			}
			else
			{
				insertIconClass( e );
			}
		}

		editor.windowManager.open( {
			title: 'Insert icon',
			
			body: [
				{
					type: 'listbox',

					name: 'mcIconPosition',

					label: 'Icon Position',

					'values': [
						{ text: "::before", value: "" },

						{ text: "::after", value: "icon-position-after" },
					]
				},

				{
					type: "container",

					label: "MC Icon",

					layout: "flex",

					direction: "row",

					items: [

						{
							type: 'textbox',
							
							name: 'mcIconClass'
						},

						{
							type: 'button',

							text: 'Choose',

							onclick: function ( event )
							{
								let elementButton = Object.values( this.$el )[ 0 ];

								let elementInput = elementButton.previousElementSibling;

								IconPicker.target = elementInput;

								openDialogIcons();

								IconPicker.getIcons();
							},
						}
					],
				}
			],
			
			onSubmit: function ( e )
			{
				insertDataToContent( e );
			}
		} );
	}

	editor.addButton( 'tinymce_iconpicker', {
		title: 'Insert Icon',
		
		// icon: 'plus',

		icon: 'emoticons',

		onclick: function ()
		{
		  openDialogIconSettings();
		}
	} );

	return {
		getMetadata: function () {
			return  {
				name: 'TinyMCE Custom Font Icon Picker',

				url: 'http://match.center'
			};
		}
	  };
} );

// mce-iconpicker-end