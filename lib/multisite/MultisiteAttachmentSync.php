<?php

class MultisiteAttachmentSync
{
	const POST_TYPE = [
        'billet' => 'legal_billet',

        'page' => 'page',
    ];

	// const FIELDS = [
	// 	'about' => [
	// 		'name' => 'review-about',

	// 		'key' => 'field_6437de4fa65c9',
	// 	],

	// 	'affilate-logo' => [
	// 		'name' => 'affilate-logo',

	// 		'key' => 'field_64525762b2d69',
	// 	],

	// 	// 'compilation-title-image' => [
	// 	// 	'name' => 'compilation-title-image',

	// 	// 	'key' => 'field_642e95492dd4d',
    //     // ],
		
	// 	'img-bk' => [
	// 		'name' => 'img-bk',

	// 		'key' => 'field_6269173a3979f',
    //     ],

	// 	'logo_bk_mini' => [
	// 		'name' => 'logo_bk_mini',

	// 		'key' => 'field_626a36c948503',
    //     ],
	// ];

	const FIELDS_SIMPLE = [
		'affilate-logo' => [
			'name' => 'affilate-logo',

			'key' => 'field_64525762b2d69',
		],

		// 'compilation-title-image' => [
		// 	'name' => 'compilation-title-image',

		// 	'key' => 'field_642e95492dd4d',
        // ],
		
		'img-bk' => [
			'name' => 'img-bk',

			'key' => 'field_6269173a3979f',
        ],

		'logo_bk_mini' => [
			'name' => 'logo_bk_mini',

			'key' => 'field_626a36c948503',
        ],

		'_thumbnail_id' => [
			'name' => '_thumbnail_id',

			'key' => '',
        ],
	];

	const FIELDS_GROUPS = [
		'about' => [
			'name' => 'review-about',

			'key' => 'field_6437de4fa65c9',
		],
	];

	const FIELD_ABOUT = [
		'logo' => [
			'name' => 'about-logo',

			'key' => 'field_6437df25a65cd',
		],

		'logo-contrast' => [
			'name' => 'about-logo-mega',

			'key' => 'field_64c23d34d8c9a',
		],

		'logo-square' => [
			'name' => 'about-logo-square',

			'key' => 'field_64490745cce76',
		],
	];

	const PATTERNS = [
		'group-field' => '%1$s_%2$s',
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
				
				'mc_bulk_action_sync_attachments',
				
				10,
				
				3
			);

