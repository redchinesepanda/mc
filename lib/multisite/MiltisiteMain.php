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

	public static function rudr_bulk_action_multisite_handler( $redirect, $doaction, $object_ids )
	{
		// we need query args to display correct admin notices

		// $redirect = remove_query_arg( [ self::QUERY_ARG[ 'posts-moved' ], self::QUERY_ARG[ 'blog-id' ] ], $redirect );
		
		$redirect = remove_query_arg( self::QUERY_ARG, $redirect );

		// our actions begin with "move_to_", so let's check if it is a target action

		// if( strpos( $doaction, self::DOACTION[ 'move-to' ] ) === 0 )
		
		if( !str_contains( self::DOACTION[ 'move-to' ], $doaction ) )
		{
			$blog_id = str_replace( self::DOACTION[ 'move-to' ], '', $doaction ); // get blog ID from action name

			foreach ( $object_ids as $post_id )
			{
				// get the original post object as an array
				
				$post = get_post( $post_id, ARRAY_A );
				
				// if you need to apply terms (more info below the code)
				
				$post_terms = wp_get_object_terms( $post_id, 'category', array( 'fields' => 'slugs' ) );
				
				// get all the post meta
				
				$data = get_post_custom( $post_id );
				
				// empty ID field, to tell WordPress to create a new post, not update an existing one
				
				// $post[ 'ID' ] = '';

				switch_to_blog( $blog_id );
				
				// insert the post
				
				$inserted_post_id = wp_insert_post( $post ); // insert the post
				
				// update post terms
				
				wp_set_object_terms( $inserted_post_id, $post_terms, 'category', false );
				
				// add post meta
				foreach ( $data as $key => $values)
				{
					// if you do not want weird redirects

					if( '_wp_old_slug' === $key )
					{
						continue;
					}

					foreach( $values as $value )
					{
						add_post_meta( $inserted_post_id, $key, $value );
					}
				}

				restore_current_blog();

				// if you want just to copy pages, comment this line
				
				// wp_delete_post( $post_id );
			}

			$redirect = add_query_arg(
				[
					self::QUERY_ARG[ 'posts-moved' ] => count( $object_ids ),

					self::QUERY_ARG[ 'blog-id' ] => $blog_id,
				],
				
				$redirect
			);

		}

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
		// $posts_moved = $_REQUEST[ self::QUERY_ARG[ 'posts-moved' ] ];
		
		if ( ! empty( $_REQUEST[ self::QUERY_ARG[ 'posts-moved' ] ] ) )
		{
			// add blog names to notices

			$blog = get_blog_details( $_REQUEST[ self::QUERY_ARG[ 'blog-id' ] ] );

			$message = self::get_message(
				[
					$_REQUEST[ self::QUERY_ARG[ 'posts-moved' ] ],

					$blog->blogname
				]
			);

			// $message = _n( 
			// 	'%d post has been moved to "%s".', 

			// 	'%d posts have been moved to "%s".', 

			// 	$posts_moved
			// );

			// $args = [
            //     'message' => sprintf(
			// 		$message,
					
			// 		$posts_moved,

			// 		$blog->blogname
			// 	),
			// ];
			
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