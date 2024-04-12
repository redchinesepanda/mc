<?php

class MultisiteSync
{
	const POST_TYPE = [
        'billet' => 'legal_billet',
    ];

	const FIELDS = [
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

	public static function register_functions_admin()
    {
		$handler = new self();

		// add_filter( 'save_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_attachments' ], 10, 2 );
		
		add_filter( 'edit_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_attachments' ], 10, 2 );
	}

	public static function get_subfield_names( $subfields )
	{
		return array_column( $subfields, 'name' );
	}

	public static function get_field_names( $field, $subfields = [] )
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

	public static function get_origin_post_ids( $post_id, $post )
	{
		$origin_post_ids = [];

		$field_names = self::get_field_names( self::FIELDS[ 'about' ], self::FIELD_ABOUT );

		foreach ( $field_names as $field_name )
		{
			if ( $origin_post_id = MultisiteACF::get_field_raw( $field_name, $post_id ) )
			{
				$origin_post_ids[] = $origin_post_id;
			}
		}

		return $origin_post_ids;
	}

	public static function set_attachments( $post_id, $post )
    {
		$origin_post_ids = self::get_origin_post_ids( $post_id, $post );

		LegalDebug::debug( [
			'MultisiteSync' => 'set_attachments',

			'origin_post_ids' => $origin_post_ids,
		] );

		foreach ( $origin_post_ids as $origin_post_id )
		{
			LegalDebug::debug( [
				'MultisiteSync' => 'set_attachments',

				'origin_post_id' => $origin_post_id,
			] );

			if ( $post_moved_id = MultisitePost::get_post_moved_id( $origin_post_id ) )
			{
				MultisiteACF::update_field( $field_name, $post_moved_id, $post_id );

				LegalDebug::debug( [
					'MultisiteSync' => 'set_attachments',
		
					'post_moved_id' => $post_moved_id,
				] );
			}
		}

		LegalDebug::die( [
			'MultisiteSync' => 'set_attachments',
		] );
    }
}

?>