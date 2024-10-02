/*
  Note: We have included the plugin in the same JavaScript file as the TinyMCE
  instance for display purposes only. Tiny recommends not maintaining the plugin
  with the TinyMCE instance and using the `external_plugins` option.
*/
tinymce.PluginManager.add( 'tinymce_iconpicker', function (editor, url)
{
	// const openDialog = () => editor.windowManager.open( {
	const openDialog = function ()
	{
		editor.windowManager.open( {
			title: 'Insert icon',
			// body: {
			// 	type: 'panel',

			// 	items: [
			// 		{
			// 			type: 'input',
			// 			name: 'title',
			// 			label: 'Title'
			// 		}
			// 	]
			// },
			
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

							onclick() {
								// (TI_Picker.target = jQuery(this.$el).prev()), TI_Picker.showLightbox(null);

								console.log( 'container button' );

								console.log( this.$el.previousElementSibling );

								console.log( this.$el.children );

								console.log( this.$el.previousSibling );

								console.log( this.$el );
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

			onSubmit: function ( element )
			{
				let content = '<span class="mc-icon-container"><i class="mc-icon mc-icons-sports ' + element.data.class + '"></i></span>';

				console.log( 'openDialog onSubmit' );

				console.log( 'content' );

				/* Insert content when the window form is submitted */

				editor.insertContent( content );
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
		getMetadata: () => ( {
		  name: 'Example plugin',

		  url: 'http://exampleplugindocsurl.com'
		} )
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