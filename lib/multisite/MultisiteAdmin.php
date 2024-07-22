<?php

class MultisiteAdmin
{
	const DOACTION = [
		'move-to' => 'move_to_',

		'sync-galleries' => 'mc_sync_galleries',
		
		'sync-shortcodes' => 'mc_sync_shortcodes',

		'sync-terms' => 'mc_sync_terms',

		'sync-attachments' => 'mc_sync_attachments',

		'sync-posts' => 'mc_sync_posts',
	];

	const QUERY_ARG = [
		'posts-moved' => 'mc_posts_moved',
		
		'blog-id' => 'mc_blog_id',

		'attachment-moved' => 'mc_attachment_moved',

		'galleries-synced' => 'mc_galleries_synced',
		
        'shortcodes-synced' => 'mc_shortcodes_synced',

		'terms-synced' => 'mc_terms_synced',

		'attachments-synced' => 'mc_attachments_synced',

		'posts-synced' => 'mc_posts_synced',
	];
	
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

	const POST_TYPES_ATTACHMENT = [
		'attachment' => 'upload',
	];

	const PATTERNS = [
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

	public static function check_multisite_admin()
	{
		return MultisiteMain::check_multisite()
		
			&& MultisiteBlog::check_main_blog();
	}

	public static function register_functions_mainsite()
	{
		// if ( MultisiteBlog::check_main_blog() )
		
		if ( self::check_multisite_admin() )
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

			/* Add site_name as a column */
		
			add_filter( 'wpmu_blogs_columns', [ $handler, 'add_useful_columns' ] );

			/* Populate site_name with blogs site_name */
		
			add_action( 'manage_sites_custom_column', [ $handler, 'column_site_name' ] , 10, 2 );
		}
	}

	public static function add_useful_columns( $site_columns )
	{
		$site_columns[ 'site_name' ] = 'Site Name';

		return $site_columns;
	}

	public static function column_site_name( $column_name, $blog_id )
	{
		$current_blog_details = get_blog_details( [ 'blog_id' => $blog_id ] );

		echo ucwords( $current_blog_details->blogname );
	}

	public static function register_functions_subsite()
	{

		if ( MultisiteBlog::check_not_main_blog() )
		{
			// LegalDebug::debug( [
			// 	'MultisiteAdmin' =>'register_functions_subsite',

			// 	'PATTERNS' => self::PATTERNS[ 'bulk-actions' ],
	
			// 	'get_post_types' => self::get_post_types(),
			// ] );

			$handler = new self();

			self::add_filter_all(
				self::PATTERNS[ 'bulk-actions' ],
				
				self::get_post_types(),
				
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
			$pattern = ToolLoco::translate( MultisiteMain::TEXT[ 'copy-to' ] );

			foreach ( $sites as $site )
			{
				$bulk_array[ self::DOACTION[ 'move-to' ] . $site->blog_id ] = sprintf( $pattern, $site->blogname );
			}
		}

		return $bulk_array;
	}

	public static function mc_bulk_subsite_actions( $bulk_array )
	{
		$bulk_array = array_merge( $bulk_array, [
			self::DOACTION[ 'sync-galleries' ] => ToolLoco::translate( MultisiteMain::TEXT[ 'sync-galleries' ] ),

			self::DOACTION[ 'sync-shortcodes' ] => ToolLoco::translate( MultisiteMain::TEXT[ 'sync-shortcodes' ] ),

			self::DOACTION[ 'sync-terms' ] => ToolLoco::translate( MultisiteMain::TEXT[ 'sync-terms' ] ),

			self::DOACTION[ 'sync-attachments' ] => ToolLoco::translate( MultisiteMain::TEXT[ 'sync-attachments' ] ),

			self::DOACTION[ 'sync-posts' ] => ToolLoco::translate( MultisiteMain::TEXT[ 'sync-posts' ] ),
		] );

		return $bulk_array;
	}

	public static function get_message( $pattern, $values )
	{
		return ToolLoco::translate_plural(
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
				MultisiteMain::TEXT_PLURAL[ 'post-has-been-copied-to' ],

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
		// LegalDebug::die( [
		// 	'MultisiteAdmin' => 'check_request_updated',

		// 	'request' => $request,
		// ] );

		$updated_requests = [
			self::QUERY_ARG[ 'galleries-synced' ],

			self::QUERY_ARG[ 'terms-synced' ],

			self::QUERY_ARG[ 'attachments-synced' ],

			self::QUERY_ARG[ 'posts-synced' ],
		];

		foreach ( $updated_requests as $updated_request )
		{
			if ( ! empty( $_REQUEST[ $updated_request ] ) )
			{
				return $_REQUEST[ $updated_request ];
			}
		}
		
		return false;
	}

	public static function mc_bulk_updated_notices()
	{
		// LegalDebug::debug( [
		// 	'MultisiteAdmin' =>'mc_bulk_updated_notices',

		// 	'_REQUEST' => $_REQUEST,

		// 	'check_request_updated' => self::check_request_updated( $_REQUEST ),
		// ] );

		// if ( ! empty( $_REQUEST[ self::QUERY_ARG[ 'galleries-synced' ] ] ) )
		
		if ( $request_updated = self::check_request_updated( $_REQUEST ) )
		{
			$blog = MultisiteBlog::get_blog_details( $_REQUEST[ self::QUERY_ARG[ 'blog-id' ] ] );

			// LegalDebug::debug( [
			// 	'MultisiteAdmin' =>'mc_bulk_updated_notices',

			// 	'_REQUEST' => $_REQUEST,

			// 	'self::QUERY_ARG' => self::QUERY_ARG,

			// 	'galleries-synced' => self::QUERY_ARG[ 'galleries-synced' ],

			// 	'_REQUEST-QUERY_ARG' => $_REQUEST[ self::QUERY_ARG[ 'galleries-synced' ] ],
			// ] );

			$message = self::get_message(
				MultisiteMain::TEXT_PLURAL[ 'post-has-been-updated' ],

				[
					// $_REQUEST[ self::QUERY_ARG[ 'galleries-synced' ] ], 

					$request_updated,

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
		// LegalDebug::debug( [
		// 	'MultisiteAdmin' => 'mc_bulk_multisite_attachment_notices',

		// 	'QUERY_ARG' => self::QUERY_ARG[ 'attachment-moved' ],

		// 	'_REQUEST' => $_REQUEST[ self::QUERY_ARG[ 'attachment-moved' ] ],

		// 	'not_empty' => ( ! empty( $_REQUEST[ self::QUERY_ARG[ 'attachment-moved' ] ] ) ),
		// ] );

		if ( ! empty( $_REQUEST[ self::QUERY_ARG[ 'attachment-moved' ] ] ) )
		{
			$blog = MultisiteBlog::get_blog_details( $_REQUEST[ self::QUERY_ARG[ 'blog-id' ] ] );

			$message = self::get_message(
				MultisiteMain::TEXT_PLURAL[ 'image-has-been-copied-to' ],

				[
					$_REQUEST[ self::QUERY_ARG[ 'attachment-moved' ] ],

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

	public static function redirect_set( $redirect, $arg_moved, $posts_moved, $blog_id )
	{
		return add_query_arg(
			[
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