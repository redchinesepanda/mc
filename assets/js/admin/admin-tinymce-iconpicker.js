tinymce.PluginManager.add('tinymce_iconpicker', function (editor, url) {
	editor.addButton('tinymce_iconpicker', {
		title: 'Insert Button',

		icon: 'icon mce-i-plus',

		onclick: function ()
		{
			editor.windowManager.open(
				{
					title: 'Insert icon',

					width: 500,

					height: 300,

					body: [
						{
							type: 'textbox',
							name: 'url',
							label: 'URL'
						},

						{
							type: 'textbox',
							name: 'label',
							label: 'Link Text'
						},

						{
							type: 'checkbox',
							name: 'newtab',
							label: ' ',
							text: 'Open link in new tab',
							checked: true
						},

						{
							type: 'listbox',

							name: 'style',

							label: 'Choose Icon',

							'values': [
								{ text: "Primary", value: "default" },

								{ text: "Secondary", value: "secondary" },

								{ text: "Disabled", value: "disabled" }
							]
						}
					],

					onsubmit: function (e)
					{
						let $content = '<a href="' + e.data.url + '" class="btn' + (e.data.style !== 'default' ? ' ' + e.data.style : '') + '"' + (!!e.data.newtab ? ' target="_blank"' : '') + '>' + e.data.label + '</a>';
						editor.insertContent($content);
					}
				}
			);
		}
	} );
} );