<?php

class MultisitePostSync
{
	const FIELDS_SIMPLE = [
		'tabs-link-url' => [
			'name' => 'tabs-link-url',

			'key' => 'field_642e9f47fd7e0',
		],
		
		'bonus-afillate' => [
			'name' => 'bonus-afillate',

			'key' => 'field_654cae6ee9bc0',
		],
		
		'billet-afillate-link' => [
			'name' => 'billet-afillate-link',

			'key' => 'field_642bf5aae2f50',
		],

		'bonus-afillate' => [
			'name' => 'bonus-afillate',

			'key' => 'field_654cae6ee9bc0',
		],

		'billet-brand' => [
			'name' => 'billet-brand',

			'key' => 'field_65f3e6787cb93',
		],
	];

	const FIELDS_GROUPS = [
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

	public static function get_field_names()
	{
		// return array_column( self::FIELDS, 'name' );

		// $group_field_names = MultisiteAttachmentSync::get_group_field_names( self::FIELDS[ 'review-about' ], self::FIELD_REVIEW_ABOUT );

		// $simple_field_names = [
		// 	self::FIELDS[ 'tabs-link-url' ][ 'name' ],

		// 	self::FIELDS[ 'bonus-afillate' ][ 'name' ],
		// ];
		
		$group_field_names = MultisiteAttachmentSync::get_group_field_names( self::FIELDS_GROUPS[ 'review-about' ], self::FIELD_REVIEW_ABOUT );

		$simple_field_names = array_column( self::FIELDS_SIMPLE, 'name' );

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
			// 	'MultisitePostSync' => 'set_terms',

			// 	'repeater_value' => $repeater_value,
			// ] );
		}
		
		// $fields = MultisiteTermSync::get_fields( $post_id, self::FIELDS );

		$field_names = self::get_field_names();

		// LegalDebug::debug( [
		// 	'MultisitePostSync' => 'set_terms',

		// 	'field_names' => $field_names,
		// ] );
		
		$fields = MultisiteTermSync::get_fields( $post_id, $field_names );

		// LegalDebug::debug( [
		// 	'MultisitePostSync' => 'set_terms',

		// 	'fields' => $fields,
		// ] );

		foreach ( $fields as $field_name => $field_value )
		{
			// LegalDebug::debug( [
			// 	'MultisitePostSync' => 'set_terms',

			// 	'field_name' => $field_name,

			// 	'field_value' => $field_value,
			// ] );

			if ( $field_value_sync = MultisiteTermSync::get_field_value_sync( $field_name, $field_value ) )
			{
				// LegalDebug::debug( [
				// 	'MultisitePostSync' => 'set_terms',

				// 	'field_value_sync' => $field_value_sync,
				// ] );

				MultisiteACF::update_field( $field_name, $field_value_sync, $post_id );

				// LegalDebug::debug( [
				// 	'MultisitePostSync' => 'set_terms',

				// 	'get_field_raw' => MultisiteACF::get_field_raw( $field_name, $post_id ),
				// ] );
			}
		}

		if ( $post_parent_id = self::get_parent( $post_id ) )
		{
			LegalDebug::debug( [
				'MultisitePostSync' => 'set_posts',
	
				'post_parent_id' => $post_parent_id,
			] );

			if ( $post_parent_id_sync = MultisiteTermSync::get_field_value_sync( 'post_parent', $post_parent_id ) )
			{
				LegalDebug::debug( [
					'MultisitePostSync' => 'set_posts',
		
					'post_parent_id_sync' => $post_parent_id_sync,
				] );

				self::set_parent( $post_id, $post_parent_id_sync );
			}
		}

		LegalDebug::die( [
			'MultisitePostSync' => 'set_posts',
		] );
    }

	public static function get_parent( $post_id )
	{
		// $post_parent = get_post_parent( $post_id );

		$post = get_post( $post_id );

		if ( $post )
		{
			$post_parent = $post->post_parent;

			LegalDebug::debug( [
				'MultisitePostSync' => 'set_posts',
	
				'post_id' => $post_id,
	
				'post_parent' => $post_parent,
			] );

			if ( !empty( $post_parent ) )
			{
				// return $post_parent->ID;

				return $post_parent;
			}
		}

		return false;
	}

	public static function set_parent( $post_id, $post_parent_id )
	{
		if ( !empty( $post_parent_id ) )
		{
			$post = [
				'ID' => $post_id,
	
				'post_parent' => $post_parent_id,
			];
	
			MultisitePost::update_post( $post );
		}
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