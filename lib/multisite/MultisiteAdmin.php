<?php

class MultisiteAdmin
{
	const DOACTION = [
		'move-to' => 'move_to_',

		'sync-galleries' => 'mc_sync_galleries',

		'sync-terms' => 'mc_sync_terms',

		'sync-attachments' => 'mc_sync_attachments',
	];

	const QUERY_ARG = [
		'posts-moved' => 'mc_posts_moved',
		
		'blog-id' => 'mc_blog_id',

		'attachment-moved' => 'mc_attachment_moved',

		'galleries-synced' => 'mc_galleries_synced',
	];

	// const POST_TYPES = [
	// 	'page' => 'page',

	// 	'post' => 'post',

	// 	'brand' => 'legal_brand',

	// 	'billet' => 'legal_billet',

	// 	'compilation' => 'legal_compilation',
	// ];
	
	const POST_TYPES_DEFAULT = [
		'page' => 'edit-page',

		'post' => 'edit-post',
	];

	const POST_TYPES_CUSTOM = [
		'brand' => 'edit-legal_brand',

		'billet' => 'edit-legal_billet',

		'compilation' => 'edit-legal_compilation',

		'affiliate' => 'edit-affiliate-links',
	];

	// const POST_TYPES_POST = [
	// 	'page' => 'edit-page',

	// 	'post' => 'edit-post',

	// 	'brand' => 'edit-legal_brand',

	// 	'billet' => 'edit-legal_billet',

	// 	'compilation' => 'edit-legal_compilation',
	// ];

	const POST_TYPES_ATTACHMENT = [
		'attachment' => 'upload',
	];

	// const POST_TYPES = [
	// 	...self::POST_TYPES_POST,

	// 	...self::POST_TYPES_ATTACHMENT,
	// ];

	const PATTERNS = [
		// 'move-to' => 'Move to [%s]',

		'bulk-actions' => 'bulk_actions-%s',

		'handle-bulk-actions' => 'handle_bulk_actions-%s',
	];

	public static function get_post_types_post()
	{
		return array_merge( self::POST_TYPES_DEFAULT, self::POST_TYPES_CUSTOM );
	}

	public static function get_post_types()
	{
		return array_merge( self::POST_TYPES_DEFAULT, self::POST_TYPES_CUSTOM, self::POST_TYPES_ATTACHMENT );
	}
	
	// public static function add_filter_all( $name, $object, $handler, $priority = 10, $accepted_args = 1 )
	
	public static function add_filter_all( $pattern, $values, $object, $handler, $priority = 10, $accepted_args = 1 )
	{
		foreach ( $values as $post_type )
		{
			$name = sprintf( $pattern, $post_type );

			// add_filter( $name . $post_type, [ $object, $handler ], $priority, $accepted_args );

			// LegalDebug::debug( [
			// 	'MultisiteAdmin' => 'add_filter_all',

			// 	'name' => $name,

			// 	'handler' => $handler,
			// ] );
			
			add_filter( $name, [ $object, $handler ], $priority, $accepted_args );
		}
	}

	public static function register_functions_mainsite()
	{
		if ( MultisiteBlog::check_main_blog() )
		{
			$handler = new self();
	
			// add bulk actions
	
			// self::add_filter_all( 'bulk_actions-edit-', $handler, 'mc_bulk_multisite_actions' );
			
			self::add_filter_all(
				self::PATTERNS[ 'bulk-actions' ],
				
				self::get_post_types(),
				
				$handler,
				
				'mc_bulk_multisite_actions'
			);
	
			// show an post notice
	
			add_action( 'admin_notices', [ $handler, 'mc_bulk_multisite_notices' ] );
	
			// show an attacment notice
	
			add_action( 'admin_notices', [ $handler, 'mc_bulk_multisite_attachment_notices' ] );
		}
	}

	public static function register_functions_subsite()
	{
		if ( !MultisiteBlog::check_main_blog() )
		{
			$handler = new self();

			self::add_filter_all(
				self::PATTERNS[ 'bulk-actions' ],
				
				self::POST_TYPES_DEFAULT,
				
				$handler,
				
				'mc_bulk_subsite_actions'
			);

			add_action( 'admin_notices', [ $handler, 'mc_bulk_updated_notices' ] );
		}
	}
	
	public static function mc_bulk_multisite_actions( $bulk_array )
	{
		$sites = get_sites( [
			'site__not_in' => MultisiteBlog::get_current_blog_id(),

			'number' => 32,
		] );
		
		if ( $sites )
		{
			$pattern = ToolLoco::translate( MiltisiteMain::TEXT[ 'copy-to' ] );

			foreach ( $sites as $site )
			{
				// $bulk_array[ self::DOACTION[ 'move-to' ] . $site->blog_id ] = 'Move to [' . $site->blogname . ']';
				
				$bulk_array[ self::DOACTION[ 'move-to' ] . $site->blog_id ] = sprintf( $pattern, $site->blogname );
			}
		}

		return $bulk_array;
	}

