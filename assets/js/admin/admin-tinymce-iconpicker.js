tinymce.PluginManager.add('tinymce_iconpicker', function (editor, url) {
	editor.addButton('tinymce_iconpicker', {
		title: 'Insert Button',

		icon: 'icon mce-i-plus',

		stateSelector: ['span[mc-icon]'],

		onclick: function ()
		{
			editor.windowManager.open(
				{
					title: 'Insert icon',

					width: 500,

					height: 300,

					body: [
						// {
						// 	type: 'textbox',

						// 	name: 'url',

						// 	label: 'URL'
						// },

						// {
						// 	type: 'textbox',

						// 	name: 'label',

						// 	label: 'Link Text'
						// },

						// {
						// 	type: 'checkbox',

						// 	name: 'newtab',

						// 	label: ' ',

						// 	text: 'Open link in new tab',

						// 	checked: true
						// },

						{
							type: 'listbox',

							name: 'class',

							label: 'Choose Icon',

							'values': [
								{ text: "American football", value: "icon-american-football" },

								{ text: "Asian", value: "icon-asian" },

								{ text: "Athletics", value: "icon-athletics" }
							]
						},

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

										if ( this.$el.previousElementSibling )
										{
											let previous = this.$el.previousElementSibling;

											console.log( previous );
										}

										console.log( this.$el );
									},
								}
							],
						}
					],

					onsubmit: function ( element )
					{
						// let $content = '<a href="' + e.data.url + '" class="btn' + (e.data.style !== 'default' ? ' ' + e.data.style : '') + '"' + (!!e.data.newtab ? ' target="_blank"' : '') + '>' + e.data.label + '</a>';

						let content = '<span class="mc-icon-container"><i class="mc-icon mc-icons-sports ' + element.data.class + '"></i></span>';

						editor.insertContent( content );
					}
				}
			);
		}
	} );
} );