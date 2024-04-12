<?php

class MultisitePost
{
	public static function register_functions_admin()
	{
		$handler = new self();

		// move or copy posts to blog

		// MultisiteAdmin::add_filter_all( 'handle_bulk_actions-edit-', $handler, 'mc_bulk_action_multisite_handler', 10, 3 );
		
		MultisiteAdmin::add_filter_all(
			MultisiteAdmin::PATTERNS[ 'handle-bulk-actions' ],
			
			MultisiteAdmin::POST_TYPES_POST,
			
			$handler,
			
			'mc_bulk_action_multisite_handler',
			
			10,
			
			3
		);
	}

	public static function mc_bulk_action_multisite_handler( $redirect, $doaction, $object_ids )
	{
		// $redirect = self::retirect_clean( $redirect );
		
		$redirect = MultisiteAdmin::redirect_clean( $redirect );
		
		if ( MultisiteAdmin::check_doaction( $doaction ) )
		{
			$blog_id = MultisiteAdmin::get_blog_id( $doaction );

			foreach ( $object_ids as $post_id )
			{
				if ( $post = self::get_post( $post_id ) )
				{
					$post_terms = MultisiteTerms::get_post_terms( $post_id );
					
					$post_meta = MultisiteMeta::get_post_meta( $post_id );
					
					$post_fields = MultisiteACF::get_fields( $post_id );

					// LegalDebug::debug( [
					// 	'MultisiteMain' => 'mc_bulk_action_multisite_handler',

					// 	'post' => $post[ 'ID' ],

                    //     // 'post_terms-count' => count( $post_terms ),

                    //     // 'post_terms' => $post_terms,

                    //     // 'post_meta-count' => count( $post_meta ),

                    //     // 'post_meta' => $post_meta,

					// 	'post_fields' => $post_fields,
					// ] );

					// self::add_post_and_data( $blog_id, $post, $post_terms, $post_meta, $post_fields );

					if ( $inserted_post_id = self::add_post_and_data( $blog_id, $post, $post_terms, $post_meta, $post_fields) )
					{
						MultisiteMeta::set_post_moved( $post_id, $blog_id, $inserted_post_id );

						LegalDebug::debug( [
							'MultisiteMain' => 'mc_bulk_action_multisite_handler',

							'inserted_post_id' => $inserted_post_id,
						] );
					}
				}
			}

			LegalDebug::debug( [
				'MultisiteMain' => 'mc_bulk_action_multisite_handler',

				'blog_id' => $blog_id,
			] );

			// $redirect = MultisiteAdmin::redirect_set( $redirect, count( $object_ids ), $blog_id );
			
			$redirect = MultisiteAdmin::redirect_set( $redirect, MultisiteAdmin::QUERY_ARG[ 'posts-moved' ], count( $object_ids ), $blog_id );
		}

		LegalDebug::die( [
			'MultisiteMain' => 'rudr_bulk_action_multisite_handler',

			'redirect' => $redirect,

			'doaction' => $doaction,

			'check_doaction' => self::check_doaction( $doaction ),
		] );

		return $redirect;
	}

	public static function get_post( $post_id )
	{
		return get_post( $post_id, ARRAY_A );
	}

	public static function add_post_and_data( $blog_id, $post, $post_terms, $post_meta, $post_fields )
	{
		$inserted_post_id = false;

		$post_moved_id = MultisiteMeta::get_moved( $post, $blog_id );

		LegalDebug::die( [
			'MultisiteMain' => 'add_post_and_data',

			'post_moved_id' => $post_moved_id,
		] );

		MultisiteBlog::set_blog( $blog_id );

		// if ( MultisiteMeta::check_not_moved( $post_moved_id ) )
		// {
			if ( $inserted_post_id = self::add_post( $post, $blog_id, $post_moved_id ) )
			{
				MultisiteTerms::add_post_terms( $inserted_post_id, $post_terms );

				MultisiteMeta::add_post_meta( $inserted_post_id, $post_meta );

				MultisiteACF::add_fields( $inserted_post_id, $post_fields );

				// LegalDebug::die( [
				// 	'MultisiteMain' => 'add_post_and_data',

				// 	'get_fields' => MultisiteACF::get_fields( $inserted_post_id ),
				// ] );
			}
		// }

		MultisiteBlog::restore_blog();

		return $inserted_post_id;
	}

	public static function add_post( $post, $blog_id, $post_moved_id )
	{
		$post_id = $post[ 'ID' ];

		$post = self::prepare_post( $post, $blog_id, $post_moved_id );

		$inserted_post_id = wp_insert_post( $post );

		LegalDebug::debug( [
			'MultisiteMain' => 'add_post',

			'post_id' => $post_id,

			'ID' => $post[ 'ID' ],

			'inserted_post_id' => $inserted_post_id,
		] );

		if ( is_wp_error( $inserted_post_id ) )
		{
			return false;
		}

		if ( $inserted_post_id === 0 )
		{
			return $post_moved_id;
		}

		// LegalDebug::debug( [
		// 	'MultisiteMain' => 'add_post',

		// 	'blog_id' => $post_id,

		// 	'inserted_post_id' => $inserted_post_id,
		// ] );

		// if ( $inserted_post_id !== 0 )
		// {
		// 	MultisiteMeta::set_post_moved( $post_id, $blog_id, $inserted_post_id );
		// }

		return $inserted_post_id;
	}

	public static function prepare_post( $post, $blog_id, $post_moved_id )
	{
		if ( MultisiteMeta::check_not_moved( $post_moved_id ) )
		{
			unset( $post[ 'ID' ] );
		}
		else
		{
			$post[ 'ID' ] = $post_moved_id;
		}

		return $post;

		// if ( $moved_id = MultisiteMeta::check_post_moved( $post, $blog_id ) )
		// {
		// 	$post[ 'ID' ] = $moved_id;
		// }
		// else
		// {
		// 	unset( $post[ 'ID' ] );
		// }
	}
}

?>