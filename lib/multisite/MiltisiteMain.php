<?php

class MiltisiteMain
{
	public static function register_functions()
	{
		$handler = new self();

		// add bulk actions

		add_filter( 'bulk_actions-edit-page', [ $handler, 'rudr_my_bulk_multisite_actions' ] );

		// move or copy posts to blog

		add_filter( 'handle_bulk_actions-edit-page', [ $handler, 'rudr_bulk_action_multisite_handler' ], 10, 3 );

		// show an appropriate notice

		add_action( 'admin_notices', [ $handler, 'rudr_bulk_multisite_notices' ] );
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

		foreach( $taxonomies as $taxonomy )
		{
			$result[ $taxonomy ] = wp_get_object_terms( $post_id, $taxonomy, [ 'fields' => 'slugs' ] );
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

	public static function add_post( $post )
	{
		$post_id = wp_insert_post( $post );

		if ( is_wp_error( $post_id ) )
		{
			return false;
		}

		return $post_id;
	}

	public static function add_post_terms( $post_id, $result )
	{
		foreach( $result as $taxonomy => $post_terms )
		{
			wp_set_object_terms( $post_id, $post_terms, $taxonomy, false );
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

		if ( $post_id = self::add_post( $post ) )
		{
			self::add_post_terms( $post_id );

			self::add_post_meta( $post_id, $post_meta );

			return true;
		}

		restore_current_blog();

		return false;
	}

	public static function check_doaction( $doaction )
	{
		// LegalDebug::debug( [
		// 	'MultisiteMain' => 'check_doaction',

		// 	'doaction' => $doaction,

		// 	'move-to' => self::DOACTION[ 'move-to' ],
        // ] );

		return str_contains( $doaction, self::DOACTION[ 'move-to' ] );
	}

	public static function get_blog_id( $doaction )
	{
		return str_replace( self::DOACTION[ 'move-to' ], '', $doaction );
	}

	public static function check_post_exists( &$post )
	{
		if ( !get_post_status( $post[ 'ID' ] ) )
		{
			$post[ 'ID' ] = '';

			return false;
		}

		return true;
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
					// empty ID field, to tell WordPress to create a new post, not update an existing one
				
					self::check_post_exists( $post );

					$post_terms = self::get_post_terms( $post_id );
					
					$post_meta = self::get_post_meta( $post_id );

					// LegalDebug::die( [
					// 	'MultisiteMain' => 'rudr_bulk_action_multisite_handler',

					// 	'post' => $post[ 'ID' ],

                    //     'post_terms' => count( $post_terms ),

                    //     'post_meta-count' => count( $post_meta ),

                    //     // 'post_meta' => $post_meta,
					// ] );

					self::add_post_and_data( $blog_id, $post, $post_terms, $post_meta );
				}
			}

			LegalDebug::die( [
				'MultisiteMain' => 'rudr_bulk_action_multisite_handler',

				'blog_id' => $blog_id,
			] );

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