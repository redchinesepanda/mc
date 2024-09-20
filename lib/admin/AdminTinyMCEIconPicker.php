<?php

class AdminTinyMCEIconPicker
{
	const CSS = [
        'admin-tinymce-iconpicker' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/admin/admin-tinymce-iconpicker.css',

            'ver'=> '1.2.1',
        ],

		'legal-template-font-mc-icons-sports' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-mc-icons-sports.css',

			'ver' => '1.0.0',
		],
    ];

	public static function register_style()
    {
		ToolEnqueue::register_style( self::CSS );
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

	public static function register()
    {
        // if ( self::check_icon_picker() )
        // {
            $handler = new self();

			add_filter( 'mce_external_plugins', [ $handler, 'add_tinymce_iconpicker_plugin' ] );

			add_filter( 'mce_buttons', [ $handler, 'register_iconpicker_button' ] );

			add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

			add_action( 'admin_print_styles', [ $handler, 'register_style' ] );
        // }
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

}

?>