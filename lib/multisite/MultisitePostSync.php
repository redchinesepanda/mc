<?php

class MultisitePostSync
{
	const FIELDS = [
		'tabs-link-url' => [
			'name' => 'tabs-link-url',

			'key' => 'field_642e9f47fd7e0',
		],

		'review-about' => [
			'name' => 'review-about',

			'key' => 'field_6437de4fa65c9',
		],
	];

	const FIELD_REVIEW_ABOUT = [
		'about-afillate' => [
			'name' => 'about-afillate',

			'key' => 'field_6437df65a65cf',
		],

		'about-review' => [
			'name' => 'about-review',

			'key' => 'field_6437df65a65cf',
		],

		'about-bonus-id' => [
			'name' => 'about-bonus-id',

			'key' => 'field_64be3a3eccb05',
		],
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
	
	const ROW_FIELDS = [
		'post' => 'post-id',
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
		// return array_column( self::FIELDS, 'name' );

		$group_field_names = MultisiteAttachmentSync::get_group_field_names( self::FIELDS[ 'review-about' ], self::FIELD_REVIEW_ABOUT );

		$simple_field_names = [
			self::FIELDS[ 'tabs-link-url' ][ 'name' ],
		];

		return array_merge( $group_field_names, $simple_field_names );
	}

	public static function set_posts( $post_id )
    {
		$repeaters = MultisiteTermSync::get_repeaters( $post_id, self::FIELDS_REPEATER );

		// LegalDebug::debug( [
		// 	'MultisiteTermSync' => 'set_terms',

		// 	'repeaters' => $repeaters,
		// ] );

		foreach ( $repeaters as $repeater_name => $repeater_value )
		{
			$repeater_value = MultisiteTermSync::sync_repeater( $repeater_name, $repeater_value, self::ROW_FIELDS, self::FIELDS_REPEATER );

			MultisiteACF::update_field( $repeater_name, $repeater_value, $post_id );

			// LegalDebug::debug( [
			// 	'MultisiteTermSync' => 'set_terms',

			// 	'repeater_value' => $repeater_value,
			// ] );
		}
		
		// $fields = MultisiteTermSync::get_fields( $post_id, self::FIELDS );
		
		$fields = MultisiteTermSync::get_fields( $post_id, self::get_field_names() );

		// LegalDebug::debug( [
		// 	'MultisiteTermSync' => 'set_terms',

		// 	'fields' => $fields,
		// ] );

		foreach ( $fields as $field_name => $field_value )
		{
			if ( $field_value_sync = MultisiteTermSync::get_field_value_sync( $field_name, $field_value ) )
			{
				// LegalDebug::debug( [
				// 	'MultisiteTermSync' => 'set_terms',

				// 	'field_name' => $field_name,

				// 	'field_value' => $field_value,

				// 	'field_value_sync' => $field_value_sync,
				// ] );

				MultisiteACF::update_field( $field_name, $field_value_sync, $post_id );

				// LegalDebug::debug( [
				// 	'MultisiteTermSync' => 'set_terms',

				// 	'get_field_raw' => MultisiteACF::get_field_raw( $field_name, $post_id ),
				// ] );
			}
		}

		// LegalDebug::die( [
		// 	'MultisitePostSync' => 'set_posts',
		// ] );
    }

	public static function mc_bulk_action_sync_posts( $redirect, $doaction, $object_ids )
	{
		$redirect = MultisiteAdmin::redirect_clean( $redirect );

		// LegalDebug::debug( [
		// 	'MultisitePostSync' => 'mc_bulk_action_sync_posts',

		// 	'doaction' => $doaction,

		// 	'check_doaction' => MultisiteAdmin::check_doaction( $doaction, MultisiteAdmin::DOACTION[ 'sync-posts' ] ),
		// ] );

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