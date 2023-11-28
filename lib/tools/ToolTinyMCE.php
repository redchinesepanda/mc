<?php

class ToolTinyMCE
{
	const JS = [
        'tool-tinymce' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/tools/tool-tinymce.js',

			'ver' => '1.0.1',
		],
    ];

    public static function register_script()
    {
		ToolEnqueue::register_script( self::JS );
    }

    public static function register()
    {
        $handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_overview' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_contextbox' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_column' ] );

		add_action( 'after_setup_theme', [ $handler, 'editor_styles' ] );

		add_action( 'admin_enqueue_scripts', [ $handler, 'register_script' ] );

		add_filter('tiny_mce_before_init', [ $handler, 'disable_rel_noopener' ] );
		
		// add_filter('wp_targeted_link_rel', [ $handler, 'disable_rel_noreferer' ], 999 );
		
		add_filter('wp_targeted_link_rel', [ $handler, 'disable_rel_noreferer' ] );
    }

	public static function disable_rel_noopener( $init )
	{

		$init[ 'allow_unsafe_link_target' ] = true;
	
		return $init;
	}

	// function disable_rel_noreferer( $rel, $link_html )
	
	public static function disable_rel_noreferer( $rel )
	{	
		// $rel_filtered = preg_replace( '/noopener\s*/i', '', $rel );

		// $rel_filtered = preg_replace( '/noreferrer\s*/i', '', $rel_filtered );

		// return false;
		
		// return '';
		
		// LegalDebug::die( [
		// 	'function' => 'disable_rel_noreferer',

		// 	'rel' => $rel,

		// 	'rel_filtered' => $rel_filtered,
		// ] );
		
		// return $rel_filtered;

		return;
	}

	const CSS = [
        'legal-tinymce-main' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-main.css',

        'legal-tinymce-overview' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-overview.css',

        'legal-tinymce-table' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-table.css',

        'legal-tinymce-pros' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-pros.css',

        'legal-tinymce-header' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-header.css',
    ];

	public static function editor_styles() {
		foreach ( self::CSS as $style ) {
			add_editor_style( $style );
		}
	}

	public static function style_formats_check( $settings, $style_new )
	{
		$style_formats = [];

		if ( !empty( $settings[ 'style_formats' ] ) ) {
			$style_formats = json_decode( $settings[ 'style_formats' ] );
		}

		$settings[ 'style_formats' ] = json_encode( array_merge( $style_formats, $style_new ) );

		return $settings;
	}

	public static function style_formats_overview( $settings )
	{
		return self::style_formats_check( $settings, [
			[
				'title' => 'Overview',

				'items' => [
					[
						'title' => 'Overview Start',
						
						'selector' => 'p',

						'classes' => 'legal-overview-start',
					],

					[
						'title' => 'Overview',
						
						'selector' => 'p',

						'classes' => 'legal-overview',
					],

					[
						'title' => 'Overview End',
						
						'selector' => 'p',

						'classes' => 'legal-overview-end',
					],
				],
			],
		] );
	}

	public static function style_formats_contextbox( $settings )
	{
		return self::style_formats_check( $settings, [
			[
				'title' => 'Contextboxes',

				'items' => [
					[
						'title' => 'Contextbox',
						
						'selector' => 'p',
		
						'classes' => 'legal-contextbox',
					],
					[
						'title' => 'Attention',
						
						'selector' => 'p',
		
						'classes' => 'legal-attention',
					],
					[
						'title' => 'Highlight',
						
						'selector' => 'p,ul',
		
						'classes' => 'legal-highlight',
					],
				],
			],
		] );
	}

	public static function style_formats_column( $settings )
	{
		return self::style_formats_check( $settings, [
			[
				'title' => 'Column',

				'items' => [
					[
						'title' => 'Колонка 50%',
						
						'selector' => 'table',
		
						'classes' => 'legal-column',
					],

					[
						'title' => 'Колонка 33.333%',
						
						'selector' => 'table',
		
						'classes' => 'legal-column-3',
					],
				],
			],
		] );
	}
}

?>