	public static function mc_bulk_subsite_actions( $bulk_array )
	{
		$bulk_array = array_merge( $bulk_array, [
			self::DOACTION[ 'sync-galleries' ] => ToolLoco::translate( MiltisiteMain::TEXT[ 'sync-galleries' ] ),

			self::DOACTION[ 'sync-terms' ] => ToolLoco::translate( MiltisiteMain::TEXT[ 'sync-terms' ] ),

			self::DOACTION[ 'sync-attachments' ] => ToolLoco::translate( MiltisiteMain::TEXT[ 'sync-attachments' ] ),
		] );

		return $bulk_array;
	}

	public static function get_message( $pattern, $values )
	{
		return ToolLoco::translate_plural(
			// MiltisiteMain::TEXT_PLURAL[ 'post-has-been-copied-to' ],

			$pattern,

			$values
		);
	}

	public static function mc_bulk_multisite_notices()
	{
		if ( ! empty( $_REQUEST[ self::QUERY_ARG[ 'posts-moved' ] ] ) )
		{
			$blog = MultisiteBlog::get_blog_details( $_REQUEST[ self::QUERY_ARG[ 'blog-id' ] ] );

			$message = self::get_message(
				MiltisiteMain::TEXT_PLURAL[ 'post-has-been-copied-to' ],

				[
					$_REQUEST[ self::QUERY_ARG[ 'posts-moved' ] ],

					$blog->blogname,
				]
			);
			
			$args = [
                'message' => $message,
			];

			self::print_notices( $args );
		}
	}

	public static function check_request_updated( $request )
	{
		$updated_requests = [
			self::QUERY_ARG[ 'galleries-synced' ],

			self::QUERY_ARG[ 'terms-synced' ],

			self::QUERY_ARG[ 'attachments-synced' ],
		];

		foreach ( $updated_requests as $updated_request )
		{
			if ( ! empty( $_REQUEST[ $updated_request ] ) )
			{
				return true;
			}
		}
		
		return false;
	}

	public static function mc_bulk_updated_notices()
	{
		// if ( ! empty( $_REQUEST[ self::QUERY_ARG[ 'galleries-synced' ] ] ) )
		
		if ( self::check_request_updated( $_REQUEST ) )
		{
			$blog = MultisiteBlog::get_blog_details( $_REQUEST[ self::QUERY_ARG[ 'blog-id' ] ] );

			$message = self::get_message(
				MiltisiteMain::TEXT_PLURAL[ 'post-has-been-updated' ],

				[
					$_REQUEST[ self::QUERY_ARG[ 'galleries-synced' ] ],

					$blog->blogname,
				]
			);
			
			$args = [
                'message' => $message,
			];

			self::print_notices( $args );
		}
	}
	
	function mc_bulk_multisite_attachment_notices()
	{
		if( ! empty( $_REQUEST[ self::QUERY_ARG[ 'attachment-moved' ] ] ) )
		{
			$blog = MultisiteBlog::get_blog_details( $_REQUEST[ self::QUERY_ARG[ 'blog-id' ] ] );

			$message = self::get_message(
				MiltisiteMain::TEXT_PLURAL[ 'image-has-been-copied-to' ],

				[
					$_REQUEST[ self::QUERY_ARG[ 'posts-moved' ] ],

					$blog->blogname,
				]
			);

			$args = [
                'message' => $message,
			];

			self::print_notices( $args );
		}
	}

	const TEMPLATE = [
        'multisite-notices' => LegalMain::LEGAL_PATH . '/template-parts/multisite/part-multisite-notices.php',
    ];

	public static function print_notices( $args )
    {
        LegalComponents::print_main( self::TEMPLATE[ 'multisite-notices' ], $args );
    }

	public static function redirect_clean( $redirect )
	{
		return remove_query_arg( self::QUERY_ARG, $redirect );
	}

	// public static function redirect_set( $redirect, $posts_moved, $blog_id )
	
	public static function redirect_set( $redirect, $arg_moved, $posts_moved, $blog_id )
	{
		return add_query_arg(
			[
				// self::QUERY_ARG[ 'posts-moved' ] => $posts_moved,
				
				$arg_moved => $posts_moved,

				self::QUERY_ARG[ 'blog-id' ] => $blog_id,
			],
			
			$redirect
		);
	}

	public static function check_doaction( $doaction, $doaction_target = '' )
	{
		if ( empty( $doaction ) )
		{
			$doaction_target = self::DOACTION[ 'move-to' ];
		}

		return str_contains( $doaction, $doaction_target );
	}

	public static function get_blog_id( $doaction )
	{
		return str_replace( self::DOACTION[ 'move-to' ], '', $doaction );
	}
}

?>