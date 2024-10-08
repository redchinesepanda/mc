<?php

class AdminTinyMCEIconPicker
{
	const CSS_ADMIN = [
        'admin-tinymce-iconpicker' => LegalMain::LEGAL_URL . '/assets/css/admin/admin-tinymce-iconpicker.css',

		// assets\font\mc-icons-sports\mc-icons-sports.css

        'admin-tinymce-iconpicker-icons' => LegalMain::LEGAL_URL . '/assets/font/mc-icons-sports/mc-icons-sports.css',

        'admin-tinymce-iconpicker-font-mc-icons-sports' => LegalMain::LEGAL_URL . '/assets/font/font-main.css',
    ];

	public static function add_editor_styles()
	{
		// foreach ( self::CSS as $style ) {
		// 	add_editor_style( $style );
		// }

		ToolEnqueue::add_editor_styles( self::CSS_ADMIN );
	}

	private static function get_ajax_general()
	{
		return [
			'mc-ajax-icon-picker' => [
				'object_name' => 'MCAjax',
	
				'data' => [
					'ajax_url' => admin_url( 'admin-ajax.php' ),
				],
			],
		];
	}

	// const JS = [
    //     'review-about' => [
	// 		'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-about.js',

	// 		'ver' => '1.0.0',
	// 	],
    // ];

	public static function register_script()
    {
		ToolEnqueue::localize_script( self::get_ajax_general() );
    }

	public static function check_user_permission_edit()
    {
        return current_user_can( 'edit_posts' )
			
			&& current_user_can( 'edit_pages' );
    }

	public static function check_editor_enabled()
    {
        return get_user_option( 'rich_editing' ) == 'true';
    }

	public static function check_icon_picker()
    {
        return self::check_user_permission_edit()
		
			&& self::check_editor_enabled();
    }

	public static function register_functions_admin()
    {
        // if ( self::check_icon_picker() )
        // {
            $handler = new self();

			add_filter( 'mce_external_plugins', [ $handler, 'add_tinymce_iconpicker_plugin' ] );

			add_filter( 'mce_buttons', [ $handler, 'register_iconpicker_button' ] );

			add_action( 'after_setup_theme', [ $handler, 'add_editor_styles' ] );

			add_filter( 'tiny_mce_before_init', [ $handler, 'add_valid_elements_icons' ] );

			add_action( 'wp_ajax_mc_get_icons', [ $handler, 'ajax_mc_get_icons' ] );

			add_action( 'wp_ajax_nopriv_mc_get_icons', [ $handler, 'ajax_mc_get_icons' ] );

			add_action( 'admin_enqueue_scripts', [ $handler, 'register_script' ] );

			self::get_icons_json();
        // }
    }

	public static function add_valid_elements_icons( $init )
	{
		$init[ 'extended_valid_elements' ] = 'i[class],span[class,style]';

		// custom_elements: "emstart,emend",

		$init[ 'custom_elements' ] = 'i';
	
		return $init;
	}

	public static function add_tinymce_iconpicker_plugin( $plugin_array )
	{
		$plugin_array[ 'tinymce_iconpicker' ] = LegalMain::LEGAL_URL . '/assets/js/admin/admin-tinymce-iconpicker.js';

		return $plugin_array;
	}

	public static function register_iconpicker_button( $buttons )
	{
		$buttons[] = 'tinymce_iconpicker';

		return $buttons;
	}

	const JSON_ICONS = [
		'mc-icons-sports' => [
			'name' => 'MC Icons Sports',

			'path' => LegalMain::LEGAL_PATH . '/assets/font/mc-icons-sports/mc-icons-sports.json',
		], 
	];

	public static function get_categories_json()
	{
		$categories = [];

		foreach ( self::JSON_ICONS as $key => $font )
		{
			$json = file_get_contents( $font[ 'path' ] );

			LegalDebug::debug( [
				'AdminTinyMCEIconPicker' => 'get_categories_json-1',

				'path' => $path,

				'json' => $json,
			] );

			if ( $json )
			{
				$icons = json_decode( $json, true );

				LegalDebug::debug( [
					'AdminTinyMCEIconPicker' => 'get_categories_json-2',
	
					'icons' => $icons,
				] );

				if ( $icons )
				{
					LegalDebug::debug( [
						'AdminTinyMCEIconPicker' => 'get_categories_json-3',

						'font' => $font,

						'icons' => $icons,
					] );

					$categories[] = [
						'key' => $key,
	
						'label' => ToolLoco::translate( $font[ 'name' ] ),
		
						'icons' => array_keys( $icons ),
					];
				}
			}

			return $categories;
		}

		// Read the JSON file

		// $json = file_get_contents('my_data.json'); 

		// Check if the file was read successfully

		// if ($json === false) {
		// 	die('Error reading the JSON file');
		// }

		// Decode the JSON file
		// $json_data = json_decode($json, true); 

		// Check if the JSON was decoded successfully
		// if ($json_data === null) {
		// 	die('Error decoding the JSON file');
		// }

		// Display data
		// echo "<pre>";
		// print_r($json_data);
		// echo "</pre>";
	}

	public static function get_icons()
	{
		return [
			'categories' => self::get_categories_json(),

			// 'categories' => [
			// 	[
			// 		'key' => 'arrows',
	
			// 		'label' => ToolLoco::translate( 'Arrows & Direction Icons' ),
	
			// 		'icons' => [
			// 			'ti-arrow-up' => 'arrow-up',
	
			// 			'ti-arrow-right' => 'arrow-right',
	
			// 			'ti-arrow-left' => 'arrow-left',
	
			// 			'ti-arrow-down' => 'arrow-down',
			// 		],
			// 	],
			// ]
		];
	}

	public static function ajax_mc_get_icons()
	{
		// if ( current_user_can( 'edit_theme_options' ) || current_user_can( 'publish_posts' ) )
		// {
			// $icons = Themify_Icons_Icon_Picker::get_icons();

			// include THEMIFY_ICONS_DIR . 'templates/icon-picker.php';

			// die;
		// }

		echo self::render_icons();

		die();
	}

	const TEMPLATE = [
        'default' => LegalMain::LEGAL_PATH . '/template-parts/admin/part-icon-picker.php',
    ];

	public static function render_icons()
	{
		return LegalComponents::render_main( self::TEMPLATE[ 'default' ], self::get_icons() );
	}
}

?>