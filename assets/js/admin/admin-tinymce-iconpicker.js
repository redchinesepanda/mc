/*
  Note: We have included the plugin in the same JavaScript file as the TinyMCE
  instance for display purposes only. Tiny recommends not maintaining the plugin
  with the TinyMCE instance and using the `external_plugins` option.
*/

// lib-cookie start

let IconPicker = ( function()
{
	"use strict";

	return {
		target: {},

		show: function ()
		{
			console.log( 'IconPicker.show' );
		},

		close: function ()
		{
			console.log( 'IconPicker.close' );
		},

		initIcons: function ()
		{
			function handleIcon( event )
			{
				// editor.windowManager.close();

				tinyMCE.activeEditor.windowManager.close();
			}

			document.querySelectorAll( '.mc-icon-picker a[data-icon]' ).forEach( function ( icon )
			{
				icon.addEventListener( 'click', handleIcon, false );
			} );
		},

		getIcons: function ( icon )
		{
			console.log( 'IconPicker.getIcons' );

			const xhr = new XMLHttpRequest();

			xhr.onreadystatechange = function()
			{
				if ( xhr.readyState === xhr.DONE && xhr.status === 200 )
				{
					try
					{
						// let parsed = JSON.parse( this.responseText );

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
		},

		setIcon: function ( icon )
		{
			console.log( 'IconPicker.setIcon' );
		}
	};
} )();

// lib-cookie end
tinymce.PluginManager.add( 'tinymce_iconpicker', function (editor, url)
{
	// const openDialog = () => editor.windowManager.open( {
	
	const openDialogIcons = function ()
	{
		editor.windowManager.open( {
			title: 'All icons',

			width: 1080,

			height: 768,

			body: [
				{
					type: "container",

					html: '<div class="mc-icon-picker"></div>'
				}
			]
		} );
	}

	const openDialog = function ()
	{
		// function getIconsAjax( e )
		// {
		// 	console.log( 'getIconsAjax e' );

		// 	console.log( e );
		// }

		function insertDataToContent ( e )
		{
			let content = '<span class="mc-icon-container"><i class="mc-icon mc-icons-sports ' + e.data.class + '"></i></span>';

			console.log( 'insertDataToContent content' );

			console.log( content );

			editor.insertContent( content );

			/* Insert content when the window form is submitted */

			// return content;
		}

		editor.windowManager.open( {
			title: 'Insert icon',
			
			body: [
				{
					type: "container",

					label: "MC Icon",

					layout: "flex",

					direction: "row",

					items: [
						{ type: "textbox", name: "mc-textbox-name" },

						{
							type: "button",

							text: "Choose",

							onclick: function ()
							{
								// getIconsAjax( this.$el );

								// IconPicker.show();

								openDialogIcons();

								IconPicker.getIcons();

								// IconPicker.initIcons();

								// (TI_Picker.target = jQuery(this.$el).prev()), TI_Picker.showLightbox(null);

								// console.log( 'container button' );

								// console.log( this.$el.previousElementSibling );

								// console.log( this.$el.children );

								// console.log( this.$el.previousSibling );

								// console.log( this.$el );
							},
						}
					],
				}
			],

			// buttons: [
			// 	{
			// 		type: 'cancel',
			// 		text: 'Close'
			// 	},
			// 	{
			// 		type: 'submit',
			// 		text: 'Save',
			// 		buttonType: 'primary'
			// 	}
			// ],

			// onSubmit: dataOutput
			
			// onSubmit: function ( e )
			// {
			// 	let content = '<span class="mc-icon-container"><i class="mc-icon mc-icons-sports ' + e.data.class + '"></i></span>';

			// 	console.log( 'openDialog onSubmit' );

			// 	console.log( content );

			// 	/* Insert content when the window form is submitted */

			// 	editor.insertContent( content );
			// }
			
			onSubmit: function ( e )
			{
				insertDataToContent( e );

				// let html = toIconHTML( e.data );

				// editor.insertContent( html );
			}
		} );
	}

	/* Add a button that opens a window */

	editor.addButton( 'tinymce_iconpicker', {
		// text: 'Insert Button',

		title: 'Insert Icon',

		icon: 'icon mce-i-plus',

		onClick: function ()
		{
		  /* Open window */

		  openDialog();
		}
	} );

	/* Return the metadata for the help plugin */

	return {
		getMetadata: function () {
			return  {
				name: 'TinyMCE Custom Font Icon Picker',

				url: 'http://match.center'
			};
		}
	  };
} );

// tinymce.PluginManager.add( 'tinymce_iconpicker', function (editor, url)
// {
// 	editor.addButton('tinymce_iconpicker', {
// 		title: 'Insert Button',

// 		icon: 'icon mce-i-plus',

// 		stateSelector: ['span[mc-icon]'],

// 		onclick: function ()
// 		{
// 			editor.windowManager.open(
// 				{
// 					title: 'Insert icon',

// 					width: 500,

// 					height: 300,

// 					body: [

// 						{
// 							type: 'listbox',

// 							name: 'class',

// 							label: 'Choose Icon',

// 							'values': [
// 								{ text: "American football", value: "icon-american-football" },

// 								{ text: "Asian", value: "icon-asian" },

// 								{ text: "Athletics", value: "icon-athletics" }
// 							]
// 						},

// 						// {
// 						// 	type: 'htmlpanel',

// 						// 	html: 'Panel content goes here.'
// 						// },

// 						{
// 							type: "container",

// 							label: "MC Icon",

// 							layout: "flex",

// 							direction: "row",

// 							items: [
// 								{ type: "textbox", name: "mc-textbox-name" },

// 								{
// 									type: "button",

// 									text: "Choose",

// 									onclick() {
// 										// (TI_Picker.target = jQuery(this.$el).prev()), TI_Picker.showLightbox(null);

// 										console.log( 'container button' );

// 										console.log( this.$el.previousElementSibling );

// 										console.log( this.$el.children );

// 										console.log( this.$el.previousSibling );

// 										console.log( this.$el );
// 									},
// 								}
// 							],
// 						}
// 					],

// 					onsubmit: function ( element )
// 					{
// 						// let $content = '<a href="' + e.data.url + '" class="btn' + (e.data.style !== 'default' ? ' ' + e.data.style : '') + '"' + (!!e.data.newtab ? ' target="_blank"' : '') + '>' + e.data.label + '</a>';

// 						let content = '<span class="mc-icon-container"><i class="mc-icon mc-icons-sports ' + element.data.class + '"></i></span>';

// 						editor.insertContent( content );
// 					}
// 				}
// 			);
// 		}
// 	} );
// } );