			// LegalDebug::debug( [
			// 	'MultisiteAttachmentSync' =>'register_functions_subsite',
			// ] );
		}
	}

	public static function mc_bulk_action_sync_attachments( $redirect, $doaction, $object_ids )
	{
		$redirect = MultisiteAdmin::redirect_clean( $redirect );

		// LegalDebug::debug( [
		// 	'MultisiteAttachmentSync' =>'mc_bulk_action_sync_attachments',

		// 	'doaction' => $doaction,

		// 	'check_doaction' => MultisiteAdmin::check_doaction( $doaction, MultisiteAdmin::DOACTION[ 'sync-attachments' ] )
		// ] );

		if ( MultisiteAdmin::check_doaction( $doaction, MultisiteAdmin::DOACTION[ 'sync-attachments' ] ) )
		{
			foreach ( $object_ids as $post_id )
			{
				// if ( $post = MultisitePost::get_post( $post_id ) )
				// {
				// 	self::set_attachments( $post[ 'ID' ], $post );
				// }

				self::set_attachments( $post_id );
			}

			$redirect = MultisiteAdmin::redirect_set(
				$redirect,
				
				MultisiteAdmin::QUERY_ARG[ 'attachments-synced' ],
				
				count( $object_ids ),
				
				MultisiteBlog::get_current_blog_id()
			);

			// LegalDebug::die( [
			// 	'MultisiteAttachmentSync' =>'mc_bulk_action_sync_attachments',

			// 	'redirect' => $redirect,
			// ] );
		}

		return $redirect;
	}

	public static function get_subfield_names( $subfields )
	{
		return array_column( $subfields, 'name' );
	}

	public static function get_group_field_names( $field, $subfields = [] )
	{
		$field_names = [];

		$subfield_names = self::get_subfield_names( $subfields );

		foreach ( $subfield_names as $subfield_name )
		{
			$field_names[] = sprintf(
				self::PATTERNS[ 'group-field' ],
				
				$field[ 'name' ],
	
				$subfield_name
			);
		}

		return $field_names;
	}

	public static function get_field_names()
	{
		// return array_merge(
		// 	self::get_group_field_names( self::FIELDS[ 'about' ], self::FIELD_ABOUT ),

		// 	[
		// 		self::FIELDS[ 'affilate-logo' ][ 'name' ],

		// 		self::FIELDS[ 'compilation-title-image' ][ 'name' ],
		// 	]
		// );

		$group_field_names = self::get_group_field_names( self::FIELDS_GROUPS[ 'about' ], self::FIELD_ABOUT );

		// $simple_field_names = [
		// 	self::FIELDS[ 'affilate-logo' ][ 'name' ],

		// 	// self::FIELDS[ 'compilation-title-image' ][ 'name' ],

		// 	self::FIELDS[ 'compilation-title-image' ][ 'name' ],

		// 	self::FIELDS[ 'compilation-title-image' ][ 'name' ],
		// ];

		$simple_field_names = array_column( self::FIELDS_SIMPLE, 'name' );

		// LegalDebug::debug( [
		// 	'MultisiteAttachmentSync' => 'get_field_names',

		// 	'group_field_names' => $group_field_names,

		// 	'simple_field_names' => $simple_field_names,
		// ] );

		// return [];

		return array_merge( $group_field_names, $simple_field_names );
	}
	
	// public static function get_post_thumbnail_ids( $post_id )
	// {
	// 	if ( is_single( $post_id ) )
	// 	{
	// 		if ( $post_thumbnail_id = get_post_thumbnail_id( $post_id ) )
	// 		{
	// 			return [
	// 				'post_thumbnail_id' => $post_thumbnail_id,
	// 			];
	// 		}
	// 	}

	// 	return [];
	// }

	public static function get_origin_post_ids( $post_id , $field_names = [] )
	{
		$origin_post_ids = [];

		// $field_names = self::get_group_field_names( self::FIELDS[ 'about' ], self::FIELD_ABOUT );

		if ( empty( $field_names ) )
		{
            $field_names = self::get_field_names();
        }

		// LegalDebug::debug( [
		// 	'MultisiteAttachmentSync' => 'get_origin_post_ids',

		// 	'field_names' => $field_names,
		// ] );

		// $field_names = self::get_field_names();

		foreach ( $field_names as $field_name )
		{
			if ( $origin_post_id = MultisiteACF::get_field_raw( $field_name, $post_id ) )
			{
				$origin_post_ids[ $field_name ] = $origin_post_id;
			}
		}

		// LegalDebug::debug( [
		// 	'MultisiteAttachmentSync' => 'get_origin_post_ids',

		// 	'origin_post_ids' => $origin_post_ids,
		// ] );

		return $origin_post_ids;
	}

	// public static function set_attachments( $post_id, $post )
	
	public static function set_attachments( $post_id )
    {
		// $origin_post_ids = self::get_origin_post_ids( $post_id, $post );
		
		$origin_post_ids = self::get_origin_post_ids( $post_id );

		// LegalDebug::debug( [
		// 	'MultisiteAttachmentSync' => 'set_attachments',

		// 	'origin_post_ids' => $origin_post_ids,
		// ] );

		foreach ( $origin_post_ids as $field_name => $origin_post_id )
		{
			LegalDebug::debug( [
				'MultisiteAttachmentSync' => 'set_attachments',

				'origin_post_id' => $origin_post_id,
			] );

			if ( $post_moved_id = MultisitePost::get_post_moved_id( $origin_post_id ) )
			{
				MultisiteACF::update_field( $field_name, $post_moved_id, $post_id );

				LegalDebug::debug( [
					'MultisiteAttachmentSync' => 'set_attachments',
		
					'post_moved_id' => $post_moved_id,
				] );
			}
		}

		LegalDebug::die( [
			'MultisiteAttachmentSync' => 'set_attachments',
		] );
    }
}

?>