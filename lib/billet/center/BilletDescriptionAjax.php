<?php

class BilletDescriptionAjax
{
	const NONCE = 'mc-ajax-billet';

	const ACTIONS = [
		'get-description' => 'mc_ajax_get_description',
	];

	const JS = [
        'mc-ajax-get-description' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/billet/billet-ajax-get-description.js',

			'ver' => '1.0.0',
		],
    ];

	private static function get_ajax_general()
	{
		return [
			'mc-ajax-get-description' => [
				'object_name' => 'MCAjax',
	
				'data' => [
					'ajax_url' => admin_url( 'admin-ajax.php' ),
				],
			],
		];
	}

	private static function get_ajax_billet()
	{
		return [
			'mc-ajax-get-description' => [
				'object_name' => 'MCAjaxBillet',
	
				'data' => [
					'actionGetDescription' => self::ACTIONS[ 'get-description' ],

					'nonce' => wp_create_nonce( self::NONCE ),
				],
			],
		];
	}

	public static function register_script()
    {
		ToolEnqueue::register_script( self::JS );

		ToolEnqueue::localize_script( self::get_ajax_general() );

		ToolEnqueue::localize_script( self::get_ajax_billet() );
    }

	public static function register_functions()
	{
		// if ( self::check() )
		// {
			$handler = new self();
	
			add_action( 'wp_ajax_' . self::ACTIONS[ 'get-description' ], [ $handler, 'mc_ajax_get_description' ] );

			add_action( 'wp_ajax_nopriv_' . self::ACTIONS[ 'get-description' ], [ $handler, 'mc_ajax_get_description' ] );
		// }
	}

	public static function register()
	{
		if ( self::check() )
		{
			$handler = new self();
	
			add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
		}

		// LegalDebug::debug( [
		// 	'BilletDescriptionAjax' => 'register',

		// 	'check' => self::check(),
		// ] );
	}

	public static function check()
	{
		return LegalComponents::check_contains( '[legal-tabs]' );
	}

	public static function mc_ajax_get_description()
	{
		check_ajax_referer( self::NONCE );

		$code = 0;

		$status = 'success';

		$message = [];
		
		// $post_id = 0;

		$description = '';

		if ( ! empty( $_POST[ 'post_id' ] ) )
		
		// if ( ! empty( $_GET[ 'post_id' ] ) )
		{
			$post_id = $_POST[ 'post_id' ];
			
			// $post_id = $_GET[ 'post_id' ];

			// $description = BilletDescription::get( [
			// 	'id' => $post_id,
			// ] );
			
			$description = BilletMain::get_main_description( $post_id, [] );

			// LegalDebug::debug( [
			// 	'BilletDescriptionAjax' => 'mc_ajax_get_description',

			// 	// 'post_id' => $_POST[ 'post_id' ],
				
			// 	'post_id' => $_GET[ 'post_id' ],

			// 	'description' => $description,
			// ] );
		}

		echo json_encode( [
			'code' => $code,
			
			'status' => $status,
			
			'message' => $message,

			'description' => $description,
		] );
		
		die();
	}
}

?>