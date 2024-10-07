/*
  Note: We have included the plugin in the same JavaScript file as the TinyMCE
  instance for display purposes only. Tiny recommends not maintaining the plugin
  with the TinyMCE instance and using the `external_plugins` option.
*/

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
				event.preventDefault();

				IconPicker.target.value = event.target.dataset.icon;

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
		},

		setIcon: function ( icon )
		{
			console.log( 'IconPicker.setIcon' );
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

					html: '<div class="mc-icon-picker"></div>'
				}
			]
		} );
	}

	const openDialogIconSettings = function ()
	{
		function insertDataToContent ( e )
		{
			let content = '<span class="mc-icon-container"><i class="mc-icon mc-icons-sports ' + e.data.class + '"></i></span>';

			console.log( 'insertDataToContent content' );

			console.log( content );

			editor.insertContent( content );
		}

		editor.windowManager.open( {
			title: 'Insert icon',
			
			body: [
				{
					type: 'listbox',

					name: 'mc-class-position',

					label: 'Icon Position',

					'values': [
						{ text: "::before", value: "icon-position-before" },

						{ text: "span", value: "icon-position-span" },

						{ text: "::after", value: "icon-position-after" }
					]
				},

				{
					type: "container",

					label: "MC Icon",

					layout: "flex",

					direction: "row",

					items: [

						{
							type: "textbox",
							
							name: "mc-class-icon"
						},

						{
							type: "button",

							text: "Choose",

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

		icon: 'icon mce-i-plus',

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