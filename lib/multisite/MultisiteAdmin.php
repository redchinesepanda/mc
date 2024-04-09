<?php

class MultisiteAdmin
{
	const POST_TYPES = [
		'page' => 'page',

		'post' => 'post',

		'brand' => 'legal_brand',

		'billet' => 'legal_billet',

		'compilation' => 'legal_compilation',
	];
	
	public static function add_filter_all( $name, $object, $handler )
	{
		foreach ( self::POST_TYPES as $post_type )
		{
			add_filter( $name . $post_type, [ $object, $handler ] );
		}
	}

	public static function register_functions_admin()
	{
		$handler = new self();

		// add bulk actions

		self::add_filter_all( 'bulk_actions-edit-', $handler, 'mc_bulk_multisite_actions' );

		// add_filter( 'bulk_actions-edit-page', [ $handler, 'mc_bulk_multisite_actions' ] );

		// add_filter( 'bulk_actions-edit-' . self::POST_TYPES[ 'billet' ], [ $handler, 'mc_bulk_multisite_actions' ] );

		// show an appropriate notice

		add_action( 'admin_notices', [ $handler, 'mc_bulk_multisite_notices' ] );
	}

	const DOACTION = [
		'move-to' => 'move_to_',
	];

	const QUERY_ARG = [
		'posts-moved' => 'mc_posts_moved',
		
		'blog-id' => 'mc_blog_id',
	];

	const PATTERNS = [
		'move-to' => 'Move to [%s]',
	];
	
	public static function mc_bulk_multisite_actions( $bulk_array )
	{
		$sites = get_sites( [
			'site__not_in' => MultisiteBlog::get_current_blog_id(),

			'number' => 32,
		] );
		
		if ( $sites )
		{
			foreach ( $sites as $site )
			{
				// $bulk_array[ self::DOACTION[ 'move-to' ] . $site->blog_id ] = 'Move to [' . $site->blogname . ']';
				
				$bulk_array[ self::DOACTION[ 'move-to' ] . $site->blog_id ] = sprintf( self::PATTERNS[ 'move-to' ], $site->blogname );
			}
		}

		return $bulk_array;
	}

	public static function get_message( $values )
	{
		return ToolLoco::translate_plural(
			MiltisiteMain::TEXT_PLURAL[ 'post-has-been-moved-to' ],

			$values
		);
	}

	public static function mc_bulk_multisite_notices()
	{
		if ( ! empty( $_REQUEST[ self::QUERY_ARG[ 'posts-moved' ] ] ) )
		{
			$blog = MultisiteBlog::get_blog_details( $_REQUEST[ self::QUERY_ARG[ 'blog-id' ] ] );

			$message = self::get_message(
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

	public static function redirect_set( $redirect, $posts_moved, $blog_id )
	{
		return add_query_arg(
			[
				self::QUERY_ARG[ 'posts-moved' ] => $posts_moved,

				self::QUERY_ARG[ 'blog-id' ] => $blog_id,
			],
			
			$redirect
		);
	}

	public static function check_doaction( $doaction )
	{
		return str_contains( $doaction, self::DOACTION[ 'move-to' ] );
	}

	public static function get_blog_id( $doaction )
	{
		return str_replace( self::DOACTION[ 'move-to' ], '', $doaction );
	}
}

?>