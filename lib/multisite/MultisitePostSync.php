<?php

class MultisitePostSync
{
	const FIELDS = [
		// 'tabs-items' => [
		// 	'name' => 'tabs-items',

		// 	'key' => 'field_6423d199c433a',
		// ],
	];

	const FIELDS_REPEATER = [
		'tabs-items' => [
			'name' => 'tabs-items',

			'key' => 'field_6423d199c433a',

			'fields' => [
				'post-id' => [
					'name' => 'tab-compilations',
		
					'key' => 'field_6426c17a847cf',
				],
			],
		],
	];

	public static function register_functions_subsite()
	{
		if ( MultisiteBlog::check_not_main_blog() )
		{
			$handler = new self();

			MultisiteAdmin::add_filter_all(
				MultisiteAdmin::PATTERNS[ 'handle-bulk-actions' ],
				
				MultisiteAdmin::get_post_types_post(),
				
				$handler,
				
				'mc_bulk_action_sync_posts',
				
				10,
				
				3
			);
		}
	}

	// public static function billet_set_brand( $post_id, $post )
    // {
    //     // if ( self::POST_TYPE[ 'billet' ] == $post->post_type )
    //     // {
    //         $args = 0;

    //         $about = get_field( self::GROUP[ 'about' ], $post_id );

    //         if ( $about )
    //         {
    //             if ( $title = $about[ BilletTitle::ABOUT[ 'title' ] ] )
    //             {
    //                 $brands = self::get_brand( $title );

    //                 // LegalDebug::die( [
    //                 //     'ACFBillet' => 'billet_set_brand',

    //                 //     'brands' => $brands,
    //                 // ] );

    //                 $args = array_shift( $brands );
    //             }
    //         }

    //         // LegalDebug::die( [
    //         //     'ACFBillet' => 'billet_set_brand',

    //         //     'args' => $args,
    //         // ] );

    //         if ( !empty( $args ) && empty( get_field( self::GROUP[ 'brand' ], $post_id ) ) )
    //         {
    //             // update_field( self::GROUP[ 'brand' ], $args, $post_id );

	// 			MultisiteACF::update_field( $field_name, $post_moved_id, $post_id );
    //         }
    //     // }
    // }

	public static function get_field_names()
	{
		return array_column( self::FIELDS, 'name' );
	}

	public static function set_posts( $post_id )
    {
		$repeaters = MultisiteTermSync::get_repeaters( $post_id, self::FIELDS_REPEATER );

		LegalDebug::debug( [
			'MultisiteTermSync' => 'set_terms',

			'repeaters' => $repeaters,
		] );

		foreach ( $repeaters as $repeater_name => $repeater_value )
		{
			// $repeater_value = self::sync_repeater( $repeater_name, $repeater_value );

			// MultisiteACF::update_field( $repeater_name, $repeater_value, $post_id );

			LegalDebug::debug( [
				'MultisiteTermSync' => 'set_terms',

				'repeater_value' => $repeater_value,
			] );
		}
		
		// $origin_post_ids = self::get_origin_post_ids( $post_id, $post );

		// $field_names = self::get_field_names();
		
		// $origin_post_ids = MultisiteAttachmentSync::get_origin_post_ids( $post_id, $field_names );

		// LegalDebug::die( [
		// 	'MultisitePostSync' => 'set_posts',

		// 	'origin_post_ids' => $origin_post_ids,
		// ] );

		// foreach ( $origin_post_ids as $field_name => $origin_post_id )
		// {
		// 	// LegalDebug::debug( [
		// 	// 	'MultisitePostSync' => 'set_posts',

		// 	// 	'origin_post_id' => $origin_post_id,
		// 	// ] );

		// 	if ( $post_moved_id = MultisitePost::get_post_moved_id( $origin_post_id ) )
		// 	{
		// 		// LegalDebug::debug( [
		// 		// 	'MultisitePostSync' => 'set_posts',
		
		// 		// 	'post_moved_id' => $post_moved_id,
		// 		// ] );

		// 		// MultisiteACF::update_field( $field_name, $post_moved_id, $post_id );
		// 	}
		// }

		LegalDebug::die( [
			'MultisitePostSync' => 'set_posts',
		] );
    }

	public static function mc_bulk_action_sync_posts( $redirect, $doaction, $object_ids )
	{
		$redirect = MultisiteAdmin::redirect_clean( $redirect );

		LegalDebug::debug( [
			'MultisitePostSync' => 'mc_bulk_action_sync_posts',

			'doaction' => $doaction,

			'check_doaction' => MultisiteAdmin::check_doaction( $doaction, MultisiteAdmin::DOACTION[ 'sync-posts' ] ),
		] );

		if ( MultisiteAdmin::check_doaction( $doaction, MultisiteAdmin::DOACTION[ 'sync-posts' ] ) )
		{
			foreach ( $object_ids as $post_id )
			{
				self::set_posts( $post_id );
			}

			$redirect = MultisiteAdmin::redirect_set(
				$redirect,
				
				MultisiteAdmin::QUERY_ARG[ 'posts-synced' ],
				
				count( $object_ids ),
				
				MultisiteBlog::get_current_blog_id()
			);
		}

		return $redirect;
	}
}

?>