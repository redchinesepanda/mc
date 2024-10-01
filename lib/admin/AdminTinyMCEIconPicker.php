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

	// const JS = [
    //     'review-about' => [
	// 		'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-about.js',

	// 		'ver' => '1.0.0',
	// 	],
    // ];

	// public static function register_script()
    // {
	// 	if ( TemplateMain::check_new() )
	// 	{
	// 		ToolEnqueue::register_script( self::JS_NEW );
	// 	}
    // }

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

			add_action( 'wp_ajax_mc_get_icons', 'wp_ajax_mc_get_icons' );
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

	public static function wp_ajax_mc_get_icons()
	{
		// if ( current_user_can( 'edit_theme_options' ) || current_user_can( 'publish_posts' ) )
		// {
			// $icons = Themify_Icons_Icon_Picker::get_icons();

			// include THEMIFY_ICONS_DIR . 'templates/icon-picker.php';

			// die;
		// }

		echo self::render_icons();
	}

	const TEMPLATE = [
        'default' => LegalMain::LEGAL_PATH . '/template-parts/admin/part-icon-picker.php',
    ];

	public static function render_icons()
	{
		return 'test';

		// return LegalComponents::render_main( self::TEMPLATE[ 'default' ], self::get_icons() );
	}

	public static function get_icons()
	{
		return [
			'categories' => [
				[
					'key' => 'arrows',
	
					'label' => ToolLoco::translate( 'Arrows & Direction Icons' ),
	
					'icons' => [
						'ti-arrow-up' => 'arrow-up',
	
						'ti-arrow-right' => 'arrow-right',
	
						'ti-arrow-left' => 'arrow-left',
	
						'ti-arrow-down' => 'arrow-down',
					],
				],
			]
		];
	}
}

?>