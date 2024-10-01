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

	function style_inline_title( $settings )
	{
        // $settings['content_style'] = '* {outline: 1px solid red;}';
        
		$settings[ 'content_style' ] = ReviewTitle::inline_style( '#tinymce' ); 

        return $settings;
	}

    public static function register()
    {
        $handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_overview' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_contextbox' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_column' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_inline_title' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'modify_color_map' ] );

		add_action( 'after_setup_theme', [ $handler, 'add_editor_styles' ] );

		add_action( 'admin_enqueue_scripts', [ $handler, 'register_script' ] );

		// add_filter('tiny_mce_before_init', [ $handler, 'init_link_rel' ] );

		add_filter('tiny_mce_before_init', [ $handler, 'init_link_attribute_rel' ] );
		
		add_filter('wp_targeted_link_rel', [ $handler, 'disable_rel_noopener' ], 999 );
    }

	public static function modify_color_map( $init )
	{
		// $init[ 'color_map' ] = [
		
		$init[ 'textcolor_map' ] = json_encode( [
			'000000', 'Black',
			'808080', 'Gray',
			'FFFFFF', 'White',
			'FF0000', 'Red',
			'FFFF00', 'Yellow',
			'008000', 'Green',
			'0000FF', 'Blue'
		] );
	
		return $init;
	}

	public static function init_link_attribute_rel( $init )
	{
		// LegalDebug::debug( [
		// 	'ToolTinyMCE' => 'init_link_attribute_rel-1',

		// 	'init' => $init,
		// ] );

		$init[ 'allow_unsafe_link_target' ] = true;

		$init[ 'default_link_target' ] = '';

		$init[ 'rel_list' ] = json_encode( [
			[
				'title' => 'No rel attribbute',

				'value' => '',
			],

			[
				'title' => 'rel="noreferrer"',

				'value' => 'noreferrer',
			],

			[
				'title' => 'rel="noreferrer nofollow"',

				'value' => 'noreferrer nofollow',
			],
		] );
	
		return $init;
	}

	// public static function init_anchors( $init )
	// {
	// 	$init[ 'allow_unsafe_link_target' ] = true;

	// 	$init[ 'default_link_target' ] = '';

	// 	$init[ 'rel_list' ] = json_encode( [
	// 		[
	// 			'title' => 'none',

	// 			'value' => '',
	// 		],

	// 		[
	// 			'title' => 'nofollow',

	// 			'value' => 'nofollow',
	// 		],

	// 		[
	// 			'title' => 'nofollow noopener',

	// 			'value' => 'nofollow noopener',
	// 		],
	// 	] );
	
	// 	return $init;
	// }
	
	public static function disable_rel_noopener( $rel )
	{	
		return preg_replace( '/noopener\s*/i', '', $rel );
	}

	const CSS = [
        'legal-tinymce-main' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-main.css',

        'legal-tinymce-overview' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-overview.css',

        'legal-tinymce-table' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-table.css',

        'legal-tinymce-pros' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-pros.css',

        'legal-tinymce-header' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-header.css',
    ];

	public static function add_editor_styles()
	{
		// foreach ( self::CSS as $style ) {
		// 	add_editor_style( $style );
		// }

		ToolEnqueue::add_editor_styles( self::CSS );
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