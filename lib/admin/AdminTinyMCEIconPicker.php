<?php

class AdminTinyMCEIconPicker
{
	const CSS_ADMIN = [
		// global css variables

		'admin-font-main' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-main.css',

			'ver' => '1.0.1',
		],

		// admin icons style 

        'admin-iconpicker' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/admin/admin-iconpicker.css',

			'ver' => '1.0.1',
		],

		// mc-icons style

        'admin-style-mc-icons' =>  [
			'path' => LegalMain::LEGAL_URL . '/assets/font/mc-icons/mc-icons.css',

			'ver' => '1.0.1',
		],

		// mc-icons font

		'admin-font-mc-icons' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-mc-icons.css',

			'ver' => '1.0.1',
		],

		// mc-icons-sports style

        'admin-style-mc-icons-sports' =>  [
			'path' => LegalMain::LEGAL_URL . '/assets/font/mc-icons-sports/mc-icons-sports.css',

			'ver' => '1.0.1',
		],

		// mc-icons-sports font

		'admin-font-mc-icons-sports' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-mc-icons-sports.css',

			'ver' => '1.0.1',
		],

		// mc-icons-country style

		'admin-style-mc-icons-country' =>  [
			'path' => LegalMain::LEGAL_URL . '/assets/font/mc-icons-country/mc-icons-country.css',

			'ver' => '1.0.1',
		],

		// mc-icons-payment style

		'admin-style-mc-icons-payment' =>  [
			'path' => LegalMain::LEGAL_URL . '/assets/font/mc-icons-payment/mc-icons-payment.css',

			'ver' => '1.0.2',
		],
    ];

	public static function register_style()
    {
		ToolEnqueue::register_style( self::CSS_ADMIN );
    }

	const CSS_ADMIN_MCE = [
		// global css variables

        'admin-mce-style-mc-icons-sports' => LegalMain::LEGAL_URL . '/assets/font/font-main.css',

		// admin mce icons style

        'admin-mce-iconpicker' => LegalMain::LEGAL_URL . '/assets/css/admin/admin-mce-iconpicker.css',

		// admin mce mc-icons style

		'admin-mce-icons' => LegalMain::LEGAL_URL . '/assets/font/mc-icons/mc-icons.css',

		// admin mce mc-icons font

		'admin-mce-font-mc-icons' => LegalMain::LEGAL_URL . '/assets/font/font-mc-icons.css',

		// admin mce mc-icons-sports style

		'admin-mce-font-mc-icons-sports' => LegalMain::LEGAL_URL . '/assets/font/font-mc-icons-sports.css',

		// admin mce mc-icons-sports font

		'admin-mce-icons-sports' => LegalMain::LEGAL_URL . '/assets/font/mc-icons-sports/mc-icons-sports.css',

		// admin mce mc-icons-country style

		'admin-mce-style-mc-icons-country' => LegalMain::LEGAL_URL . '/assets/font/mc-icons-country/mc-icons-country.css',

		// admin mce mc-icons-payment style

		'admin-mce-style-mc-icons-payment' => LegalMain::LEGAL_URL . '/assets/font/mc-icons-payment/mc-icons-payment.css',

		// admin mce mc-icons font

		'admin-mce-font-mc-icons' => LegalMain::LEGAL_URL . '/assets/font/font-mc-icons.css',
    ];

	public static function add_editor_styles()
	{
		// foreach ( self::CSS as $style ) {
		// 	add_editor_style( $style );
		// }

		ToolEnqueue::add_editor_styles( self::CSS_ADMIN_MCE );
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

			add_action( 'admin_enqueue_scripts', [ $handler, 'register_style' ] );
        // }
    }

	public static function add_valid_elements_icons( $init )
	{
		// $init[ 'extended_valid_elements' ] = 'i[class],span[class,style]';
		
		$init[ 'extended_valid_elements' ] = '-em[class|style],i[class|id|style]';

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
		'mc-icons' => [
			'name' => 'MC Icons',

			'prefix' => 'icon',

			'path' => LegalMain::LEGAL_PATH . '/assets/font/mc-icons/mc-icons.json',
		],

		'mc-icons-sports' => [
			'name' => 'MC Icons Sports',

			'prefix' => 'icon-sports',

			'path' => LegalMain::LEGAL_PATH . '/assets/font/mc-icons-sports/mc-icons-sports.json',
		],

		'mc-icons-country' => [
			'name' => 'MC Icons Country',

			'prefix' => 'icon-country',

			'path' => LegalMain::LEGAL_PATH . '/assets/font/mc-icons-country/mc-icons-country.json',
		],

		'mc-icons-payment' => [
			'name' => 'MC Icons Payment',

			'prefix' => 'icon-payment',

			'path' => LegalMain::LEGAL_PATH . '/assets/font/mc-icons-payment/mc-icons-payment.json',
		], 
	];

	public static function get_categories_json()
	{
		$categories = [];

		foreach ( self::JSON_ICONS as $key => $font )
		{
			$json = file_get_contents( $font[ 'path' ] );

			if ( $json )
			{
				$icons = json_decode( $json, true );

				if ( $icons )
				{
					$categories[] = [
						'key' => $key,
	
						'label' => ToolLoco::translate( $font[ 'name' ] ),
		
						'icons' => array_keys( $icons ),

						'prefix' => $font[ 'prefix' ],
					];
				}
			}
		}

		return $categories;
	}

	// public static function get_categories_manual()
	// {
	// 	return [
	// 		[
	// 			'key' => 'mc-icons-country',

	// 			'label' => 'MC Icons Country',

	// 			'icons' => [
	// 				'country-en',

	// 				'country-br',
	// 			],
	// 		],

	// 		// [
	// 		// 	'key' => 'mc-icons-payment',

	// 		// 	'label' => 'MC Icons Payment',

	// 		// 	'icons' => [
	// 		// 		'payment-paypal',
	// 		// 	],
	// 		// ],
	// 	];
	// }

	public static function get_icons()
	{
		return [
			// 'categories' => array_merge( self::get_categories_json(), self::get_categories_manual() ),
			
			'categories' => self::get_categories_json(),
		];
	}

	public static function ajax_mc_get_icons()
	{
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