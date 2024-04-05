<?php

class MiltisiteMain
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'init', [ $handler, 'mc_init_blog' ] );
	}

	const VIRTUAL_BLOG = [
		[
			'from' => [
				'domain' => 'test.match.center',
				
				'path' => '/kz/',
			],

			'to' => [
				'domain' => 'testkz.match.center',
			],
		],
	];

	function mc_init_blog()
	{
		$sites = get_sites( [
			'site__not_in' => self::get_current_blog_id(),

			'number' => 32,
		] );

		LegalDebug::debug( [
			'MultisiteMain' => 'mc_init_blog',

			'sites' => $sites,
		] );

		self::set_blog( 2 );
	}
	
	public static function register_functions_admin()
	{
		$handler = new self();

		// add bulk actions

		add_filter( 'bulk_actions-edit-page', [ $handler, 'rudr_my_bulk_multisite_actions' ] );

		// move or copy posts to blog

		add_filter( 'handle_bulk_actions-edit-page', [ $handler, 'rudr_bulk_action_multisite_handler' ], 10, 3 );

		// show an appropriate notice

		add_action( 'admin_notices', [ $handler, 'rudr_bulk_multisite_notices' ] );
	}

	public static function set_blog( $blog_id )
	{
		switch_to_blog( $blog_id );
	}

	public static function restore_blog()
	{
		restore_current_blog();
	}

	public static function get_current_blog_id()
	{
		return get_current_blog_id();
	}
	
	public static function rudr_my_bulk_multisite_actions( $bulk_array )
	{
		$sites = get_sites( [
			// 'site__in' => array( 1,2,3 ),

			'site__not_in' => self::get_current_blog_id(), // excluding current blog

			'number' => 50,
		] );
		
		if ( $sites )
		{
			foreach( $sites as $site )
			{
				$bulk_array[ self::DOACTION[ 'move-to' ] . $site->blog_id ] = 'Move to [' . $site->blogname . ']';
			}
		}

		return $bulk_array;
	}

	const QUERY_ARG = [
		'posts-moved' => 'mc_posts_moved',
		
		'blog-id' => 'mc_blog_id',
	];

	const DOACTION = [
		'move-to' => 'move_to_',
	];

	public static function retirect_clean( $redirect )
	{
		return remove_query_arg( self::QUERY_ARG, $redirect );
	}

	public static function retirect_set( $redirect, $posts_moved, $blog_id )
	{
		return add_query_arg(
			[
				self::QUERY_ARG[ 'posts-moved' ] => $posts_moved,

				self::QUERY_ARG[ 'blog-id' ] => $blog_id,
			],
			
			$redirect
		);
	}

	public static function get_post( $post_id )
	{
		return get_post( $post_id, ARRAY_A );
	}

	const TAXONOMIES_WP = [
		'category' => 'category',

		'post-tag' => 'post_tag',
	];

	const TAXONOMIES_PAGE = [
		'page-type' => 'page_type',

		'offer-group' => 'offer_group',

		'page-group' => 'page_group',
	];

	const TAXONOMIES_BILLET = [
		'billet-achievement' => 'billet_achievement',

		'billet-type' => 'billet_type',

		'billet-feature' => 'billet_feature',
	];

	const TAXONOMIES_ATTACHMENT = [
		'media-type' => 'media_type',
	];

	public static function get_taxonomies()
	{
		return array_merge( self::TAXONOMIES_WP, self::TAXONOMIES_PAGE, self::TAXONOMIES_BILLET, self::TAXONOMIES_ATTACHMENT );
	}

	public static function get_post_terms( $post_id )
	{
		$taxonomies = self::get_taxonomies();

		$result = [];

		foreach ( $taxonomies as $taxonomy )
		{
			if ( $terms = wp_get_object_terms( $post_id, $taxonomy, [ 'fields' => 'slugs' ] ) )
			{
				$result[ $taxonomy ] = $terms;
			}
		}

		// return wp_get_object_terms( $post_id, self::get_taxonomies(), [ 'fields' => 'slugs' ] );

		return $result;
	}

	const FILTER_META = [
		'_tve_js_modules_gutenberg',

		'tve_global_scripts',

		'thrive_element_visibility',

		'google_post_content',
	];

	public static function filter_not_thrive( $meta_key )
	{
		return !in_array( $meta_key, self::FILTER_META );
	}

	public static function get_post_meta( $post_id )
	{
		// return get_post_custom( $post_id );

		$handler = new self();

        return array_filter( get_post_custom( $post_id ), [ $handler, 'filter_not_thrive' ], ARRAY_FILTER_USE_KEY );
	}

	public static function add_post( $post, $blog_id )
	{
		$post_id = $post[ 'ID' ];

		$post = self::prepare_post( $post, $blog_id );

		$inserted_post_id = wp_insert_post( $post );

		if ( is_wp_error( $inserted_post_id ) )
		{
			return false;
		}

		// LegalDebug::debug( [
		// 	'MultisiteMain' => 'add_post',

		// 	'blog_id' => $post_id,

		// 	'inserted_post_id' => $inserted_post_id,
		// ] );

		if ( $inserted_post_id !== 0 )
		{
			self::set_post_moved( $post_id, $blog_id, $inserted_post_id );
		}

		return $inserted_post_id;
	}

	public static function add_post_terms( $post_id, $result )
	{
		// LegalDebug::debug( [
		// 	'MultisiteMain' => 'add_post_terms',

		// 	'post_id' => $post_id,

		//     'result-count' => count( $result ),

		//     'result' => $result,
		// ] );
		
		foreach ( $result as $taxonomy => $post_terms )
		{
			$object_terms = wp_set_object_terms( $post_id, $post_terms, $taxonomy, false );

			// LegalDebug::debug( [
			// 	'MultisiteMain' => 'add_post_terms',

			// 	'object_terms' => $object_terms,
			// ] );
		}
	}

	public static function add_post_meta( $post_id, $post_meta )
	{
		foreach ( $post_meta as $key => $values )
		{
			// if you do not want weird redirects

			if( '_wp_old_slug' === $key )
			{
				continue;
			}

			foreach ( $values as $value )
			{
				update_post_meta( $post_id, $key, $value );
			}
		}

		return true;
	}

	public static function add_post_and_data( $blog_id, $post, $post_terms, $post_meta )
	{
		switch_to_blog( $blog_id );

		if ( $post_id = self::add_post( $post, $blog_id ) )
		{
			self::add_post_terms( $post_id, $post_terms );

			self::add_post_meta( $post_id, $post_meta );
		}

		restore_current_blog();
	}

	public static function check_doaction( $doaction )
	{
		return str_contains( $doaction, self::DOACTION[ 'move-to' ] );
	}

	public static function get_blog_id( $doaction )
	{
		return str_replace( self::DOACTION[ 'move-to' ], '', $doaction );
	}

	const POST_META = [
		'moved-to' => 'mc_moved_to',
    ];

	public static function get_post_moved( $post_id )
	{
		return get_post_meta( $post_id, self::POST_META[ 'moved-to' ], true );
	}

	public static function set_post_moved( $post_id, $blog_id, $moved_post_id )
	{
		$meta_value = self::get_post_moved( $post_id );

		// $meta_value = array_merge( $meta_value, [ $blog_id => $moved_post_id ] );

		// LegalDebug::debug( [
		// 	'MultisiteMain' =>'set_post_moved',

		// 	'meta_value' => $meta_value,
		// ] );
		
		$meta_value = [ $blog_id => $moved_post_id ];

		update_post_meta( $post_id, self::POST_META[ 'moved-to' ], $meta_value );
	}

	public static function check_post_moved( $post, $blog_id )
	{
		$post_moved = self::get_post_moved( $post[ 'ID' ] );

		// LegalDebug::debug( [
		// 	'MultisiteMain' => 'check_post_moved',
			
		// 	'ID' => $post[ 'ID' ],

		// 	'post_moved' => $post_moved,

		// 	'get_post_status' => get_post_status( $post_moved[ $blog_id ] ),
		// ] );

		if ( array_key_exists( $blog_id, $post_moved ) )
		{
			if ( get_post_status( $post_moved[ $blog_id ] ) )
			{
				return $post_moved[ $blog_id ];
			}
		}

		return false;
	}

	public static function prepare_post( $post, $blog_id )
	{
		if ( $moved_id = self::check_post_moved( $post, $blog_id ) )
		{
			$post[ 'ID' ] = $moved_id;
		}
		else
		{
			unset( $post[ 'ID' ] );
		}

		return $post;
	}

	public static function rudr_bulk_action_multisite_handler( $redirect, $doaction, $object_ids )
	{
		$redirect = self::retirect_clean( $redirect );
		
		if ( self::check_doaction( $doaction ) )
		{
			$blog_id = self::get_blog_id( $doaction );

			foreach ( $object_ids as $post_id )
			{
				if ( $post = self::get_post( $post_id ) )
				{
					$post_terms = self::get_post_terms( $post_id );
					
					$post_meta = self::get_post_meta( $post_id );

					// LegalDebug::die( [
					// 	'MultisiteMain' => 'rudr_bulk_action_multisite_handler',

					// 	'post' => $post[ 'ID' ],

                    //     'post_terms-count' => count( $post_terms ),

                    //     'post_terms' => $post_terms,

                    //     'post_meta-count' => count( $post_meta ),

                    //     'post_meta' => $post_meta,
					// ] );

					self::add_post_and_data( $blog_id, $post, $post_terms, $post_meta );
				}
			}

			// LegalDebug::die( [
			// 	'MultisiteMain' => 'rudr_bulk_action_multisite_handler',

			// 	'blog_id' => $blog_id,
			// ] );

			$redirect = self::retirect_set( $redirect, count( $object_ids ), $blog_id );
		}

		// LegalDebug::die( [
		// 	'MultisiteMain' => 'rudr_bulk_action_multisite_handler',

		// 	'redirect' => $redirect,

		// 	'doaction' => $doaction,

		// 	'check_doaction' => self::check_doaction( $doaction ),
		// ] );

		return $redirect;
	}

	const TEMPLATE = [
        'multisite-notices' => LegalMain::LEGAL_PATH . '/template-parts/multisite/part-multisite-notices.php',
    ];

	public static function print_notices( $args )
    {
        LegalComponents::print_main( self::TEMPLATE[ 'multisite-notices' ], $args );
    }

	public static function get_message( $values )
	{
		return ToolLoco::translate_plural(
			self::TEXT_PLURAL[ 'post-has-been-moved-to' ],

			$values
		);
	}

	public static function rudr_bulk_multisite_notices()
	{
		if ( ! empty( $_REQUEST[ self::QUERY_ARG[ 'posts-moved' ] ] ) )
		{
			$blog = get_blog_details( $_REQUEST[ self::QUERY_ARG[ 'blog-id' ] ] );

			$message = self::get_message(
				[
					$_REQUEST[ self::QUERY_ARG[ 'posts-moved' ] ],

					$blog->blogname
				]
			);
			
			$args = [
                'message' => $message,
			];

			self::print_notices( $args );
		}
	}

	const TEXT_PLURAL = [
		'post-has-been-moved-to' => [
			'single' => '%d post has been moved to "%s".',

			'plural' => '%d posts have been moved to "%s".',
		],
	];
}

?>